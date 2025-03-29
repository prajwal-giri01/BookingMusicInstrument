@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <h1>Create New Category</h1>

            <!-- Form to upload a new category with image -->
            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group mt-3">
                    <label for="image">Category Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Upload</button>
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

            <!-- Display success message after successful upload -->
            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </main>
    </x-app-layout>
@endsection
