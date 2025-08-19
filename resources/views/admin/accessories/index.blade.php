@extends('admin.layouts.app')

@section('title', 'Danh sách phụ kiện')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách phụ kiện</h6>
            <a href="{{ route('admin.accessories.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>

        <div class="card-body">
            {{-- Form tìm kiếm --}}
            <form method="GET" action="{{ route('admin.accessories.index') }}" class="form-inline mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2"
                    placeholder="Tìm kiếm">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>

            {{-- Bảng dữ liệu --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên phụ kiện</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Trạng thái</th>
                            <th class="text-center" width="180">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accessories as $accessory)
                            <tr>
                                <td>{{ $accessory->id }}</td>
                                <td>{{ $accessory->name }}</td>
                                <td>{{ number_format($accessory->price, 0, ',', '.') }} đ</td>
                                <td>
                                    @if ($accessory->image_path)
                                        <img src="{{ $accessory->image_path }}" class="img-thumbnail" width="60" height="60" alt="Ảnh">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($accessory->is_active)
                                        <span class="badge badge-success">Hiển thị</span>
                                    @else
                                        <span class="badge badge-danger">Ẩn</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.accessories.edit', $accessory->id) }}"
                                        class="btn btn-sm btn-info">Sửa</a>
                                    <form action="{{ route('admin.accessories.destroy', $accessory->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc muốn xoá phụ kiện này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="mt-3">
                {{ $accessories->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
@endsection