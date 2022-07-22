<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RajaOngkirController;
use App\Models\Blog;
use App\Models\Food;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $products = Product::latest()->get();
    $kuliner = Food::latest()->get();
    return view('home', compact('products', 'kuliner'));
})->name('home');

Route::get('/produk', function () {
    $products = Product::latest()->get();
    return view('produk', compact('products'));
})->name('produk');

Route::get('/produk/{produk:slug}', function (Product $produk) {
    $produk->update(['views' => $produk->views + 1]);
    $products = Product::latest()->where('id', '!=', $produk->id)->get();
    return view('produk-detail', compact('produk', 'products'));
})->name('produk.detail');

Route::get('/kuliner', function () {
    $kuliner = Food::latest()->get();
    return view('kuliner', compact('kuliner'));
})->name('kuliner');

Route::get('/kuliner/{kuliner:slug}', function (Food $kuliner) {
    $kuliner->update(['views' => $kuliner->views + 1]);
    $kuliners = Food::latest()->where('id', '!=', $kuliner->id)->get();
    return view('kuliner-detail', compact('kuliner', 'kuliners'));
})->name('kuliner.detail');

Route::post('/kuliner/{kuliner:slug}', function (Food $kuliner) {
    $jumlah = request('jumlah');
    $harga = $kuliner->price;
    $total = 'Rp. ' . number_format($jumlah * $harga, 0, ',', '.');
    $alamat = request('alamat');
    $phone = '6282272726140';
    $text = "Halo, Saya ingin pesan *{$kuliner->name}* untuk *{$jumlah}* porsi.%0aalamat : *{$alamat}*%0aTerima kasih,%0a%0aTotal : *{$total}*";
    return Redirect::to("https://api.whatsapp.com/send?phone={$phone}&text={$text}");
})->name('kuliner.order');

Route::get('/artikel', function () {
    $artikel = Blog::latest()->get();
    return view('artikel', compact('artikel'));
})->name('artikel');

Route::get('/artikel/{blog:slug}', function (Blog $blog) {
    $blog->update(['views' => $blog->views + 1]);
    $other_blogs = Blog::where('id', '!=', $blog->id)->latest()->limit(5)->get();
    return view('artikel-baca', compact('blog', 'other_blogs'));
})->name('artikel.baca');

Auth::routes([
    'verify' => true,
]);

Route::group(['middleware' => ['auth', 'can:is_user']], function () {
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');

    Route::group(['middleware' => 'verified'], function () {
        Route::get('/keranjang', function () {
            $keranjang = Auth::user()->cart;
            return view('cart', compact('keranjang'));
        })->name('cart');

        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/{order:no_order}', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');
        Route::put('/checkout/{order:no_order}/alamat', [CheckoutController::class, 'editAlamat'])->name('checkout.address');
        Route::resource('/alamat', AlamatController::class)->except(['show', 'index']);

        Route::get('detail-order/{order:no_order}', [CheckoutController::class, 'detailOrder'])->name('order.detail');
        Route::get('/cancel-order/{order:no_order}', [CheckoutController::class, 'cancelOrder'])->name('order.cancel');
        Route::get('/done-order/{order:no_order}', [CheckoutController::class, 'doneOrder'])->name('order.done');

        Route::get('/add-to-cart/{product:slug}', function (Product $product) {
            auth()->user()->cart()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => request('qty') ?? 1]
            );
            return redirect()->back();
        })->name('add-to-cart');

        Route::get('/remove-from-cart/{product:slug}', function (Product $product) {
            auth()->user()->cart()->where('product_id', $product->id)->delete();
            return redirect()->back();
        })->name('remove-from-cart');
    });
});

Route::group(['middleware' => ['auth', 'verified', 'can:is_admin']], function () {
    Route::get('/dashboard', function () {
        $total = [
            'orders' => Order::count(),
            'products' => Product::count(),
            'foods' => Food::count(),
            'users' => User::count(),
        ];
        $orders = Order::latest()->limit(5)->get();
        return view('admin.dashboard.index', compact('orders', 'total'));
    })->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::resource('artikel', App\Http\Controllers\BlogController::class)
            ->parameters(['artikel' => 'blog'])
            ->names('blog')
            ->except(['show']);

        Route::resource('produk', App\Http\Controllers\ProductController::class)
            ->parameters(['produk' => 'product'])
            ->names('products')
            ->except(['show']);

        Route::resource('makanan', App\Http\Controllers\FoodController::class)
            ->parameters(['makanan' => 'food'])
            ->names('foods')
            ->except(['show']);

        Route::get('/order', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/order/{order:no_order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/order/{order:no_order}/status', [OrderController::class, 'editStatus'])->name('orders.status');

        Route::resource('manajemen-admin', App\Http\Controllers\AdminController::class)
            ->parameters(['manajemen-admin' => 'admin'])
            ->names('admin-management')
            ->except(['show']);
    });
});

Route::get('/kota-aceh', function () {
    $rajaongkir = new RajaOngkirController();
    // return $rajaongkir->getProvince();
    return $rajaongkir->getCity(21);
});
