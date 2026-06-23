# CRUD Laravel

## Deskripsi
Proyek ini dibuat untuk memenuhi Tugas Praktikum Challenge Bab 3 mata kuliah Praktikum Pemrograman Web Berbasis Framework menggunakan Laravel.

---

## Oleh

Nama : Yusyfina Yuniarti
NIM : 230102128
Kelas : IF23B

---

# Challenge Praktikum Bab 3
## Fitur CRUD Kategori End-to-End

### Migration Tabel Categories

Tabel `categories` digunakan untuk menyimpan data kategori produk dengan struktur data ada name, slug, description, is_active, timestamps

---

### Model Category dengan scopeActive()

Model `Category` memiliki local scope `scopeActive()` yang digunakan untuk menampilkan kategori yang masih aktif.

```php
public function scopeActive($query)
{
    return $query->where('is_active', true);
}
```

Contoh penggunaan:

```php
Category::active()->get();
```

---

### CategoryController

| Method | Fungsi |
|----------|---------|
| index() | Menampilkan daftar kategori |
| create() | Menampilkan form tambah kategori |
| store() | Menyimpan kategori baru |
| show() | Menampilkan detail kategori |
| edit() | Menampilkan form edit kategori |
| update() | Memperbarui data kategori |
| destroy() | Menghapus kategori |

Route yang digunakan:

```php
Route::resource('categories', CategoryController::class);
```

---

### Validasi Unik pada Kolom Name dan Slug

Untuk mencegah data duplikat, sistem menerapkan validasi unik pada kolom `name` dan `slug`.

Validasi saat menambah data:

```php
'name' => 'required|string|min:3|max:100|unique:categories,name',
'slug' => 'required|string|max:100|unique:categories,slug',
```

Validasi saat mengubah data:

```php
'name' => 'required|string|min:3|max:100|unique:categories,name,' . $category->id,
'slug' => 'required|string|max:100|unique:categories,slug,' . $category->id,
```

Dengan validasi ini, nama dan slug kategori tidak dapat digunakan lebih dari satu kali.

---

### View Index, Create, dan Edit Menggunakan Layout Master

Seluruh halaman kategori menggunakan layout utama aplikasi:

```blade
@extends('layouts.master')
```

---

### Slug Otomatis dari Nama Menggunakan JavaScript

Saat pengguna mengetik nama kategori, sistem secara otomatis menghasilkan slug menggunakan JavaScript.

Contoh:

```text
Nama Kategori:
Elektronik Gaming
```

Otomatis menjadi:

```text
Slug:
elektronik-gaming
```

---

### Konfirmasi Hapus Menggunakan Bootstrap Modal

Sebelum data kategori dihapus, sistem akan menampilkan Bootstrap Modal sebagai konfirmasi.

---

### Constraint: Kategori Tidak Dapat Dihapus Jika Masih Memiliki Produk Aktif

Sistem menerapkan aturan bahwa kategori tidak boleh dihapus apabila masih memiliki produk aktif.

Implementasi:

```php
public function destroy(Category $category): RedirectResponse
    {
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
```

---
# Challenge Praktikum Bab 4

## Challenge 1 - Database Schema Toko Lengkap

- Membuat migration tabel `reviews`
- Membuat migration tabel `coupons`
- Menambahkan foreign key dan relasi database
- Menambahkan index untuk optimasi query

## Challenge 2 - Factory & Seeder Realistis

- Membuat `ReviewFactory`
- Mengatur distribusi rating realistis:
  - 40% rating 5
  - 30% rating 4
  - 20% rating 3
  - 10% rating 1–2
- Membuat 300 data review menggunakan seeder
- Menjaga konsistensi relasi antar tabel

## Challenge 3 - Query Builder Reporting

- Membuat halaman laporan menggunakan Query Builder
- Menampilkan analisis sentimen rating:
  - Positif (4–5)
  - Netral (3)
  - Negatif (1–2)
- Menampilkan jumlah kupon aktif
- Menampilkan jumlah kupon kadaluarsa
- Menampilkan total penggunaan kupon
- Memodifikasi dashboard dengan grafik 

---
