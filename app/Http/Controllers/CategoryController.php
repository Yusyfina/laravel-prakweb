<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //challenge bab3 - menampilkan seluruh kategori
    public function index(): View
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    //challenge bab3 - menampilkan form tambah kategori baru
    public function create(): View
    {
        return view('categories.create');
    }

    //challenge bab3 - menyimpan kategori baru ke database
    public function store(Request $request): RedirectResponse
    {
        //challenge bab3 - validasi unique name dan slug
        $validated = $request->validate([
            'name'        => 'required|string|min:3|max:100|unique:categories,name',
            'slug'        => 'required|string|max:100|unique:categories,slug',
            'description' => 'nullable|string|max:5000',
            'is_active'   => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
            'name.min'      => 'Nama kategori minimal 3 karakter.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique'   => 'Slug sudah digunakan oleh kategori lain.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

   //challenge bab3 - menampilkan detail kategori beserta produk yang dimiliki
    public function show(Category $category)
    {
        $category->load('products');

        return view('categories.show', compact('category'));
    }

    //challenge bab3 - menampilkan form edit kategori
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    //challenge bab3 - memperbarui data kategori
    public function update(Request $request, Category $category): RedirectResponse
    {
        //challenge bab3 - validasi unique name dan slug (kecuali milik kategori saat ini)
        $validated = $request->validate([
            'name'        => 'required|string|min:3|max:100|unique:categories,name,' . $category->id,
            'slug'        => 'required|string|max:100|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:5000',
            'is_active'   => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
            'name.min'      => 'Nama kategori minimal 3 karakter.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique'   => 'Slug sudah digunakan oleh kategori lain.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', "Kategori \"{$category->name}\" berhasil diperbarui!");
    }

    //challenge bab3 - menghapus kategori dari database
    public function destroy(Category $category): RedirectResponse
    {
        //challenge bab3 - mencegah kategori dihapus jika masih memiliki produk aktif
        $activeProductCount = $category->products()
            ->whereNull('deleted_at')
            ->where('status', 'active')
            ->count();

        if ($activeProductCount > 0) {
            return redirect()->route('categories.index')
                ->with('error', "Kategori \"{$category->name}\" tidak dapat dihapus karena masih memiliki {$activeProductCount} produk aktif.");
        }

        $nama = $category->name;
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', "Kategori \"{$nama}\" berhasil dihapus.");
    }

}
