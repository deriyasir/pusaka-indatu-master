## _Pusaka Indatu_

## Installation

Pusaka indatu requires [PHP](https://php.net/) v8.0+ to run.

clone repo ini atau bisa juga download via .zip file

```sh
git clone https://github.com/nafaarts/pusaka-indatu.git
```
masuk ke dalam direktori aplikasi 
```sh
cd pusaka-indatu
```
install composer
```sh
composer install
```
cek file .env kalo engga ada copy .env.example tapi diubah namanya jadi .env
```sh
cp .env.example .env
```
habis itu, generate key nya
```sh
php artisan key:generate
```
coba cek ke folder database, ada ga file database.sqlite
kalo engga ada dibuat manual aja di vscode, kalo ada lanjut.
```sh
php artisan migrate
```
sip, database dah siap. tapi masih install pake SQLITE (biar cepet), ntar kalo pake MYSQL tinggal ganti aja di .env nya

oke, kalo udah aman database, kita seeding biar gausah repot tambah data buat testing.
```sh
php artisan db:seed --class=DatabaseSeeder
```
woke mantap, cek database nya, data sample udah ready.

tapi untuk konfigurasi payment gateway nya (midtrans) sama ongkir (rajaongkir) belum bisa dipake, karena belum kita buat di .env nya.

jadi, masuk ke file .env, isi baris dibawah ini
```sh
RAJAONGKIR_KEY=
RAJAONGKIR_URL=https://api.rajaongkir.com/starter

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
```
sama konfigurasi SMTP email juga di isi
```sh
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```
sip, kalo udah kita clear cache dulu buat jaga jaga
```sh
php artisan config:clear
```
woke, tinggal running aja aplikasinya
```sh
php artisan serve
```

## Plugins

di aplikasi ini ada pake beberapa plugin.

| Plugin | fungsinya |
| ------ | ------ |
| midtrans/midtrans-php | untuk konfigurasi token punya nya midtrans biar bisa dipake bayar bayar |
|fzaninotto/faker|buat fake data (yang seeder tadi) biar ga repot isi isi buat test|
|laravel/ui|biar cepet bikin authentikasi (kaya udah template gitu)|

