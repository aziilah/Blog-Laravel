@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Post</h1>
  </div>


  <div class="col-lg-8">

      <form method="POST" action="/dashboard/posts" class="mb-5" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title') }}">
          {{-- invalid title --}}
          @error('title')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror       
        </div>
        
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug') }}">  
          {{-- invalid slug --}}
          @error('slug')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror        
        </div>

        <div class="mb-3">
          <label for="category" class="form-label">Category</label>
            <select class="form-select " name="category_id">

                @foreach ( $categories as $category)
                        {{-- jika old id = id baru = selected --}}
                        @if(old('category_id') == $category->id)
                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>       
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Post Image</label>
          {{-- tambah ini utk img preview --}}
          <img class="img-preview img-fluid mb-3 col-sm-5">
          {{-- tambah js function onchange --}}
          <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
          {{-- invalid image --}}
          @error('image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror         
        </div>

        <div class="mb-3">
          <label for="body" class="form-label">Body</label>
            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
            <trix-editor input="body"></trix-editor>
            {{-- invalid body --}}
          @error('body')
          <p class="text-danger">
            {{ $message }}
          </p>
          @enderror   
        </div>
        
        <button type="submit" class="btn btn-primary">Create Post</button>
      </form>
  </div>


  {{-- ambil input2 dari form, title ambil judul --}}
{{-- <script>
    //apa yg kita isi dalam title..
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');
    
    // apa yg kita tulis di title..jadi berubah
    title.addEventListener('change', function() {
        //..akan masuk ke method ini dan diolah..
        fetch('/dashboard/posts/checkSlug?title=' + title.value)
        .then(response => response.json())
        //..dikembalikan data sebagai slug
        .then(data => slug.value(data.slug)
        //input: title  output; slug
    });
</script> --}}

<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');
    title.addEventListener('change', function () { 
        fetch('/dashboard/posts/checkSlug?title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
        
    });

    // to hide file upload menu
    document.addEventListener('trix-file-accept', function (e) {
        e.preventDefault();        
    })

    //CREATE IMAGE PREVIEW
    function previewImage() {
      const image = document.querySelector('#image');
      const imgPreview = document.querySelector('.img-preview');

      //awal img d-inline, kasi jadi d-block
      imgPreview.style.display = 'block';

      //ambil data image
      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
      }

    }

</script>


@endsection