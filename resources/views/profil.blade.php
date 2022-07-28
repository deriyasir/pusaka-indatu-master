@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <section>
        <div class="d-none d-md-block">
            <div class="mb-2">
                <h6 class="text-muted">Profil</h6>
            </div>
            <hr>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <strong>Opps!</strong> {{ session('error') }}
            </div>
        @endif
        @if (auth()->user()->email_verified_at == null)
            <div class="alert alert-danger" role="alert">
                <strong>Perhatian!</strong> Anda belum melakukan verifikasi email. Silahkan klik
                <a style="cursor: pointer" onclick="document.getElementById('resendEmail').submit()"
                    class="alert-link">Disini</a> untuk mengirim ulang email verifikasi dan cek Inbox email Anda, jika tidak ada coba cek di Spam.
            </div>
            <form action="{{ route('verification.resend') }}" method="POST" id="resendEmail">
                @csrf
            </form>
        @endif
        <section>
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <div class="card p-3 mb-4">
                        <h5 class="m-0">Informasi Anda :</h5>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Nama lengkap</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">{{ auth()->user()->phone ?? '-' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Terdaftar pada</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">{{ auth()->user()->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="card mb-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Alamat</h5>
                            <a class="btn btn-sm btn-warning" href="{{ route('alamat.create') }}">Tambah Alamat <i
                                    class="mdi mdi-plus"></i></a>
                        </div>
                        @if (auth()->user()->alamat->count() > 0)
                            @foreach (auth()->user()->alamat as $alamat)
                                <hr>
                                <div>
                                    <p class="text-muted mb-0">{{ $alamat->getFullAddress() }}</p>
                                    <div class="d-flex mt-2">
                                        <a class="btn btn-sm text-warning" href="{{ route('alamat.edit', $alamat) }}"><i
                                                class="mdi mdi-pencil"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('alamat.destroy', $alamat) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('yakin dihapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm text-danger"><i class="mdi mdi-delete"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <hr>
                            <div class="alert alert-danger" role="alert">
                                <small>
                                    <strong>Perhatian!</strong> Anda belum mengisi alamat. Silahkan klik
                                    <a style="cursor: pointer" onclick="document.getElementById('addAddress').submit()"
                                        class="alert-link">Tambah Alamat</a> untuk mengisi alamat.
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>

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
                                        Checkout
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
