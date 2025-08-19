@extends('adminlte::page')

@section('title', 'Car Variants')

@section('content_header')
    <h1>Car Variants</h1>
@stop

@section('content')
    <a href="{{ route('admin.car_variants.create') }}" class="btn btn-primary mb-3">Add New Variant</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carVariants as $variant)
                        <tr>
                            <td>{{ $variant->id }}</td>
                            <td>{{ $variant->name }}</td>
                            <td>
                                <a href="{{ route('admin.car_variants.edit', $variant->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.car_variants.destroy', $variant->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Car Variants Page'); </script>
@stop