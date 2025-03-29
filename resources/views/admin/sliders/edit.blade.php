@extends('admin.layout')

@section('content')
<x-app-layout>
    <main id="main" class="main">
    <h1>Edit Image</h1>

    <form action="{{ route('admin.sliders.update', $image->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ asset($image->image_path) }}" width="100" class="mt-2">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <!-- Display validation errors if any -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display success message if any -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection
    </main>
</x-app-layout>
