@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4">Car Models</h1>
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.car-models.create') }}" class="btn btn-primary">Add New Car Model</a>
            </div>
            <div class="card-body">
                @if($carModels->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        No car models found. <a href="{{ route('admin.car-models.create') }}" class="alert-link">Click here</a> to add a new car model.
                    </div>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carModels as $carModel)
                                <tr>
                                    <td>{{ $carModel->id }}</td>
                                    <td>{{ $carModel->name }}</td>
                                    <td>{{ $carModel->brand->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('admin.car-models.edit', $carModel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.car-models.destroy', $carModel->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this car model?')">Delete</button>
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