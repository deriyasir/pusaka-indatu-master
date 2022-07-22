@extends('layouts.app')

@section('title', 'Detail Order')

@section('content')
    <section style="min-height: 50vh">
        <div class="mb-2">
            <h6 class="text-muted">Detail Order</h6>
        </div>
        <hr>
        <div id="keranjang">
            <div class="row">
                <div class="col-md-8">
                    @foreach ($order->items as $item)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-center col-md-6 col-sm-12">
                                        <div>
                                            <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                                class="img-fluid rounded" class="img-fluid rounded-3" alt="Shopping item"
                                                style="width: 65px;">
                                        </div>
                                        <div class="ms-3">
                                            <h6>{{ $item->product->name }}</h6>
                                            <p class="small mb-0">{{ $item->product->detail() }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex justify-content-end align-items-center" style="gap:5px">
                                                <p class="mb-0">Rp {{ number_format($item->product->price) }}</p>
                                                <p class="mb-0">x {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <h5 style="text-align: right" class="mt-3 mb-0">Rp
                                            {{ number_format($item->product->price * $item->quantity) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4" id="shipping">
                        <small class="text-muted">Detail pengiriman</small>
                        <hr>
                        <div class="card border-0 p-3 bg-light">
                            <table style="font-size: 12px">
                                <tr>
                                    <td>Alamat</td>
                                    <td class="px-3">:</td>
                                    <td class="fw-bold">{{ $order->alamat->getFullAddress() }}</td>
                                </tr>
                                <tr>
                                    <td>Kurir</td>
                                    <td class="px-3">:</td>
                                    <td class="fw-bold" style="text-transform: uppercase">{{ $order->kurir }}</td>
                                </tr>
                                <tr>
                                    <td>Service</td>
                                    <td class="px-3">:</td>
                                    <td class="fw-bold">{{ $order->service }}</td>
                                </tr>
                                <tr>
                                    <td>ETD</td>
                                    <td class="px-3">:</td>
                                    <td class="fw-bold">{{ $order->etd }}</td>
                                </tr>
                                <tr>
                                    <td>Ongkos Kirim</td>
                                    <td class="px-3">:</td>
                                    <td class="fw-bold">Rp {{ number_format($order->harga_ongkir) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <aside class="col-md-4">
                    <div class="card p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="m-0">Status Order:</p>
                            <h4 class="m-0">{!! $order->getStatus() !!}</h4>
                        </div>
                    </div>
                    @if ($order->resi != null)
                        <div class="card p-3 mb-3">
                            <small>No Resi :</small>
                            <h6 class="fw-bold mt-2 mb-0">{{ $order->resi }}</h6>
                        </div>
                    @endif
                    <div class="card p-3" style="width: 100%; position: sticky; top: 80px;">
                        <small class="text-muted">Rincian Harga</small>
                        <hr>
                        <ol class="list-group border-0">
                            <li class="list-group-item d-flex justify-content-between border-0 p-0 pb-2 align-items-start">
                                <div class="me-auto text-muted">
                                    <small>Total Belanja ({{ $order->items->count() }} Produk)</small>
                                </div>
                                <span>Rp {{ number_format($order->getOrderTotal()) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between border-0 p-0 pb-2 align-items-start">
                                <div class="me-auto text-muted">
                                    <small>Ongkos Kirim</small>
                                </div>
                                <span>Rp {{ number_format($order->harga_ongkir) }}</span>
                            </li>
                        </ol>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="text-muted">Subtotal</h6>
                            <h3 class="fw-bold">Rp <span>{{ number_format($order->total) }}</span></h3>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
