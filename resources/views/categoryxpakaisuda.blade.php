@extends('layouts.main')

@section('container')
    <h1>Post Category : {{ $category }}</h1>

    {{-- use foreach for looping each data from array --}}
    @foreach ($posts as $post)
        <article class="mb-5">
            <h2>
                <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
            </h2>
            <p>{{ $post->excerpt }}</p>
        </article>  
    @endforeach

@endsection

