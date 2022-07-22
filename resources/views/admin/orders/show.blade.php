@extends('layouts.admin')

@section('title', $order->no_order)

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ $order->no_order }}</h4>
            <a href="{{ route('orders.index') }}">kembali</a>
        </div>
        <hr>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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
                                    <div class="ml-3">
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
                <div class="card p-3">
                    <form action="{{ route('orders.status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="resi">Resi</label>
                            <input name="resi" id="resi" class="form-control form-control-sm"
                                placeholder="Masukan Resi" value="{{ $order->resi }}" />
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="">Pilih status</option>
                                @foreach (['waiting', 'processing', 'sending', 'done', 'cancelled'] as $item)
                                    <option value="{{ $item }}" @selected($order->status == $item)>{{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-0">
                            <button class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <aside class="col-md-4">
                <div class="card p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="m-0">Status Order:</p>
                        <h4 class="m-0 text-white">{!! $order->getStatus() !!}</h4>
                    </div>
                </div>
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
                <div class="mt-4" id="shipping">
                    <small class="text-muted">Detail pengiriman</small>
                    <hr>
                    <div class="card border-0 p-3 bg-light">
                        <table style="font-size: 12px">
                            <tr>
                                <td colspan="3" class="font-weight-bold pb-2">{{ $order->alamat->getFullAddress() }}
                                </td>
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
            </aside>
        </div>
    </div>
@endsection
