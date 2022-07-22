@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <section>
        <div class="mb-2">
            <h4 class="text-muted">Detail Pesanan</h4>
        </div>
        <hr>
        <div id="keranjang">
            <div class="row">
                <div class="col-md-8">
                    @foreach ($items as $item)
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
                            <div class="d-flex justify-content-start mt-3">
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop"><i class="mdi mdi-truck"></i> Ubah opsi
                                    pengiriman</button>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="col-md-4">
                    <div class="card p-3" style="width: 100%; position: sticky; top: 80px;">
                        <small class="text-muted">Rincian Pembayaran</small>
                        <hr>
                        <ol class="list-group border-0">
                            <li class="list-group-item d-flex justify-content-between border-0 p-0 pb-2 align-items-start">
                                <div class="me-auto text-muted">
                                    <small>Total Belanja ({{ $items->count() }} Produk)</small>
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
                        <div id="pay-button" class="btn btn-warning text-white w-100 mt-4">Bayar Pesanan</div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" x-data="rajaOngkir()">
            <div class="modal-content" x-init="initial()">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Opsi Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('checkout.address', $order) }}" id="ongkir-form" method="POST"
                        class="mb-2">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <small>Pilih Alamat</small>
                            <select class="form-control" name="alamat" class="w-100 mt-3"
                                style="padding: 10px 10px !important; font-size: 12px" x-model="address"
                                x-on:change="getCost()">
                                @foreach ($alamat as $item)
                                    <option value="{{ $item->id }}" @selected($order->alamat->id == $item->id)>
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
                                <option @selected($order->kurir == 'tiki') value="tiki">TIKI</option>
                                <option @selected($order->kurir == 'jne') value="jne">JNE</option>
                                <option @selected($order->kurir == 'pos') value="pos">POS Indonesia
                                </option>
                            </select>
                        </div>
                        <small>Jenis Pengiriman</small>
                        <template x-for="(cost, i) in costs">
                            <label x-bind:id="'ongkir-' + i"
                                class="d-flex border p-3 justify-content-between align-items-center rounded-3 mb-2"
                                x-on:click="selected = cost.service"
                                :class="{ 'border-warning': selected == cost.service }" style="cursor: pointer">
                                <div>
                                    <h5 class="fw-bold" x-text="cost.service"></h5>
                                    <p class="m-0">Rp <span
                                            x-text="new Intl.NumberFormat('en-US').format(cost.cost[0].value)"></span></p>
                                </div>
                                <p class="m-0" x-text="cost.cost[0].etd.split(' ')[0] + ' HARI'"></p>
                                <input type="radio" x-bind:id="'ongkir-' + i" x-bind:value="cost.service"
                                    :selected="{"{{ $order->service }}"==cost.service }">
                            </label>
                        </template>
                        <input type="hidden" name="service" x-bind:value="selected">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm btn-warning"
                        onclick="document.getElementById('ongkir-form').submit()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.callback') }}" method="POST" id="callback-form">
        @csrf
        <input type="hidden" name="callback" id="callback-input">
    </form>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    handleCallback(result);
                },
                onPending: function(result) {
                    handleCallback(result);
                },
                onError: function(result) {
                    alert("payment failed!");
                },
                onClose: function() {
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

        function handleCallback(result) {
            document.getElementById('callback-input').value = JSON.stringify(result);
            document.getElementById('callback-form').submit();
        }

        function rajaOngkir() {
            return {
                costs: [],
                address: '{{ $order->alamat->id }}',
                weight: '{{ $order->getOrderWeight() }}',
                courier: '{{ $order->kurir }}',
                selected: '{{ $order->service }}',
                initial() {
                    this.getCost();
                },
                getCost() {
                    fetch(`/api/get-cost/358/${this.address}/${this.weight}/${this.courier}`)
                        .then(response => response.json())
                        .then(data => {
                            this.costs = data.rajaongkir.results[0].costs
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },
            }
        }
    </script>
@endpush
