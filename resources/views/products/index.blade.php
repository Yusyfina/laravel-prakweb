{{-- 1. Tentukan layout induk --}}
@extends('layouts.master')

{{-- 2. Override title --}}
@section('title', 'Daftar Produk')

{{-- 3. Tambahkan CSS khusus halaman ini --}}
@push('styles')
    <style>
        .product-card:hover {
            transform: translateY(-3px);
            transition: .2s;
        }
    </style>
@endpush

{{-- 4. Isi konten utama --}}
@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="me-2 text-primary bi bi-box-seam"></i>
                Daftar Produk
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Produk
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="me-1 bi bi-plus-lg"></i>
            Tambah Produk
        </a>
    </div>

    {{-- Filter --}}
    <div class="shadow-sm mb-4 border-0 card" style="border-radius:12px;">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="w-100 btn btn-primary">
                        <i class="me-1 bi bi-search"></i>
                        Cari
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('products.index') }}" class="btn-outline-secondary w-100 btn">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="shadow-sm border-0 card" style="border-radius:12px;">
        <div class="p-0 card-body">

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:.88rem;">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="px-4 py-3 border-0">#</th>
                            <th class="py-3 border-0">Produk</th>
                            <th class="py-3 border-0">Kategori</th>
                            <th class="py-3 border-0 text-end">Harga</th>
                            <th class="py-3 border-0 text-center">Stok</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="py-3 border-0 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-4 py-3 text-muted">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>

                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">

                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="border rounded-2"
                                                style="width:44px; height:44px; object-fit:cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light border rounded-2"
                                                style="width:44px; height:44px;">
                                                <i class="text-muted bi bi-image"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $product->name }}
                                            </div>

                                            @if ($product->is_featured)
                                                <span class="bg-warning text-dark badge" style="font-size:.7rem;">
                                                    ⭐ Featured
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </td>

                                <td class="py-3">
                                    <span class="bg-light border text-dark badge">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="py-3 text-end fw-semibold">
                                    {{ $product->formatted_price }}
                                </td>

                                <td class="py-3 text-center">
                                    <span
                                        class="badge {{ $product->stock === 0 ? 'bg-danger' : ($product->stock <= 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                <td class="py-3 text-center">
                                    {{-- Menggunakan Enum untuk badge --}}
                                    <span class="badge bg-{{ $product->status->color() }}">
                                        {{ $product->status->label() }}
                                    </span>
                                </td>

                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('products.show', $product) }}"
                                            class="btn-outline-info btn btn-sm" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('products.edit', $product) }}"
                                            class="btn-outline-warning btn btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Hapus produk \'{{ addslashes($product->name) }}\'?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-outline-danger btn btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-muted text-center">
                                    <i class="d-block opacity-50 mb-2 bi bi-inbox fs-1"></i>

                                    <div class="fw-semibold">
                                        Tidak ada produk ditemukan
                                    </div>

                                    @if (request('search'))
                                        <div class="mt-1 small">
                                            Tidak ada hasil untuk
                                            "<strong>{{ request('search') }}</strong>"
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="d-flex align-items-center justify-content-between bg-white px-4 py-3 border-top card-footer">
                <div class="text-muted small">
                    Menampilkan
                    <strong>{{ $products->firstItem() }}</strong>
                    –
                    <strong>{{ $products->lastItem() }}</strong>

                    dari

                    <strong>{{ $products->total() }}</strong>
                    produk
                </div>

                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

@endsection

{{-- 5. JS khusus halaman ini --}}
@push('scripts')
    <script>
        // Auto-hide alert setelah 4 detik
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                bootstrap.Alert.getOrCreateInstance(el).close();
            });
        }, 4000);
    </script>
@endpush
