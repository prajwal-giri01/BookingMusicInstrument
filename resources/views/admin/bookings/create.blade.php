@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main ">
            <h1>Upload New Instrument</h1>

            <!-- Form to upload a new instrument -->
            <form action="{{ route('admin.instruments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Instrument Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter instrument name" required>
                </div>

                <div class="form-group">
                    <label for="image_path">Image</label>
                    <input type="file" name="image_path" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter instrument description" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="form-control" placeholder="Enter price" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="" disabled selected>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Instrument</button>
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
