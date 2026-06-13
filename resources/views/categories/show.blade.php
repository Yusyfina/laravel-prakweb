{{-- challenge bab3 - view detail kategori menggunakan layout layouts.master --}}
@extends('layouts.master')

@section('title', 'Detail Kategori')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">

    <div>
        <h4 class="mb-1 fw-bold">
            <i class="me-2 text-primary bi bi-eye"></i>
            Detail Kategori
        </h4>

        <nav aria-label="breadcrumb">
            <ol class="mb-0 breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">
                        Kategori
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    {{ $category->name }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('categories.edit', $category) }}"
            class="btn btn-warning">
            <i class="me-1 bi bi-pencil"></i>
            Edit
        </a>

        <a href="{{ route('categories.index') }}"
            class="btn-outline-secondary btn">
            Kembali
        </a>

    </div>

</div>

<div class="shadow-sm border-0 card">

    <div class="bg-white py-3 card-header">
        <h5 class="mb-0 fw-semibold">
            Informasi Kategori
        </h5>
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-12">

                <div class="mb-3">
                    <label class="text-muted form-label">
                        Nama Kategori
                    </label>

                    <div class="bg-light form-control">
                        {{ $category->name }}
                    </div>
                </div>

                <div class="row">

                    <div class="mb-3 col-md-6">
                        <label class="text-muted form-label">
                            Slug
                        </label>

                        <div class="bg-light form-control">
                            {{ $category->slug }}
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="text-muted form-label">
                            Status
                        </label>

                        <div>
                            @if($category->is_active)
                                <span class="bg-success badge">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-danger badge">
                                    Tidak Aktif
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="mb-3">
                    <label class="text-muted form-label">
                        Deskripsi
                    </label>

                    <div class="bg-light form-control" style="min-height:120px;">
                        {{ $category->description ?: '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted form-label">
                        Jumlah Produk
                    </label>

                    <div>
                        <span class="bg-primary badge">
                            {{ $category->products->count() }} Produk
                        </span>
                    </div>
                </div>

                <div class="text-muted small">
                    Dibuat:
                    {{ $category->created_at->format('d M Y H:i') }}
                </div>

            </div>

        </div>

    </div>

</div>

{{-- challenge bab3 - daftar produk yang berada dalam kategori ini --}}
@if($category->products->count())

<div class="shadow-sm mt-4 border-0 card">

    <div class="bg-white card-header">
        <h6 class="mb-0">
            Produk Dalam Kategori Ini
        </h6>
    </div>

    <div class="card-body">

        <div class="row">

            @foreach($category->products as $product)

                <div class="mb-3 col-md-3">

                    <div class="shadow-sm border-0 h-100 card">

                        <div class="card-body">

                            <h6 class="fw-semibold">
                                {{ $product->name }}
                            </h6>

                            <div class="mb-2 text-muted small">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="mb-3">
                                Stok: {{ $product->stock }}
                            </div>

                            <a href="{{ route('products.show', $product) }}"
                                class="btn-outline-primary btn btn-sm">
                                Lihat Detail
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endif

@endsection
