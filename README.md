
## Instalasi

1. Clone repositori ini: `git clone https://github.com/chzkyy/api-plantstore.git`
2. Buka direktori proyek: `cd repo-anda`
3. Install dependensi: `composer install`
4. Salin file `.env.example` dan ubah namanya menjadi `.env`
5. Generate key aplikasi: `php artisan key:generate`
6. Konfigurasi koneksi database di file `.env`
7. Pada file `.env` tambahkan 
        PLANTSTORE_PASSWORD=
8. Jalankan migrasi database: `php artisan migrate`
9. Jalankan seeder dengan menggunakan perintah `php artisan db:seed`
10. Jalankan server pengembangan: `php artisan serve`

## Dokumentasi API

Anda dapat membuka dokumentasi API [di sini](https://documenter.getpostman.com/view/20223372/2sA35A64JL).


## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, ikuti langkah-langkah berikut:

1. Fork repositori ini
2. Buat branch baru: `git checkout -b main`
3. Lakukan perubahan dan commit: `git commit -m 'Tambahkan fitur baru'`
4. Push ke branch: `git push origin main`
5. Ajukan pull request
