# BOILERPLATE-KUNCIKARYA

## Deskripsi
Boilerplate ini dibangun menggunakan Laravel dan dilengkapi dengan berbagai fitur untuk mempercepat pengembangan aplikasi web. Sudah terintegrasi dengan **Spatie Permission**, **Materialize**, **Bootstrap 5**, **Log Helper**, **CRUD Trait**, dan **CreatedByTrait**. Tujuan utama dari boilerplate ini adalah untuk memberikan dasar yang kuat bagi pengembangan aplikasi dengan modul manajemen pengguna dan hak akses, tampilan yang modern, serta pengelolaan log dan pengelolaan data yang mudah.

## Fitur Utama

- **Spatie Permission**: Mengelola peran dan izin pengguna.
- **Materialize**: Digunakan sebagai framework UI untuk tampilan modern dan responsif.
- **Bootstrap 5**: Alternatif styling dan utility class yang fleksibel.
- **Log Helper**: Membantu pencatatan log aktivitas aplikasi.
- **CRUD Trait**: Memudahkan implementasi operasi Create, Read, Update, Delete pada model.
- **CreatedByTrait**: Otomatis menambahkan informasi siapa yang membuat dan memperbarui entitas dalam database.

## Instalasi

Ikuti langkah-langkah di bawah ini untuk memulai proyek ini:

### 1. Clone Repository

```bash
git clone https://github.com/username/repo.git
cd repo
```
### 2. Konfigurasi Environment

Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturannya, terutama untuk koneksi database:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 3. Migrasi dan Seeder Database

Lakukan migrasi dan jalankan seeder untuk membuat struktur tabel serta data awal yang diperlukan:

```bash
php artisan migrate --seed
```

### 4. Jalankan Aplikasi

Jalankan aplikasi menggunakan server lokal bawaan Laravel:

```bash
php artisan serve
```

## Penggunaan Fitur

### 1. **Spatie Permission**

Boilerplate ini sudah terintegrasi dengan Spatie Permission, yang memungkinkan Anda untuk mengelola **roles** dan **permissions**. Anda dapat membuat peran dan memberikan izin sesuai kebutuhan aplikasi Anda.

Untuk menambahkan peran atau izin, Anda bisa menggunakan command artisan atau melalui database.

### 2. **Materialize dan Bootstrap 5**

Kami menggunakan **Materialize** sebagai framework utama untuk UI dengan komponen yang elegan dan mudah digunakan. Namun, **Bootstrap 5** juga disertakan untuk utility classes dan beberapa komponen tambahan.

Sesuaikan tampilan sesuai keinginan dengan mengubah template yang tersedia di dalam folder `resources/views/`.

### 3. **Log Helper**

Helper ini digunakan untuk memudahkan pencatatan log aktivitas di dalam aplikasi. Misalnya, untuk mencatat aktivitas user atau peristiwa penting lainnya.

### 4. **CRUD Trait**

Trait ini digunakan untuk mengimplementasikan operasi CRUD pada model dengan mudah. Anda dapat menerapkannya pada controller atau repository Anda, menghemat waktu dalam menulis logika dasar CRUD.

```php
use App\Traits\CrudTrait;

class UserController extends Controller
{
    use CrudTrait;
}
```

### 5. **CreatedByTrait**

Trait ini digunakan untuk secara otomatis menyimpan informasi `created_by` dan `updated_by` pada model yang bersangkutan. Setiap kali data dibuat atau diperbarui, trait ini akan mengisi field tersebut dengan ID pengguna yang sedang aktif.

Tambahkan trait ini ke model yang memerlukan:

```php
use App\Traits\CreatedByTrait;

class Post extends Model
{
    use CreatedByTrait;
}
```