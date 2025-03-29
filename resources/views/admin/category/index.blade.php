@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <div class="container mt-4">
                <h1 class="mb-4 text-center">Category</h1>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Create New Category</a>
                </div>

                <div class="table-responsive" style="margin-top: 2rem;">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $item)
                            <tr>
                                <td>
                                    <p>{{ $item->name }}</p>
                                </td>
                                <td>
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="100" height="100" class="img-thumbnail">
                                    @else
                                        <p>No Image</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('admin.category.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.category.destroy', $item->id) }}" method="POST" style="margin-top: 1rem;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
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
