<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\DetailPenjualan;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Kategoris
        $kategoris = [
            ['id_kategori' => 1, 'nama_kategori' => 'Smartphone'],
            ['id_kategori' => 2, 'nama_kategori' => 'Laptop'],
            ['id_kategori' => 3, 'nama_kategori' => 'Aksesoris'],
            ['id_kategori' => 4, 'nama_kategori' => 'Audio'],
        ];
        foreach ($kategoris as $k) {
            Kategori::create($k);
        }

        // Create Brands
        $brands = [
            ['id_brand' => 1, 'nama_brand' => 'AstraTech'],
            ['id_brand' => 2, 'nama_brand' => 'NovaWare'],
            ['id_brand' => 3, 'nama_brand' => 'Voltix'],
            ['id_brand' => 4, 'nama_brand' => 'Lumi'],
        ];
        foreach ($brands as $b) {
            Brand::create($b);
        }

        // Create Produks
        $produks = [
            ['id_produk' => 1, 'nama_produk' => 'Astra X1', 'tipe_produk' => 'Smartphone', 'id_kategori' => 1, 'id_brand' => 1, 'harga' => 4299000, 'terjual' => 114],
            ['id_produk' => 2, 'nama_produk' => 'Astra X1 Pro', 'tipe_produk' => 'Smartphone', 'id_kategori' => 1, 'id_brand' => 1, 'harga' => 6299000, 'terjual' => 88],
            ['id_produk' => 3, 'nama_produk' => 'NovaBook Air', 'tipe_produk' => 'Laptop', 'id_kategori' => 2, 'id_brand' => 2, 'harga' => 11299000, 'terjual' => 42],
            ['id_produk' => 4, 'nama_produk' => 'NovaBook Pro', 'tipe_produk' => 'Laptop', 'id_kategori' => 2, 'id_brand' => 2, 'harga' => 15899000, 'terjual' => 35],
            ['id_produk' => 5, 'nama_produk' => 'Voltix Buds', 'tipe_produk' => 'TWS', 'id_kategori' => 4, 'id_brand' => 3, 'harga' => 799000, 'terjual' => 196],
            ['id_produk' => 6, 'nama_produk' => 'Lumi Soundbar Mini', 'tipe_produk' => 'Speaker', 'id_kategori' => 4, 'id_brand' => 4, 'harga' => 1499000, 'terjual' => 51],
            ['id_produk' => 7, 'nama_produk' => 'Voltix Charger 65W', 'tipe_produk' => 'Adapter', 'id_kategori' => 3, 'id_brand' => 3, 'harga' => 329000, 'terjual' => 204],
            ['id_produk' => 8, 'nama_produk' => 'Lumi Cable C-C', 'tipe_produk' => 'Kabel', 'id_kategori' => 3, 'id_brand' => 4, 'harga' => 109000, 'terjual' => 280],
            ['id_produk' => 9, 'nama_produk' => 'Astra Tab Lite', 'tipe_produk' => 'Tablet', 'id_kategori' => 1, 'id_brand' => 1, 'harga' => 3799000, 'terjual' => 61],
            ['id_produk' => 10, 'nama_produk' => 'NovaDock Multiport', 'tipe_produk' => 'Dock', 'id_kategori' => 3, 'id_brand' => 2, 'harga' => 699000, 'terjual' => 75],
        ];
        foreach ($produks as $p) {
            Produk::create($p);
        }

        // Create Stoks
        $stoks = [
            ['id_stok' => 1, 'id_produk' => 1, 'jumlah' => 28],
            ['id_stok' => 2, 'id_produk' => 2, 'jumlah' => 16],
            ['id_stok' => 3, 'id_produk' => 3, 'jumlah' => 11],
            ['id_stok' => 4, 'id_produk' => 4, 'jumlah' => 8],
            ['id_stok' => 5, 'id_produk' => 5, 'jumlah' => 74],
            ['id_stok' => 6, 'id_produk' => 6, 'jumlah' => 22],
            ['id_stok' => 7, 'id_produk' => 7, 'jumlah' => 93],
            ['id_stok' => 8, 'id_produk' => 8, 'jumlah' => 144],
            ['id_stok' => 9, 'id_produk' => 9, 'jumlah' => 17],
            ['id_stok' => 10, 'id_produk' => 10, 'jumlah' => 39],
        ];
        foreach ($stoks as $s) {
            Stok::create($s);
        }

        // Create Customers
        $customers = [
            ['id_customer' => 1, 'nama' => 'Rizky Aditya', 'no_hp' => '081234567890', 'alamat' => 'Bandung'],
            ['id_customer' => 2, 'nama' => 'Salsa Maulida', 'no_hp' => '081234567891', 'alamat' => 'Jakarta'],
            ['id_customer' => 3, 'nama' => 'Budi Wijaya', 'no_hp' => '081234567892', 'alamat' => 'Surabaya'],
            ['id_customer' => 4, 'nama' => 'Nina Maharani', 'no_hp' => '081234567893', 'alamat' => 'Semarang'],
            ['id_customer' => 5, 'nama' => 'Andi Kurnia', 'no_hp' => '081234567894', 'alamat' => 'Yogyakarta'],
        ];
        foreach ($customers as $c) {
            Customer::create($c);
        }

        // Create Penjualans
        $penjualans = [
            ['id_penjualan' => 1, 'id_customer' => 1, 'id_user' => null, 'tanggal' => '2026-05-01', 'total' => 5097000],
            ['id_penjualan' => 2, 'id_customer' => 2, 'id_user' => null, 'tanggal' => '2026-05-02', 'total' => 14698000],
            ['id_penjualan' => 3, 'id_customer' => 3, 'id_user' => null, 'tanggal' => '2026-05-02', 'total' => 799000],
            ['id_penjualan' => 4, 'id_customer' => 4, 'id_user' => null, 'tanggal' => '2026-05-03', 'total' => 6628000],
        ];
        foreach ($penjualans as $pj) {
            Penjualan::create($pj);
        }

        // Create DetailPenjualans
        $detailPenjualans = [
            ['id_detail' => 1, 'id_penjualan' => 1, 'id_produk' => 1, 'jumlah' => 1, 'harga' => 4299000, 'subtotal' => 4299000],
            ['id_detail' => 2, 'id_penjualan' => 1, 'id_produk' => 7, 'jumlah' => 1, 'harga' => 329000, 'subtotal' => 329000],
            ['id_detail' => 3, 'id_penjualan' => 1, 'id_produk' => 8, 'jumlah' => 3, 'harga' => 109000, 'subtotal' => 327000],
            ['id_detail' => 4, 'id_penjualan' => 2, 'id_produk' => 3, 'jumlah' => 1, 'harga' => 11299000, 'subtotal' => 11299000],
            ['id_detail' => 5, 'id_penjualan' => 2, 'id_produk' => 5, 'jumlah' => 2, 'harga' => 799000, 'subtotal' => 1598000],
            ['id_detail' => 6, 'id_penjualan' => 2, 'id_produk' => 10, 'jumlah' => 1, 'harga' => 699000, 'subtotal' => 699000],
            ['id_detail' => 7, 'id_penjualan' => 3, 'id_produk' => 5, 'jumlah' => 1, 'harga' => 799000, 'subtotal' => 799000],
            ['id_detail' => 8, 'id_penjualan' => 4, 'id_produk' => 2, 'jumlah' => 1, 'harga' => 6299000, 'subtotal' => 6299000],
            ['id_detail' => 9, 'id_penjualan' => 4, 'id_produk' => 8, 'jumlah' => 3, 'harga' => 109000, 'subtotal' => 327000],
            ['id_detail' => 10, 'id_penjualan' => 4, 'id_produk' => 10, 'jumlah' => 1, 'harga' => 699000, 'subtotal' => 699000],
        ];
        foreach ($detailPenjualans as $dp) {
            DetailPenjualan::create($dp);
        }
    }
}
