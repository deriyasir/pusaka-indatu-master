@extends('layouts.admin')

@section('title', 'Dashboard')

@section('body')
    <div class="row mb-4">
        <div class="col-md-3 col-sm-12">
            <div class="card p-1">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <h1 class="card-text">{{ $total['products'] ?? '123' }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card p-1">
                <div class="card-body">
                    <h5 class="card-title">Total Kuliner</h5>
                    <h1 class="card-text">{{ $total['foods'] ?? '123' }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card p-1">
                <div class="card-body">
                    <h5 class="card-title">Total Order</h5>
                    <h1 class="card-text">{{ $total['orders'] ?? '123' }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card p-1">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <h1 class="card-text">{{ $total['users'] ?? '123' }}</h1>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Selamat Datang, <strong>{{ auth()->user()->name }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orderan Terbaru</div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">
                                            <p class="m-0">{{ $order->no_order }}</p>
                                            <small>{{ $order->user->name }}</small>
                                        </td>
                                        <td class="text-white">
                                            {!! $order->getStatus() !!}
                                        </td>
                                        <td class="fw-bold">Rp {{ number_format($order->total) }}</td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-warning" href="{{ route('orders.show', $order) }}">
                                                <i class="mdi mdi-eye"></i>
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
