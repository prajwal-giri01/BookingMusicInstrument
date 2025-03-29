@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <h1>Edit Category</h1>

            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ $category->name }}">
                </div>
                <div class="form-group mt-3">
                    <label for="image">Category Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($category->image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" width="100" height="100" class="img-thumbnail">
                        </div>
                    @else
                        <p class="mt-2">No image available.</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
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
        </main>
    </x-app-layout>
@endsection
