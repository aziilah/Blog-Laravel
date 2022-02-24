@extends('layouts.main')

@section('container')
    <h1 class="mb-3 text-center">{{$title}}</h1>

    <div class="row justify-content-center mb-3">
        <div class="com-md-6">

            <form action="/posts" method="">
                @if (request('category')) 
                {{-- JIka dalam request ada category, buat sebuah input yg kita sembunyikan, name nya category, isinya kita ambil dari req category...supaya  ada dlm search dan category dlm URl --}}
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    
                @endif

                @if (request('author')) 
                    <input type="hidden" name="author" value="{{ request('author') }}">
                    
                @endif

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-danger" type="submit">Search</button>
                  </div>
            </form>
        </div>
    </div>

    {{-- HERO POST --}}
    {{-- jika ada posts, tampilkan card dibawah --}}
    @if ($posts->count()) 

        <div class="card mb-3">

            {{-- jika ADA file image --}}
        @if ($posts[0]->image)
        <div style="max-height: 500px; overflow: hidden; ">

          <img src="{{ asset('storage/' . $posts[0]->image) }}" alt="{{ $posts[0]->category->name }}" class="img-fluid">

        </div>

      {{-- jika TIDAK ADA file image  --}}
        @else 
        <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">

      @endif

            <div class="card-body text-center">
            <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
            <p>
                <small class="text-muted">
                    By <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">
                    {{ $posts[0]->author->name }} </a> in <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none">{{ $posts[0]->category->name }}</a> {{ $posts[0]->created_at->diffForHumans()
                     }}
                </small>
            </p>

            <p class="card-text">{{ $posts[0]->excerpt }}</p>

            <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read More</a>


            </div> 
        </div>


        <div class="container">
            <div class="row">

                 {{-- use foreach for looping each data from array --}}
    {{-- skip post pertama [0] --}}

                @foreach ($posts->skip(1) as $post)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="position-absolute bg-dark px-3 py-2 " style="background-color: rgba(0, 0, 0.7)">
                            <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none text-white">
                                {{ $post->category->name }}
                            </a>
                        </div>

                        {{-- jika ADA file image  --}}
        @if ($post->image)
        

          <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">

      {{-- jika TIDAK ADA file image  --}}
        @else 
        <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}">

      @endif

                        <div class="card-body">
                          <h5 class="card-title">{{ $post->title }}</h5>
                          <p>
                            <small class="text-muted">
                                By <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">
                                {{ $post->author->name }} </a><br>
                                {{ $post->created_at->diffForHumans()
                                 }}
                            </small>
                        </p>
                          <p class="card-text">{{ $post->excerpt }}</p>
                          <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read More</a>
                        </div>
                      </div>
                </div>
                @endforeach 
            </div>
        </div>

        @else 
        <p class="text-center fs-4">No Post Found!</p>
        @endif
             
{{-- PAGINATION --}}
{{ $posts->links() }}


@endsection
