{{-- challenge bab3 - view form tambah kategori menggunakan layout layouts.master --}}
@extends('layouts.master')

@section('title', 'Tambah Kategori')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="me-2 text-primary bi bi-tags"></i>
                Tambah Kategori Baru
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.index') }}">Kategori</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="bi-arrow-left me-1 bi"></i>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ Gagal Menyimpan!</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="shadow-sm border-0 card" style="border-radius:12px;">
        <div class="p-4 card-body">

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        Nama Kategori <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="contoh: Elektronik"
                        autocomplete="off"
                    >
                    @error('name')
                        <div class="d-block invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">
                        Slug <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug') }}"
                        placeholder="contoh: elektronik"
                        autocomplete="off"
                    >
                    <div class="form-text">
                        <i class="me-1 bi bi-info-circle"></i>
                        Slug akan terisi otomatis dari nama kategori. Gunakan huruf kecil, angka, dan tanda hubung saja.
                    </div>
                    @error('slug')
                        <div class="d-block invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        placeholder="Deskripsi singkat kategori (opsional)"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="d-block invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', '1') ? 'checked' : '' }}
                        >
                        <label class="form-check-label fw-semibold" for="is_active">
                            Aktif
                        </label>
                    </div>
                    <div class="form-text">Kategori aktif akan muncul di daftar pilihan produk.</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="me-1 bi bi-save"></i>
                        Simpan Kategori
                    </button>

                    <a href="{{ route('categories.index') }}" class="btn-outline-secondary btn">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        //challenge bab3 - membuat slug otomatis dari nama kategori menggunakan JavaScript
        (function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            // Fungsi konversi nama ke slug
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .trim()
                    // Ganti karakter beraksent ke ASCII
                    .replace(/[àáâãäå]/g, 'a')
                    .replace(/[èéêë]/g, 'e')
                    .replace(/[ìíîï]/g, 'i')
                    .replace(/[òóôõö]/g, 'o')
                    .replace(/[ùúûü]/g, 'u')
                    .replace(/[ñ]/g, 'n')
                    // Ganti spasi dan karakter non-alphanumeric dengan tanda hubung
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s]+/g, '-')
                    // Hapus tanda hubung berlebih di awal/akhir
                    .replace(/^-+|-+$/g, '');
            }

            // Saat nama berubah, update slug otomatis (hanya jika slug belum diedit manual)
            let slugManuallyEdited = false;

            nameInput.addEventListener('input', function () {
                if (!slugManuallyEdited) {
                    slugInput.value = generateSlug(this.value);
                }
            });

            // Tandai jika user mengedit slug secara manual
            slugInput.addEventListener('input', function () {
                slugManuallyEdited = (this.value !== generateSlug(nameInput.value));
            });

            // Reset flag jika slug dikosongkan
            slugInput.addEventListener('blur', function () {
                if (this.value === '') {
                    slugManuallyEdited = false;
                    this.value = generateSlug(nameInput.value);
                }
            });
        })();
    </script>
@endpush
