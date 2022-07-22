@extends('layouts.app')

@section('title', $kuliner->name)

@section('content')
    <section>
        <div class="row">
            <div class="row col-md-9">
                <div class="col-md-5 col-sm-12 mb-4">
                    <div class="card p-2">
                        <img src="{{ asset('storage/foods/' . $kuliner->image) }}" class="img-fluid" alt="image">
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 px-3">
                    <h2>{{ $kuliner->name }}</h4>
                        <small class="text-muted mb-3 d-block"><i class="mdi mdi-eye"></i>
                            {{ $kuliner->views }} x dilihat</small>
                        <h5 class="mb-3"><b>Rp {{ number_format($kuliner->price) }}</b></h5>
                        <hr>
                        <h6 class="text-muted mb-3">Detail Produk</h6>
                        <table class="text-muted" style="font-size: 12px;">
                            <tr>
                                <td>Satuan</td>
                                <td class="px-2">:</td>
                                <td>{{ $kuliner->satuan }}</td>
                            </tr>
                        </table>
                        <p class="text-muted mt-2">{!! $kuliner->description !!}</p>

                </div>
            </div>
            <aside class="col-md-3" x-data="{ jumlah: 1, harga: '{{ $kuliner->price }}' }">
                <div class="card p-3" style="width: 100%; position: sticky; top: 80px;">
                    <small class="text-muted">Atur jumlah</small>
                    <hr>
                    <div class="d-flex">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <a class="btn btn-outline-secondary" x-on:click="if(jumlah > 1) jumlah -= 1">-</a>
                            </div>
                            <input type="number" class="form-control text-center" id="jumlah" x-model="jumlah"
                                name="jumlah">
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary" x-on:click="jumlah += 1">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-muted">Subtotal</h6>
                        <h3><b>Rp <span x-text="new Intl.NumberFormat('en-US',).format(harga * jumlah)"></span></b></h3>
                    </div>
                    <div class="alert alert-warning mt-2">
                        <p class="text-muted m-0">
                            <i class="mdi mdi-alert-circle-outline"></i>
                            <b>Perhatian!</b>
                            <br>
                            <small>
                                Untuk saat ini cakupan kami hanya untuk wilayah <strong>Sigli</strong> saja.
                            </small>
                        </p>
                    </div>
                    {{-- x-bind:href="'{{ route('add-to-cart', $kuliner) }}?qty=' + jumlah" --}}
                    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                        class="btn btn-sm btn-success text-white mt-2" style="width: 100%">
                        Order Makanan
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('kuliner.order', $kuliner) }}" id="FormOrderMakanan" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Order Makanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <div class="d-flex">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <a class="btn btn-outline-secondary"
                                                    x-on:click="if(jumlah > 1) jumlah -= 1">-</a>
                                            </div>
                                            <input type="number" class="form-control text-center" id="jumlah"
                                                x-model="jumlah" name="jumlah">
                                            <div class="input-group-append">
                                                <a class="btn btn-outline-secondary" x-on:click="jumlah += 1">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea name="alamat" class="form-control" placeholder="Leave a comment here" id="alamat" style="height: 100px"
                                            required></textarea>
                                        <label for="alamat">Alamat</label>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-muted">Subtotal</h6>
                                        <h3><b>Rp <span
                                                    x-text="new Intl.NumberFormat('en-US',).format(harga * jumlah)"></span></b>
                                        </h3>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="mdi mdi-whatsapp"></i>
                                        Order via Whatsapp
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
    <hr class="my-4">
    <section class="mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-muted">Produk Lainnya</h4>
            @if ($kuliners->count() > 4)
                <a href="{{ route('kuliner') }}" class="text-dark"><i class="mdi mdi-arrow-right"></i> Tampilkan
                    seluruh
                    kuliner</a>
            @endif
        </div>
        <div id="kuliner" class="splide" aria-label="Produk Terbaru">
            <div class="splide__track py-2">
                <ul class="splide__list">
                    @foreach ($kuliners as $makanan)
                        <li class="splide__slide bg-white" style="width: 100%">
                            <div class="shadow-sm p-2 rounded">
                                <a class="d-flex justify-content-center align-items-center" style="overflow: hidden;"
                                    href="{{ route('kuliner.detail', $makanan) }}">
                                    <img src="{{ asset('storage/foods/' . $makanan->image) }}" class="img-fluid rounded"
                                        alt="Product Image">
                                </a>
                                <div class="text-center py-3">
                                    <p class="m-0">{{ $makanan->name }}</p>
                                    <small class="text-muted">Rp {{ number_format($makanan->price) }}</small>
                                </div>
                                <a class="btn btn-sm btn-outline-success" style="width: 100%"
                                    href="{{ route('kuliner.detail', $makanan) }}">
                                    Detail Makanan
                                </a>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </section>



@endsection


@push('scripts')
    <script>
        var kuliner = new Splide('#kuliner', {
            type: 'slide',
            arrows: false,
            perPage: 5,
            breakpoints: {
                1024: {
                    perPage: 3,

                },
                767: {
                    perPage: 2,

                },
            },
            gap: '1em',
            updateOnMove: true,
            pagination: false,
            snap: true,
            padding: {
                right: '3em'
            },
            autoplay: true,
        });
        kuliner.mount();
    </script>
@endpush
