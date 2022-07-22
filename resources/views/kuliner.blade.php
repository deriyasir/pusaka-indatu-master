@extends('layouts.app')

@section('title', 'Kuliner')

@section('content')
    <section>
        <div class="mb-2">
            <h4 class="text-muted">Kuliner</h4>
        </div>
        <div id="kuliner" class="row">
            @foreach ($kuliner as $makanan)
                <div class="col-md-3 col-6 p-2">
                    <div class="shadow-sm p-3 rounded">
                        <a class="d-flex justify-content-center align-items-center" style="overflow: hidden;"
                            href="{{ route('kuliner.detail', $makanan) }}">
                            <img src="{{ asset('storage/foods/' . $makanan->image) }}" class="img-fluid rounded"
                                alt="Makanan Image">
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
                </div>
            @endforeach
        </div>
    </section>
@endsection
