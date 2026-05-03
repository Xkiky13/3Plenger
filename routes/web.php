<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

if (! function_exists('sales_seed_data')) {
    function sales_seed_data(): array
    {
        $kategori = [
            ['id_kategori' => 1, 'nama_kategori' => 'Smartphone'],
            ['id_kategori' => 2, 'nama_kategori' => 'Laptop'],
            ['id_kategori' => 3, 'nama_kategori' => 'Aksesoris'],
            ['id_kategori' => 4, 'nama_kategori' => 'Audio'],
        ];

        $brand = [
            ['id_brand' => 1, 'nama_brand' => 'AstraTech'],
            ['id_brand' => 2, 'nama_brand' => 'NovaWare'],
            ['id_brand' => 3, 'nama_brand' => 'Voltix'],
            ['id_brand' => 4, 'nama_brand' => 'Lumi'],
        ];

        $produk = [
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

        $stok = [
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

        $customer = [
            ['id_customer' => 1, 'nama' => 'Rizky Aditya', 'no_hp' => '081234567890', 'alamat' => 'Bandung'],
            ['id_customer' => 2, 'nama' => 'Salsa Maulida', 'no_hp' => '081234567891', 'alamat' => 'Jakarta'],
            ['id_customer' => 3, 'nama' => 'Budi Wijaya', 'no_hp' => '081234567892', 'alamat' => 'Surabaya'],
            ['id_customer' => 4, 'nama' => 'Nina Maharani', 'no_hp' => '081234567893', 'alamat' => 'Semarang'],
            ['id_customer' => 5, 'nama' => 'Andi Kurnia', 'no_hp' => '081234567894', 'alamat' => 'Yogyakarta'],
        ];

        $user = [
            ['id_user' => 1, 'nama' => 'Admin Utama', 'username' => 'admin', 'role' => 'admin'],
            ['id_user' => 2, 'nama' => 'Kasir Satu', 'username' => 'kasir1', 'role' => 'kasir'],
        ];

        $penjualan = [
            ['id_penjualan' => 1, 'id_customer' => 1, 'id_user' => 2, 'tanggal' => '2026-05-01', 'total' => 5097000],
            ['id_penjualan' => 2, 'id_customer' => 2, 'id_user' => 2, 'tanggal' => '2026-05-02', 'total' => 14698000],
            ['id_penjualan' => 3, 'id_customer' => 3, 'id_user' => 1, 'tanggal' => '2026-05-02', 'total' => 799000],
            ['id_penjualan' => 4, 'id_customer' => 4, 'id_user' => 2, 'tanggal' => '2026-05-03', 'total' => 6628000],
        ];

        $detailPenjualan = [
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

        return compact('produk', 'kategori', 'brand', 'stok', 'customer', 'user', 'penjualan', 'detailPenjualan');
    }
}

if (! function_exists('ui_paginate')) {
    function ui_paginate(Collection $items, int $perPage = 8): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $slice = $items->forPage($page, $perPage)->values();

        return new LengthAwarePaginator(
            $slice,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/dashboard', function () {
    $data = sales_seed_data();

    $topProduk = collect($data['produk'])->sortByDesc('terjual')->take(5)->values();
    $totalPenjualan = collect($data['penjualan'])->sum('total');

    return view('dashboard.index', [
        'totalProduk' => count($data['produk']),
        'totalTransaksi' => count($data['penjualan']),
        'totalPenjualan' => $totalPenjualan,
        'topProduk' => $topProduk,
        'grafik' => [
            ['label' => 'Sen', 'value' => 4200000],
            ['label' => 'Sel', 'value' => 6800000],
            ['label' => 'Rab', 'value' => 5100000],
            ['label' => 'Kam', 'value' => 7900000],
            ['label' => 'Jum', 'value' => 9200000],
            ['label' => 'Sab', 'value' => 10100000],
            ['label' => 'Min', 'value' => 6300000],
        ],
    ]);
})->name('dashboard');

Route::get('/produk', function () {
    $data = sales_seed_data();

    $kategoriMap = collect($data['kategori'])->keyBy('id_kategori');
    $brandMap = collect($data['brand'])->keyBy('id_brand');
    $stokMap = collect($data['stok'])->keyBy('id_produk');

    $rows = collect($data['produk'])->map(function ($item) use ($kategoriMap, $brandMap, $stokMap) {
        return [
            ...$item,
            'nama_kategori' => $kategoriMap[$item['id_kategori']]['nama_kategori'] ?? '-',
            'nama_brand' => $brandMap[$item['id_brand']]['nama_brand'] ?? '-',
            'stok' => $stokMap[$item['id_produk']]['jumlah'] ?? 0,
        ];
    });

    $keyword = trim((string) request('q', ''));
    $kategori = (string) request('kategori', '');
    $brand = (string) request('brand', '');

    $filtered = $rows->filter(function ($item) use ($keyword, $kategori, $brand) {
        if ($keyword !== '' && ! str_contains(strtolower($item['nama_produk']), strtolower($keyword))) {
            return false;
        }

        if ($kategori !== '' && (string) $item['id_kategori'] !== $kategori) {
            return false;
        }

        if ($brand !== '' && (string) $item['id_brand'] !== $brand) {
            return false;
        }

        return true;
    })->values();

    return view('produk.index', [
        'produk' => ui_paginate($filtered),
        'kategoriList' => $data['kategori'],
        'brandList' => $data['brand'],
        'filters' => compact('keyword', 'kategori', 'brand'),
    ]);
})->name('produk.index');

Route::get('/produk/{id}', function (int $id) {
    $data = sales_seed_data();
    $produk = collect($data['produk'])->firstWhere('id_produk', $id);

    abort_if(! $produk, 404);

    $kategori = collect($data['kategori'])->firstWhere('id_kategori', $produk['id_kategori']);
    $brand = collect($data['brand'])->firstWhere('id_brand', $produk['id_brand']);
    $stok = collect($data['stok'])->firstWhere('id_produk', $produk['id_produk']);

    return view('produk.show', [
        'produk' => $produk,
        'kategori' => $kategori,
        'brand' => $brand,
        'stok' => $stok,
    ]);
})->name('produk.show');

Route::get('/transaksi', function () {
    $data = sales_seed_data();

    return view('transaksi.index', [
        'produk' => $data['produk'],
        'customer' => $data['customer'],
    ]);
})->name('transaksi.index');

Route::get('/penjualan', function () {
    $data = sales_seed_data();

    $produkMap = collect($data['produk'])->keyBy('id_produk');
    $customerMap = collect($data['customer'])->keyBy('id_customer');
    $userMap = collect($data['user'])->keyBy('id_user');
    $detailByPenjualan = collect($data['detailPenjualan'])->groupBy('id_penjualan');

    $rows = collect($data['penjualan'])->map(function ($penjualan) use ($customerMap, $userMap, $detailByPenjualan, $produkMap) {
        $details = collect($detailByPenjualan[$penjualan['id_penjualan']] ?? [])->map(function ($detail) use ($produkMap) {
            return [
                ...$detail,
                'nama_produk' => $produkMap[$detail['id_produk']]['nama_produk'] ?? '-',
            ];
        })->values();

        return [
            ...$penjualan,
            'nama_customer' => $customerMap[$penjualan['id_customer']]['nama'] ?? '-',
            'nama_user' => $userMap[$penjualan['id_user']]['nama'] ?? '-',
            'details' => $details,
        ];
    });

    return view('penjualan.index', [
        'penjualan' => ui_paginate($rows, 6),
    ]);
})->name('penjualan.index');

Route::get('/customer', function () {
    $data = sales_seed_data();

    return view('customer.index', [
        'customer' => ui_paginate(collect($data['customer']), 5),
    ]);
})->name('customer.index');

Route::get('/stok', function () {
    $data = sales_seed_data();

    $produkMap = collect($data['produk'])->keyBy('id_produk');

    $rows = collect($data['stok'])->map(function ($stok) use ($produkMap) {
        $produk = $produkMap[$stok['id_produk']] ?? null;

        return [
            ...$stok,
            'nama_produk' => $produk['nama_produk'] ?? '-',
            'harga' => $produk['harga'] ?? 0,
        ];
    });

    return view('stok.index', [
        'stok' => ui_paginate($rows),
    ]);
})->name('stok.index');
