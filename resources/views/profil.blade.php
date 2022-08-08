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
            <div class="alert border-none alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert border-none alert-danger">
                <strong>Opps!</strong> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert border-none alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('resend') == true || request('resend') == true)
            <div class="alert border-none alert-success mb-2">
                Email verifikasi telah dikirim, silahkan periksa email anda. klik <a style="cursor: pointer"
                    onclick="document.getElementById('resendEmail').submit()" class="alert-link">disini</a> untuk mengirim
                ulang email verifikasi.
            </div>
        @elseif (!auth()->user()->hasVerifiedEmail())
            <div class="alert border-none alert-danger" role="alert">
                <strong>Perhatian!</strong> Anda belum melakukan verifikasi email. Silahkan klik
                <a style="cursor: pointer" onclick="document.getElementById('resendEmail').submit()"
                    class="alert-link">Disini</a> untuk mengirim ulang email verifikasi dan cek Inbox email Anda, jika tidak
                ada coba cek di Spam.
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
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <a data-bs-toggle="modal" data-bs-target="#UbahProfil"
                                    class="btn btn-sm btn-warning
                                    w-100"><i
                                        class="fas fa-fw fa-user-edit"></i> Ubah Profil</a>
                            </div>
                            <div class="col-6">
                                <a data-bs-toggle="modal" data-bs-target="#UbahPassword"
                                    class="btn btn-sm btn-danger w-100"><i class="fas fa-fw fa-user-lock"></i>
                                    Ubah Password</a>
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
                            <div class="text-center py-5">
                                <p class="text-muted mb-0">Anda belum memiliki alamat</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>

    <!-- Ubah Profil -->
    <div class="modal fade" id="UbahProfil" tabindex="-1" aria-labelledby="UbahProfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UbahProfilLabel">Ubah Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ubah-profil') }}" method="post" id="ubahpasswordid">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="email" class="form-control" id="name" placeholder="Masukan Nama Anda"
                                value="{{ auth()->user()->name }}" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="email" class="form-control" id="phone"
                                placeholder="Masukan Nomor Telepon Anda" value="{{ auth()->user()->phone }}"
                                name="phone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning"
                        onclick="document.getElementById('ubahpasswordid').submit()">Ubah Profil</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ubah Password -->
    <div class="modal fade" id="UbahPassword" tabindex="-1" aria-labelledby="UbahPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UbahPasswordLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ganti-password') }}" method="post" id="gantipasswordid">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password"
                                placeholder="Masukan password baru" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                placeholder="Konfirmasi password baru" name="password_confirmation">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning"
                        onclick="document.getElementById('gantipasswordid').submit()">Ubah Password</button>
                </div>
            </div>
        </div>
    </div>


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

    <section class="d-block d-md-none">
        <a class="btn btn-danger mt-3 w-100" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout"></i>
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </section>

@endsection
