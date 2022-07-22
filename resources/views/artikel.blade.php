@extends('layouts.app')

@section('title', 'Artikel')

@section('content')
    <section>
        <div class="mb-2">
            <h4 class="text-muted">Artikel</h4>
        </div>
        <div id="kuliner" class="row">
            @foreach ($artikel as $blog)
                <div class="col-lg-4 col-sm-12 col-md-6 p-2">
                    <div class="card p-1 mb-3 position-relative">
                        <span
                            class="badge bg-info position-absolute top-2 left-2">{{ str()->upper($blog->category) }}</span>
                        <a class="text-dark" href="{{ route('artikel.baca', $blog) }}">
                            <img class="card-img-top" src="{{ asset('storage/blogs/' . $blog->image) }}"
                                alt="Card image cap">
                        </a>
                        <div class="card-body">
                            <a class="text-dark" href="{{ route('artikel.baca', $blog) }}">
                                <h5 class="card-title">{{ $blog->title }}</h5>
                            </a>
                            <p class="card-text">{{ $blog->headline }}</p>
                            <small><strong>{{ $blog->author->name }}</strong> -
                                {{ $blog->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
