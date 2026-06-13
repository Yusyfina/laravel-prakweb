{{-- Penggunaan Component Layout --}}
@extends('layouts.master')

@section('title', 'Detail Produk')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1 fw-bold">
            <i class="me-2 text-primary bi bi-eye"></i>
            Detail Produk
        </h4>

    <nav aria-label="breadcrumb">
        <ol class="mb-0 breadcrumb small">
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}">
                    Produk
                </a>
            </li>

            <li class="breadcrumb-item active">
                {{ $product->name }}
            </li>
        </ol>
    </nav>
</div>

<div class="d-flex gap-2">
    <a href="{{ route('products.edit', $product) }}"
       class="btn btn-warning">
        <i class="me-1 bi bi-pencil"></i>
        Edit
    </a>

    <a href="{{ route('products.index') }}"
       class="btn-outline-secondary btn">
        Kembali
    </a>
</div>

</div>

<div class="shadow-sm border-0 card">
    <div class="bg-white py-3 card-header">
        <h5 class="mb-0 fw-semibold">
            Informasi Produk
        </h5>
    </div>

<div class="card-body">
    <div class="row g-4">

        <div class="col-md-4">

            @if($product->image)
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="border rounded w-100 img-fluid"
                    alt="{{ $product->name }}"
                >
            @else
                <div
                    class="d-flex align-items-center justify-content-center bg-light border rounded"
                    style="height:300px;"
                >
                    <i class="text-muted bi bi-image fs-1"></i>
                </div>
            @endif

        </div>

        <div class="col-md-8">

            <div class="mb-3">
                <label class="text-muted form-label">
                    Nama Produk
                </label>

                <div class="bg-light form-control">
                    {{ $product->name }}
                </div>
            </div>

            <div class="row">

                <div class="mb-3 col-md-6">
                    <label class="text-muted form-label">
                        Kategori
                    </label>

                    <div class="bg-light form-control">
                        {{ $product->category->name ?? '-' }}
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="text-muted form-label">
                        Harga
                    </label>

                    <div class="bg-light form-control fw-semibold">
                        {{ $product->formatted_price }}
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="mb-3 col-md-6">
                    <label class="text-muted form-label">
                        Stok
                    </label>

                    <div class="bg-light form-control">
                        {{ $product->stock }}
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="text-muted form-label">
                        Status
                    </label>

                    <div>
                        <span class="badge bg-{{ $product->status->color() }}">
                            {{ $product->status->label() }}
                        </span>

                        @if($product->is_featured)
                            <span class="bg-warning text-dark badge">
                                Featured
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="mb-3">
                <label class="text-muted form-label">
                    Slug
                </label>

                <div class="bg-light form-control">
                    {{ $product->slug }}
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted form-label">
                    Deskripsi
                </label>

                <div class="bg-light form-control" style="min-height:120px;">
                    {{ $product->description ?: '-' }}
                </div>
            </div>

            <div class="text-muted small">
                Dibuat:
                {{ $product->created_at->format('d M Y H:i') }}
            </div>

        </div>
    </div>
</div>

</div>

@if($related->count())

<div class="shadow-sm mt-4 border-0 card">
    <div class="bg-white card-header">
        <h6 class="mb-0">
            Produk Terkait
        </h6>
    </div>

<div class="card-body">
    <div class="row">

        @foreach($related as $item)
            <div class="mb-3 col-md-3">
                <div class="shadow-sm border-0 h-100 card">

                    <div class="card-body">

                        <h6 class="fw-semibold">
                            {{ $item->name }}
                        </h6>

                        <div class="mb-2 text-muted small">
                            {{ $item->formatted_price }}
                        </div>

                        <a href="{{ route('products.show', $item) }}"
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
