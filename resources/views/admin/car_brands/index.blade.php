@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Car Brands</h1>
    <div class="card">
        <div class="card-header">
            <a href="{{ route('car-brands.create') }}" class="btn btn-primary">Add New Brand</a>
        </div>
        <div class="card-body">
            @if($carBrands->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No car brands found. Please add a new brand.
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carBrands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <a href="{{ route('car-brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('car-brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection