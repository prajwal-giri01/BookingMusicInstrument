@extends('admin.layout')

@section('content')
<x-app-layout>
    <main id="main" class="main">
<div class="container mt-4">
    <h1 class="mb-4 text-center">Slider Images</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Create New Slider</a>
    </div>

    <div class="table-responsive" style="margin-top: 2rem;">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Image</th>
                    <th>Actions</th> <!-- One column for both buttons -->
                </tr>
            </thead>
            <tbody>
                @foreach($images as $image)
                <tr>
                    <td>
                        <img src="{{ asset($image->image_path) }}" alt="Slider Image" class="img-thumbnail" width="120">
                    </td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('admin.sliders.edit', $image->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.sliders.destroy', $image->id) }}" method="POST" style="margin-top: 1rem;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div> <!-- d-flex div to keep buttons side by side -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    </main>
</x-app-layout>
@endsection
