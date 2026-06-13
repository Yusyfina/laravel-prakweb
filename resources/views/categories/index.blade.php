{{-- challenge bab3 - view index kategori menggunakan layout layouts.master --}}
@extends('layouts.master')

@section('title', 'Daftar Kategori')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="me-2 text-primary bi bi-tags"></i>
                Daftar Kategori
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Kategori
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="me-1 bi bi-plus-lg"></i>
            Tambah Kategori
        </a>
    </div>

    {{-- Tabel Kategori --}}
    <div class="shadow-sm border-0 card" style="border-radius:12px;">
        <div class="p-0 card-body">

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:.88rem;">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="px-4 py-3 border-0">#</th>
                            <th class="py-3 border-0">Nama</th>
                            <th class="py-3 border-0">Slug</th>
                            <th class="py-3 border-0">Deskripsi</th>
                            <th class="py-3 border-0 text-center">Produk</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="py-3 border-0 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-4 py-3 text-muted">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td class="py-3 fw-semibold">
                                    {{ $category->name }}
                                </td>

                                <td class="py-3">
                                    <span class="font-monospace text-muted small">
                                        {{ $category->slug }}
                                    </span>
                                </td>

                                <td class="py-3 text-muted small" style="max-width:200px;">
                                    {{ Str::limit($category->description, 60) ?? '-' }}
                                </td>

                                <td class="py-3 text-center">
                                    <span class="bg-secondary badge">
                                        {{ $category->products_count }}
                                    </span>
                                </td>

                                <td class="py-3 text-center">
                                    @if ($category->is_active)
                                        <span class="bg-success badge">Aktif</span>
                                    @else
                                        <span class="bg-secondary badge">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('categories.show', $category) }}"
                                            class="btn btn-info btn-sm"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="btn-outline-warning btn btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- challenge bab3 - konfirmasi hapus menggunakan Bootstrap Modal --}}
                                        <button
                                            type="button"
                                            class="btn-outline-danger btn btn-sm"
                                            title="Hapus"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-category-id="{{ $category->id }}"
                                            data-category-name="{{ $category->name }}"
                                            data-category-products="{{ $category->products_count }}"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-muted text-center">
                                    <i class="d-block opacity-50 mb-2 bi bi-tags fs-1"></i>

                                    <div class="fw-semibold">
                                        Belum ada kategori
                                    </div>

                                    <div class="mt-2">
                                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                                            <i class="me-1 bi bi-plus-lg"></i>
                                            Tambah Kategori Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Pagination --}}
        @if ($categories->hasPages())
            <div class="d-flex align-items-center justify-content-between bg-white px-4 py-3 border-top card-footer">
                <div class="text-muted small">
                    Menampilkan
                    <strong>{{ $categories->firstItem() }}</strong>
                    –
                    <strong>{{ $categories->lastItem() }}</strong>

                    dari

                    <strong>{{ $categories->total() }}</strong>
                    kategori
                </div>

                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

    {{-- challenge bab3 - Bootstrap Modal konfirmasi hapus kategori --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="border-0 modal-header">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">
                        <i class="me-2 text-danger bi bi-exclamation-triangle-fill"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-1">
                        Apakah Anda yakin ingin menghapus kategori:
                    </p>
                    <p class="fw-bold fs-5" id="modalCategoryName"></p>

                    {{-- challenge bab3 - peringatan jika kategori masih memiliki produk --}}
                    <div id="modalProductWarning" class="mb-0 alert alert-warning d-none" role="alert">
                        <i class="me-2 bi bi-exclamation-triangle"></i>
                        <span id="modalProductWarningText"></span>
                    </div>

                    <p class="mb-0 text-muted small" id="modalNoProductNote">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>

                <div class="border-0 modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="btnDeleteConfirm">
                            <i class="me-1 bi bi-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Auto-hide alert setelah 4 detik
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                bootstrap.Alert.getOrCreateInstance(el).close();
            });
        }, 4000);

        //challenge bab3 - mengisi data modal hapus dari tombol yang diklik
        document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
            const button       = event.relatedTarget;
            const categoryId   = button.getAttribute('data-category-id');
            const categoryName = button.getAttribute('data-category-name');
            const productCount = parseInt(button.getAttribute('data-category-products'), 10);

            // Isi nama kategori di modal
            document.getElementById('modalCategoryName').textContent = categoryName;

            // Set action form hapus
            document.getElementById('deleteForm').action = '/categories/' + categoryId;

            //challenge bab3 - tampilkan peringatan jika masih ada produk terkait
            const warningEl     = document.getElementById('modalProductWarning');
            const warningTextEl = document.getElementById('modalProductWarningText');
            const noteEl        = document.getElementById('modalNoProductNote');

            if (productCount > 0) {
                warningTextEl.textContent =
                    'Kategori ini memiliki ' + productCount + ' produk. ' +
                    'Kategori tidak dapat dihapus jika masih memiliki produk aktif.';
                warningEl.classList.remove('d-none');
                noteEl.classList.add('d-none');
            } else {
                warningEl.classList.add('d-none');
                noteEl.classList.remove('d-none');
            }
        });
    </script>

@endpush
