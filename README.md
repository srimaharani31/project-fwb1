<p align="center"><strong> Sistem Informasi penjualan online Thrift Shop</strong></p>

<div align="center">

![logo_unsulbar](public/logo.jpeg)


<b>Sri maharani</b><br>
<b>D0222034</b><br>
<b>Framework Web Based</b><br>
<b>2025</b>
</div>

---

## 🔐 Role & Hak Akses

### 1. Pelanggan (`role: pelanggan`)
Pengguna umum yang dapat menjelajahi dan membeli produk.

#### Fitur:
- Registrasi & Login
- Melihat daftar produk
- Menambahkan produk ke keranjang (opsional)
- Melakukan pemesanan (checkout)
- Melihat status & riwayat pesanan
- Memberi ulasan/rating pada produk yang dibeli

---

### 2. Owner (`role: owner`)
Pemilik toko yang dapat mengelola produk thrift yang dijual.

#### Fitur:
- Login ke dashboard
- Menambahkan produk baru
- Mengedit dan menghapus produk
- Melihat dan mengelola pesanan yang masuk
- Melihat statistik penjualan
- Melihat ulasan pelanggan terhadap produknya

---

### 3. Admin (`role: admin`)
Pengelola sistem yang memiliki akses penuh terhadap semua data dan pengguna.

#### Fitur:
- Login ke dashboard admin
- Mengelola semua data user (owner & pelanggan)
- Meninjau atau menghapus produk jika perlu
- Mengelola kategori produk
- Melihat dan mengelola seluruh pesanan
- Menangani laporan atau penyalahgunaan sistem
- Konfigurasi umum sistem

---

### 1. `users`

| Field      | Tipe Data      | Keterangan                                  |
|------------|----------------|---------------------------------------------|
| id         | BIGINT (PK)    | Primary key                                 |
| name       | VARCHAR(255)   | Nama pengguna                               |
| email      | VARCHAR(255)   | Email unik                                  |
| password   | VARCHAR(255)   | Terenkripsi (bcrypt)                        |
| role       | ENUM           | 'pelanggan', 'owner', 'admin'               |
| created_at | TIMESTAMP      | Tanggal dibuat                              |
| updated_at | TIMESTAMP      | Terakhir diperbarui                         |

---

### 2. `categories`

| Field      | Tipe Data      | Keterangan                                  |
|------------|----------------|---------------------------------------------|
| id         | BIGINT (PK)    | Primary key                                 |
| name       | VARCHAR(100)   | Nama kategori                               |
| created_at | TIMESTAMP      | Tanggal dibuat                              |
| updated_at | TIMESTAMP      | Terakhir diperbarui                         |

---

### 3. `products`

| Field        | Tipe Data      | Keterangan                                  |
|--------------|----------------|---------------------------------------------|
| id           | BIGINT (PK)    | Primary key                                 |
| owner_id     | BIGINT (FK)    | FK ke `users.id` (role: owner)              |
| category_id  | BIGINT (FK)    | FK ke `categories.id`, nullable             |
| name         | VARCHAR(255)   | Nama produk                                 |
| description  | TEXT           | Deskripsi produk                            |
| price        | DECIMAL(10,2)  | Harga produk                                |
| stock        | INT            | Stok tersedia                               |
| image        | VARCHAR(255)   | Path/URL gambar produk                      |
| created_at   | TIMESTAMP      | Tanggal dibuat                              |
| updated_at   | TIMESTAMP      | Terakhir diperbarui                         |

---

### 4. `orders`

| Field        | Tipe Data      | Keterangan                                  |
|--------------|----------------|---------------------------------------------|
| id           | BIGINT (PK)    | Primary key                                 |
| user_id      | BIGINT (FK)    | FK ke `users.id` (role: pelanggan)          |
| total_price  | DECIMAL(10,2)  | Total harga seluruh pesanan                 |
| status       | ENUM           | 'pending', 'paid', 'shipped', 'completed', 'cancelled' |
| created_at   | TIMESTAMP      | Tanggal dibuat                              |
| updated_at   | TIMESTAMP      | Terakhir diperbarui                         |

---

### 5. `order_items`

| Field       | Tipe Data      | Keterangan                                  |
|-------------|----------------|---------------------------------------------|
| id          | BIGINT (PK)    | Primary key                                 |
| order_id    | BIGINT (FK)    | FK ke `orders.id`                           |
| product_id  | BIGINT (FK)    | FK ke `products.id`                         |
| quantity    | INT            | Jumlah produk                               |
| price       | DECIMAL(10,2)  | Harga produk saat dipesan                   |
| created_at  | TIMESTAMP      | Tanggal dibuat                              |
| updated_at  | TIMESTAMP      | Terakhir diperbarui                         |

---

### 6. `reviews`

| Field       | Tipe Data      | Keterangan                                  |
|-------------|----------------|---------------------------------------------|
| id          | BIGINT (PK)    | Primary key                                 |
| user_id     | BIGINT (FK)    | FK ke `users.id`                            |
| product_id  | BIGINT (FK)    | FK ke `products.id`                         |
| rating      | TINYINT        | Nilai 1–5                                   |                            
| created_at  | TIMESTAMP      | Tanggal dibuat                              |
| updated_at  | TIMESTAMP      | Terakhir diperbarui                         |

---


## 🔗 Jenis Relasi Antar Tabel

| No. | Tabel A        | Tabel B         | Jenis Relasi     | Penjelasan                                                                 |
|-----|----------------|------------------|------------------|----------------------------------------------------------------------------|
| 1   | users          | products         | One to Many      | Satu **owner** bisa memiliki banyak **produk**                             |
| 2   | users          | orders           | One to Many      | Satu **pelanggan** bisa membuat banyak **pesanan**                         |
| 3   | orders         | order_items      | One to Many      | Satu **pesanan** bisa memiliki banyak **item**                             |
| 4   | products       | order_items      | One to Many      | Satu **produk** bisa muncul di banyak **item pesanan**                     |
| 5   | users          | reviews          | One to Many      | Satu **user** bisa memberikan banyak **ulasan produk**                     |
| 6   | products       | reviews          | One to Many      | Satu **produk** bisa memiliki banyak **ulasan**                            |
| 7   | categories     | products         | One to Many      | Satu **kategori** bisa digunakan oleh banyak **produk**                    |

