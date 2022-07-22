@extends('layouts.admin')

@section('title', 'Orders')

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Orders</h4>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="cari" placeholder="Cari nomor order..."
                            value="{{ request()->cari }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mb-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
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
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
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
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    <style>
        td,
        th {
            white-space: nowrap;
            padding: 10px 20px !important;
        }
    </style>
@endsection
