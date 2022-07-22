@extends('layouts.app')

@section('title', 'Tambah Alamat')

@section('content')
    <section x-data="rajaongkir()" x-init="getProvinces()">
        <div class="mb-2">
            <h4 class="text-muted">Tambah Alamat</h4>
        </div>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('alamat.store') }}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat"
                    placeholder="Jl. angsa, Lr. kucing No. 09, RT.09 RW.01, Desa Bebek, Kec. Panda">{{ old('alamat') }}</textarea>
            </div>
            <div class="d-flex mb-2" style="gap: 10px">
                <div class="form-group w-100">
                    <label for="provinsi">Provinsi</label>
                    <select name="provinsi_id" id="provinsi" class="form-control" x-bind:disabled="!province_active"
                        x-model="provinsi" x-on:change="getCity()">
                        <option value="">Pilih Provinsi</option>
                        <template x-for="province in provinces">
                            <option x-bind:value="province.province_id" x-text="province.province"></option>
                        </template>
                    </select>
                    <input type="hidden" name="provinsi" x-model="provinsi_name">
                </div>
                <div class="form-group w-100">
                    <label for="kota">Kota/Kabupaten</label>
                    <select name="kota_id" id="kota" class="form-control" x-bind:disabled="!cities_active"
                        x-model="kota" x-on:click="getPostalCode()">
                        <option value="">Pilih kota</option>
                        <template x-for="city in cities">
                            <option x-bind:value="city.city_id" x-text="city.city_name"></option>
                        </template>
                    </select>
                    <input type="hidden" name="kota" x-model="kota_name">
                </div>
                <div class="form-group w-100">
                    <label for="kode_pos">Kode Pos</label>
                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos"
                        x-model="kode_pos">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('profil') }}" class="btn btn-sm btn-outline-warning me-2"><i
                        class="mdi mdi-arrow-left"></i>
                    Kembali</a>
                <button type="submit" class="btn btn-sm btn-warning"><i class="mdi mdi-plus"></i> Tambah Alamat</button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        function rajaongkir() {
            return {
                provinces: [],
                province_active: false,
                provinsi: '',
                provinsi_name: '',
                cities: [],
                cities_active: false,
                kota: '',
                kota_name: '',
                kode_pos: '',
                getProvinces() {
                    fetch('/api/get-province')
                        .then(response => response.json())
                        .then(data => {
                            this.provinces = data.rajaongkir.results
                            this.province_active = true
                        })
                },
                getCities(province) {
                    this.provinsi_name = this.provinces.find(p => p.province_id == province).province
                    fetch('/api/get-city/' + province)
                        .then(response => response.json())
                        .then(data => {
                            this.cities = data.rajaongkir.results
                            this.cities_active = true
                        })
                },
                getCity() {
                    this.getCities(provinsi.value)
                },
                getPostalCode() {
                    if (kota.value) {
                        let kotaData = this.cities.find(c => c.city_id === kota.value)
                        this.kode_pos = kotaData.postal_code
                        this.kota_name = kotaData.type + ' ' + kotaData.city_name
                    }
                }

            }
        }
    </script>
@endpush
