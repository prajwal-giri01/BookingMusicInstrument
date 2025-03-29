@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <h1 class="text-center">Edit Drink</h1>

            <form action="{{ route('admin.instruments.update', $drink->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mt-3">
                    <label for="name">Drink Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $drink->name }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $drink->description }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="form-control" value="{{ $drink->rental_price }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="" disabled>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $drink->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="image">Image</label>
                    <input type="file" name="image_path" class="form-control">
                    @if($drink->image_path)
                        <img src="{{ asset($drink->image_path) }}" width="100" class="mt-2">
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
