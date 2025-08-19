<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8"> 
    <title>@yield('title', 'Admin Panel - Showroom')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SB Admin CSS -->
    {{-- Chỉ giữ lại 1 bản FontAwesome (CDN mới nhất) để tránh xung đột --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        /* Ẩn toàn bộ icon mũi tên trái/phải trên toàn admin (FontAwesome & SVG) */
        .fa,
        .fas,
        .far,
        .fal,
        .fab,
        .fa-chevron-left, .fa-chevron-right, .fa-angle-left, .fa-angle-right,
        .fa-arrow-left, .fa-arrow-right,
        svg,
        [class*="icon-arrow"],
        [class*="icon-chevron"],
        [class*="icon-angle"] {
            display: none !important;
        }
    </style>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            {{-- Topbar --}}
            @include('admin.layouts.topbar')

            <!-- Page Content -->
            <div class="container-fluid py-4">

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                {{-- Main Content --}}
                @yield('content')

            </div>
            <!-- End Page Content -->
        </div>

        {{-- Footer --}}
        @include('admin.layouts.footer')

    </div>
    <!-- End Content Wrapper -->

</div>
<!-- End Page Wrapper -->

<!-- JS -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Extra (e.g. DataTables, Chart.js...) -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

{{-- Page specific scripts --}}
@stack('scripts')

</body>
</html>