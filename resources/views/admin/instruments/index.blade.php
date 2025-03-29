@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <div class="container mt-4">
                <h1 class="mb-4 text-center">Instrument List</h1>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.instruments.create') }}" class="btn btn-primary">Create New Instrument</a>
                </div>

                <div class="table-responsive" style="margin-top: 2rem;">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($instruments as $instrument)
                            <tr>
                                <td>{{ $instrument->name }}</td>
                                <td>
                                    <img src="{{ asset($instrument->image_path) }}" alt="{{ $instrument->name }}" class="img-thumbnail" width="120">
                                </td>
                                <td>{{ $instrument->description }}</td>
                                <td>Rs.{{ number_format($instrument->rental_price, 2) }}</td>
                                <td>{{ $instrument->category->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('admin.instruments.edit', $instrument->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.instruments.destroy', $instrument->id) }}" method="POST" style="margin-top: 1rem;">
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
