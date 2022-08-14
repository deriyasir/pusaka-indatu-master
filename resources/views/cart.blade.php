@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
    <section>
        <div class="mb-2">
            <h4 class="text-muted">Keranjang</h4>
        </div>
        <hr>
        <div id="keranjang">
            @if ($keranjang->count() > 0)
                <div class="row">
                    <div class="col-md-8">
                        @foreach ($keranjang as $item)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="d-flex flex-row align-items-center col-md-6 col-sm-12">
                                            <div>
                                                <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                                    class="img-fluid rounded" class="img-fluid rounded-3"
                                                    alt="Shopping item" style="width: 65px;">
                                            </div>
                                            <div class="ms-3">
                                                <h6>{{ $item->product->name }}</h6>
                                                <p class="small mb-0">{{ $item->product->detail() }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="d-flex justify-content-end">
                                                <div class="bg-light rounded-md">
                                                    <button
                                                        onclick="return window.location.href = '{{ route('add-to-cart', $item->product) . '?qty=' . ($item->quantity - 1) }}'"
                                                        @disabled($item->quantity == 1) class="btn btn-sm btn-secondary">
                                                        <i class="mdi mdi-minus"></i>
                                                    </button>
                                                    <a class="btn btn-sm mx-1">
                                                        {{ $item->quantity }}
                                                    </a>
                                                    <button
                                                        onclick="return window.location.href = '{{ route('add-to-cart', $item->product) . '?qty=' . ($item->quantity + 1) }}'"
                                                        @disabled($item->quantity == $item->product->stock) class="btn btn-sm btn-secondary">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                                <a href="{{ route('remove-from-cart', $item->product) }}"
                                                    class="btn btn-sm btn-danger ms-2">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
                                            <h5 style="text-align: right" class="mt-3 mb-0">Rp
                                                {{ number_format($item->getHarga()) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <aside class="col-md-4">
                        <div x-data="rajaOngkir" style="width: 100%; position: sticky; top: 80px;">
                            <div class="card p-3">
                                <small class="text-muted">Rincian Pembayaran</small>
                                <hr>
                                <ol class="list-group border-0">
                                    <li
                                        class="list-group-item d-flex justify-content-between border-0 p-0 pb-2 align-items-start">
                                        <div class="me-auto text-muted">
                                            <small>Total Belanja ({{ $keranjang->count() }} Produk)</small>
                                        </div>
                                        <span>Rp {{ number_format(auth()->user()->getCartTotal()) }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between border-0 p-0 pb-2 align-items-start">
                                        <div class="me-auto text-muted">
                                            <small>Ongkos Kirim</small>
                                        </div>
                                        <span>Rp <span
                                                x-text="new Intl.NumberFormat('en-US').format(hargaOngkir)"></span></span>
                                    </li>
                                </ol>
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-muted">Subtotal</h6>
                                    <h3><b>Rp <span
                                                x-text="new Intl.NumberFormat('en-US').format(total + hargaOngkir)"></span></b>
                                    </h3>
                                </div>
                                <form action="{{ route('checkout.store') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-warning text-white w-100 mt-4">Buat Pesanan</button>
                                </form>
                            </div>
                            <div class="card mt-3 p-3" x-init="initial()">
                                <div class="detail-pesanan">
                                    <div class="form-group mb-2">
                                        <small>Pilih Alamat</small>
                                        <select class="form-control" name="alamat" class="w-100 mt-3"
                                            style="padding: 10px 10px !important; font-size: 12px" x-model="address"
                                            x-on:change="getCost()">
                                            @foreach ($alamat as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->getFullAddress() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <small>Pilih Kurir</small>
                                        <select class="form-control" name="kurir" class="w-100 mt-3"
                                            style="padding: 10px 10px !important; font-size: 12px" x-model="courier"
                                            x-on:change="getCost()">
                                            <option value="tiki">TIKI</option>
                                            <option value="jne">JNE</option>
                                            <option value="pos">POS Indonesia
                                            </option>
                                        </select>
                                    </div>
                                    <small>Jenis Pengiriman</small>
                                    <template x-for="(cost, i) in costs">
                                        <label x-bind:id="'ongkir-' + i"
                                            class="d-flex border p-3 justify-content-between align-items-center rounded-3 mb-2"
                                            x-on:click="selected = cost.service; hargaOngkir = cost.cost[0].value"
                                            :class="{ 'border-warning': selected == cost.service }" style="cursor: pointer">
                                            <div>
                                                <h5 class="fw-bold" x-text="cost.service"></h5>
                                                <p class="m-0">Rp <span
                                                        x-text="new Intl.NumberFormat('en-US').format(cost.cost[0].value)"></span>
                                                </p>
                                            </div>
                                            <p class="m-0" x-text="cost.cost[0].etd.split(' ')[0] + ' HARI'"></p>
                                            <input type="radio" x-bind:id="'ongkir-' + i" x-bind:value="cost.service">
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            @else
                <div class="w-100 d-flex justify-content-center align-items-center" style="height: 400px">
                    <div class="content text-center">
                        <h4>Opps, keranjang kamu kosong</h4>
                        <p>Silahkan lihat produk-produk kami.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function rajaOngkir() {
            return {
                costs: [],
                address: '{{ $alamat->first()->id }}',
                weight: '{{ auth()->user()->getCartWeight() }}',
                courier: 'jne',
                selected: '',
                hargaOngkir: 0,
                total: '',
                initial() {
                    this.getCost();
                    this.total = parseInt('{{ auth()->user()->getCartTotal() }}') + this.hargaOngkir;
                },
                getCost() {
                    fetch(`/api/get-cost/358/${this.address}/${this.weight}/${this.courier}`)
                        .then(response => response.json())
                        .then(data => {
                            this.costs = data.rajaongkir.results[0].costs
                            console.log(this.costs[0].cost[0].value);
                            this.hargaOngkir = this.costs[0].cost[0].value
                            this.selected = this.costs[0].service
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },
            }
        }
    </script>
@endpush
