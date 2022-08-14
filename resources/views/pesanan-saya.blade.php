@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
    <section>
        <div class="mb-2">
            <h6 class="text-muted">Riwayat Pesanan</h6>
        </div>
        <hr>
        <div class="table-responsive">
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
                    @foreach (auth()->user()->orders()->latest()->get() as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $order->no_order }}</td>
                            <td>
                                {!! $order->getStatus() !!}
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total) }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($order->isPaid())
                                    <a class="btn btn-sm btn-warning" href="{{ route('order.detail', $order) }}">
                                        <i class="mdi mdi-eye"></i>
                                        Lihat
                                    </a>
                                    @if ($order->status == 'sending')
                                        <a class="btn btn-sm btn-success" href="{{ route('order.done', $order) }}">
                                            <i class="mdi mdi-check"></i>
                                            Pesanan diterima
                                        </a>
                                    @endif
                                @elseif($order->status == 'cancelled')
                                    <span>-</span>
                                @else
                                    <a class="btn btn-sm btn-info" href="{{ route('checkout', $order) }}">
                                        <i class="mdi mdi-cash-usd"></i>
                                        Bayar Pesanan
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="{{ route('order.cancel', $order) }}">
                                        <i class="mdi mdi-close"></i>
                                        Batalkan
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <style>
                td,
                th {
                    white-space: nowrap;
                    padding: 10px 20px !important;
                }
            </style>
        </div>
    </section>

@endsection
