<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\UserAddress;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->alamat->count() == 0) {
            return redirect()->route('profil')->with('error', 'Anda harus memiliki alamat terlebih dahulu');
        }

        if ($user->cart->count() == 0 && !$request->has('produk_id') && !$request->has('jumlah')) {
            return redirect()->route('profil')->with('error', 'Anda harus memiliki keranjang belanja terlebih dahulu');
        }

        $total = 0;

        $order = new Order();
        $order->user_id = $user->id;
        $order->no_order = 'PU' . '-' . rand(1000, 9999) . '-' . date('Y');
        $order->address_id = $user->alamat->first()->id;
        $order->kurir = 'jne';
        $order->total = $total;
        $order->save();

        $berat = $user->getCartWeight();
        if ($request->has('produk_id') && $request->has('jumlah')) {
            $produk = Product::where('id', $request->produk_id)->first();
            $order->items()->create([
                'product_id' => $request->produk_id,
                'quantity' => $request->jumlah,
            ]);
            $berat = $produk->weight * $request->jumlah;
            $total = $produk->price * $request->jumlah;
        } else {
            foreach ($user->cart as $cart) {
                $order->items()->create([
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                ]);
            }
            $total = $user->getCartTotal();
        }

        $getOngkir = RajaOngkirController::getCost(358, $user->alamat->first()->id, $berat,  'jne');
        $ongkirCost = $getOngkir['rajaongkir']['results'][0]['costs'][0];

        $order->service = $ongkirCost['service'];
        $order->etd =  explode(' ', $ongkirCost['cost'][0]['etd'])[0] . ' HARI';
        $order->harga_ongkir = $ongkirCost['cost'][0]['value'];
        $order->resi = '-';
        $order->total = $total + $ongkirCost['cost'][0]['value'];
        $order->save();

        $user->cart()->delete();
        return redirect()->route('checkout', $order);
    }

    public function checkout(Order $order)
    {
        $user = Auth::user();
        $alamat = $user->alamat;
        $items = $order->items;

        $kurir = $order->kurir;
        $kota = $order->alamat->id;

        $getOngkir = RajaOngkirController::getCost(358, $kota, $order->getOrderWeight(),  $kurir);
        $dataongkir = $getOngkir['rajaongkir']['results'][0];

        if ($order->token == null) {
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->no_order . '|' . time(),
                    'gross_amount' => $order->total,
                ),
                'customer_details' => array(
                    'first_name' => $user->name,
                    'last_name' => '',
                    'email' => $user->email,
                    'phone' => $user->phone,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } else {
            $snapToken = $order->token;
        }

        return view('checkout', compact('order', 'items', 'alamat', 'dataongkir', 'snapToken'));
    }

    public function callback(Request $request)
    {
        $data = json_decode($request->callback);
        $getOrder = Order::where('token', $data->token)->first();
        if (!$getOrder) {
            $order = Order::where('no_order', explode('|', $data->order_id)[0])->get()->first();
            $order->token = $data->token;
            $order->save();

            Transaction::create([
                'order_id' => $order->id,
                'mt_order_id' => $data->order_id,
                'mt_transaction_id' => $data->transaction_id,
                'transaction_status' => $data->transaction_status,
                'status_message' => $data->status_message,
                'payment_type' => $data->payment_type ?? '',
                'payment_code' => $data->payment_code ?? '',
                'store' => $data->store ?? '',
                'settlement_time' => $data->settlement_time ?? '',
                'response' => $request->callback,
            ]);
        }

        $message = "Terima Kasih, Menunggu pembayaran selesai. pesanan anda anda akan diproses setelah pembayaran selesai";

        if (in_array($data->transaction_status, ['settlement', 'success'])) {
            $order->status = 'processing';
            $order->save();

            $message = "Terima Kasih, Pembayaran berhasil. pesanan anda sedang diproses";
        }

        return redirect()->route('profil')->with('success', $message);
    }

    public function notification()
    {
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if (in_array($transaction, ['settlement', 'success', 'capture'])) {
            $order = Order::where('no_order', explode('|', $order_id)[0])->get()->first();
            $order->status = 'processing';
            $order->save();
        }

        $transactions = Transaction::where('mt_order_id', $order_id)->get()->first();

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $message = "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    $message = "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            $message = "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }

        $transactions->transaction_status = $transaction;
        $transactions->status_message = $message;
        $transactions->payment_type = $type;
        $transactions->payment_code = '';
        $transactions->store = $notif->store ?? '';
        $transactions->settlement_time = $notif->settlement_time;
        $transactions->save();

        return response()->json(['status' => 'success']);
    }

    public function editAlamat(Request $request, Order $order)
    {
        $new_service = $request->service;
        if ($new_service == null) {
            return redirect()->back();
        }
        $getOngkir = RajaOngkirController::getCost(358, $request->alamat, $order->getOrderWeight(),  $request->kurir);
        $dataongkir = $getOngkir['rajaongkir']['results'][0];
        $dataongkirbaru = collect($dataongkir['costs'])->filter(function ($item) use ($new_service) {
            return $item['service'] == $new_service;
        })->first();

        $order->address_id = $request->alamat;
        $order->harga_ongkir = $dataongkirbaru['cost'][0]['value'];
        $order->kurir = $request->kurir;
        $order->service = $new_service;
        $order->etd =  explode(' ', $dataongkirbaru['cost'][0]['etd'])[0] . ' HARI';
        $order->total = $order->getOrderTotal() + $dataongkirbaru['cost'][0]['value'];
        $order->save();

        return redirect()->route('checkout', $order);
    }

    public function cancelOrder(Order $order)
    {
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('pesanan-saya')->with('success', 'Pesanan anda telah dibatalkan');
    }

    public function doneOrder(Order $order)
    {
        $order->status = 'done';
        $order->save();

        return redirect()->route('pesanan-saya')->with('success', 'Terima kasih sudah berbelanja di toko kami');
    }

    public function detailOrder(Order $order)
    {
        return view('detail-order', compact('order'));
    }
}
