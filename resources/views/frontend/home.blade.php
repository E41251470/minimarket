
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Minimarket - Belanja kebutuhan sehari-hari">
    <meta name="author" content="Minimarket">

    <title>Minimarket - Beranda</title>

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet"
    >

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        /* =========================
           GLOBAL
        ========================= */

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }

        a {
            text-decoration: none;
        }

        .text-primary-custom {
            color: #4e73df;
        }

        .bg-primary-custom {
            background-color: #4e73df;
        }

        .btn-primary-custom {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            color: white;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar-custom {
            background: linear-gradient(
                90deg,
                #4e73df,
                #224abe
            );
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 22px;
            color: white !important;
        }

        .navbar-brand i {
            transform: rotate(-10deg);
            display: inline-block;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600;
            margin-left: 12px;
        }

        .navbar-custom .nav-link:hover {
            color: white !important;
        }

        .btn-login {
            background-color: white;
            color: #4e73df;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 700;
        }

        .btn-login:hover {
            background-color: #eaecf4;
            color: #224abe;
        }

        /* =========================
           HERO
        ========================= */

        .hero-section {
            background: linear-gradient(
                135deg,
                #4e73df,
                #224abe
            );
            padding: 70px 0;
            color: white;
        }

        .hero-section h1 {
            font-size: 42px;
            font-weight: 800;
        }

        .hero-section p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-icon {
            font-size: 150px;
            color: rgba(255, 255, 255, 0.2);
        }

        .hero-button {
            background-color: white;
            color: #4e73df;
            border: none;
            border-radius: 30px;
            padding: 12px 25px;
            font-weight: 700;
        }

        .hero-button:hover {
            background-color: #eaecf4;
            color: #224abe;
        }

        /* =========================
           SEARCH
        ========================= */

        .search-wrapper {
            margin-top: -28px;
            position: relative;
            z-index: 2;
        }

        .search-box {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .search-box input {
            border-radius: 30px 0 0 30px;
            padding: 13px 20px;
        }

        .search-box button {
            border-radius: 0 30px 30px 0;
            padding: 13px 22px;
        }

        /* =========================
           SECTION
        ========================= */

        .section-title {
            font-weight: 800;
            color: #5a5c69;
        }

        .section-subtitle {
            color: #858796;
        }

        /* =========================
           CATEGORY
        ========================= */

        .category-card {
            background-color: white;
            border: none;
            border-radius: 12px;
            padding: 25px 15px;
            text-align: center;
            height: 100%;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #eaecf4;
            color: #4e73df;
            font-size: 28px;
            margin: 0 auto 15px;
        }

        .category-card h6 {
            font-weight: 700;
            margin-bottom: 0;
        }

        /* =========================
           PRODUCT
        ========================= */

        .product-card {
            background-color: white;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 180px;
            background-color: #f1f3f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4e73df;
            font-size: 75px;
        }

        .product-body {
            padding: 20px;
        }

        .product-category {
            font-size: 12px;
            color: #858796;
            font-weight: 700;
            text-transform: uppercase;
        }

        .product-name {
            font-size: 18px;
            font-weight: 800;
            color: #5a5c69;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 19px;
            font-weight: 800;
            color: #4e73df;
        }

        .product-stock {
            font-size: 13px;
            color: #858796;
        }

        .btn-cart {
            width: 100%;
            border-radius: 30px;
            font-weight: 700;
            margin-top: 15px;
        }

        /* =========================
           INFORMATION CARD
        ========================= */

        .info-card {
            background-color: white;
            border: none;
            border-left: 5px solid #4e73df;
            border-radius: 8px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        }

        .info-card i {
            font-size: 35px;
            color: #4e73df;
        }

        .info-card h5 {
            font-weight: 800;
            margin-top: 15px;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            background-color: white;
            margin-top: 60px;
            padding: 35px 0;
            border-top: 1px solid #e3e6f0;
        }

        .footer-title {
            font-size: 20px;
            font-weight: 800;
            color: #4e73df;
        }

        .footer p {
            margin-bottom: 0;
            color: #858796;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .hero-section {
                padding: 45px 0;
                text-align: center;
            }

            .hero-section h1 {
                font-size: 30px;
            }

            .hero-icon {
                font-size: 90px;
                margin-top: 25px;
            }

            .search-box input {
                border-radius: 30px;
                margin-bottom: 10px;
            }

            .search-box button {
                width: 100%;
                border-radius: 30px;
            }

        }

    </style>

</head>

<body>


    <!-- =========================
         NAVBAR
    ========================= -->

    <nav class="navbar navbar-expand-lg navbar-custom">

        <div class="container">

            <a
                class="navbar-brand"
                href="{{ route('frontend') }}"
            >

                <i class="bi bi-shop me-2"></i>

                Minimarket

            </a>


            <button
                class="navbar-toggler bg-light"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
                aria-controls="navbarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="navbarMenu"
            >

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('frontend') }}"
                        >

                            <i class="bi bi-house-door me-1"></i>

                            Beranda

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="#produk"
                        >

                            <i class="bi bi-box-seam me-1"></i>

                            Produk

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="#kategori"
                        >

                            <i class="bi bi-grid me-1"></i>

                            Kategori

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="#tentang"
                        >

                            <i class="bi bi-info-circle me-1"></i>

                            Tentang

                        </a>

                    </li>


                    @auth

                        <li class="nav-item dropdown">

                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >

                                <i class="bi bi-person-circle me-1"></i>

                                {{ Auth::user()->name }}

                            </a>


                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>

                                    <span class="dropdown-item-text">

                                        <strong>
                                            {{ Auth::user()->name }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ Auth::user()->email }}
                                        </small>

                                    </span>

                                </li>


                                <li>
                                    <hr class="dropdown-divider">
                                </li>


                                @if (Auth::user()->role === 'admin')

                                    <li>

                                        <a
                                            class="dropdown-item"
                                            href="{{ route('admin.dashboard') }}"
                                        >

                                            <i class="bi bi-speedometer2 me-2"></i>

                                            Dashboard Admin

                                        </a>

                                    </li>

                                @endif


                                <li>

                                    <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="dropdown-item text-danger"
                                        >

                                            <i class="bi bi-box-arrow-right me-2"></i>

                                            Logout

                                        </button>

                                    </form>

                                </li>

                            </ul>

                        </li>

                    @else

                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">

                            <a
                                class="btn btn-login"
                                href="{{ route('login') }}"
                            >

                                <i class="bi bi-box-arrow-in-right me-1"></i>

                                Login

                            </a>

                        </li>

                    @endauth

                </ul>

            </div>

        </div>

    </nav>


    <!-- =========================
         HERO
    ========================= -->

    <section class="hero-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-7">

                    <h1>
                        Belanja Mudah,
                        <br>
                        Kebutuhan Terpenuhi!
                    </h1>


                    <p class="mt-3 mb-4">

                        Temukan berbagai kebutuhan sehari-hari
                        dengan mudah melalui Minimarket kami.

                    </p>


                    <a
                        href="#produk"
                        class="btn hero-button"
                    >

                        <i class="bi bi-bag-check me-2"></i>

                        Mulai Belanja

                    </a>

                </div>


                <div class="col-lg-5 text-center">

                    <i class="bi bi-cart4 hero-icon"></i>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         SEARCH
    ========================= -->

    <section class="search-wrapper">

        <div class="container">

            <div class="search-box">

                <form
                    action="#produk"
                    method="GET"
                >

                    <div class="input-group">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari produk kebutuhanmu..."
                        >

                        <button
                            type="submit"
                            class="btn btn-primary-custom"
                        >

                            <i class="bi bi-search me-1"></i>

                            Cari

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>


    <!-- =========================
         CATEGORY
    ========================= -->

    <section
        id="kategori"
        class="py-5"
    >

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="section-title">
                    Kategori Produk
                </h2>

                <p class="section-subtitle">
                    Pilih kategori kebutuhan yang kamu cari
                </p>

            </div>


            <div class="row g-4">

                <!-- Category 1 -->
                <div class="col-6 col-md-3">

                    <div class="category-card">

                        <div class="category-icon">

                            <i class="bi bi-cup-hot"></i>

                        </div>

                        <h6>
                            Makanan
                        </h6>

                    </div>

                </div>


                <!-- Category 2 -->
                <div class="col-6 col-md-3">

                    <div class="category-card">

                        <div class="category-icon">

                            <i class="bi bi-cup-straw"></i>

                        </div>

                        <h6>
                            Minuman
                        </h6>

                    </div>

                </div>


                <!-- Category 3 -->
                <div class="col-6 col-md-3">

                    <div class="category-card">

                        <div class="category-icon">

                            <i class="bi bi-droplet"></i>

                        </div>

                        <h6>
                            Kebutuhan Rumah
                        </h6>

                    </div>

                </div>


                <!-- Category 4 -->
                <div class="col-6 col-md-3">

                    <div class="category-card">

                        <div class="category-icon">

                            <i class="bi bi-basket"></i>

                        </div>

                        <h6>
                            Kebutuhan Harian
                        </h6>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         PRODUCT
    ========================= -->

    <section
        id="produk"
        class="py-5 bg-light"
    >

        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="section-title mb-1">
                        Produk Pilihan
                    </h2>

                    <p class="section-subtitle mb-0">
                        Produk dummy untuk tampilan awal minimarket
                    </p>

                </div>

                <span class="badge bg-primary">
                    Produk Dummy
                </span>

            </div>


            <div class="row g-4">


                <!-- Product 1 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-cup-hot"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Makanan
                            </div>

                            <div class="product-name">
                                Indomie Goreng
                            </div>

                            <div class="product-price">
                                Rp3.500
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 50
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 2 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-cup-straw"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Minuman
                            </div>

                            <div class="product-name">
                                Teh Botol
                            </div>

                            <div class="product-price">
                                Rp5.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 35
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 3 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-basket"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Kebutuhan Harian
                            </div>

                            <div class="product-name">
                                Beras 5 Kg
                            </div>

                            <div class="product-price">
                                Rp75.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 20
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 4 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-droplet"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Kebutuhan Rumah
                            </div>

                            <div class="product-name">
                                Sabun Cuci
                            </div>

                            <div class="product-price">
                                Rp12.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 25
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 5 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-cup-hot"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Makanan
                            </div>

                            <div class="product-name">
                                Roti Cokelat
                            </div>

                            <div class="product-price">
                                Rp8.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 40
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 6 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-cup-straw"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Minuman
                            </div>

                            <div class="product-name">
                                Air Mineral
                            </div>

                            <div class="product-price">
                                Rp3.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 60
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 7 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-basket"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Kebutuhan Harian
                            </div>

                            <div class="product-name">
                                Minyak Goreng
                            </div>

                            <div class="product-price">
                                Rp18.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 30
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>


                <!-- Product 8 -->
                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="product-card">

                        <div class="product-image">

                            <i class="bi bi-droplet"></i>

                        </div>


                        <div class="product-body">

                            <div class="product-category">
                                Kebutuhan Rumah
                            </div>

                            <div class="product-name">
                                Tisu Wajah
                            </div>

                            <div class="product-price">
                                Rp10.000
                            </div>

                            <div class="product-stock">
                                <i class="bi bi-box-seam me-1"></i>
                                Stok: 45
                            </div>


                            <button
                                type="button"
                                class="btn btn-primary-custom btn-cart"
                                onclick="showDummyMessage()"
                            >

                                <i class="bi bi-cart-plus me-1"></i>

                                Tambah ke Keranjang

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         INFORMATION
    ========================= -->

    <section
        id="tentang"
        class="py-5"
    >

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="section-title">
                    Mengapa Belanja di Minimarket Kami?
                </h2>

                <p class="section-subtitle">
                    Kemudahan untuk memenuhi kebutuhan sehari-hari
                </p>

            </div>


            <div class="row g-4">


                <!-- Information 1 -->
                <div class="col-md-4">

                    <div class="info-card">

                        <i class="bi bi-bag-check"></i>

                        <h5>
                            Produk Beragam
                        </h5>

                        <p class="mb-0">

                            Menyediakan berbagai jenis kebutuhan
                            sehari-hari dalam satu tempat.

                        </p>

                    </div>

                </div>


                <!-- Information 2 -->
                <div class="col-md-4">

                    <div class="info-card">

                        <i class="bi bi-clock"></i>

                        <h5>
                            Praktis dan Mudah
                        </h5>

                        <p class="mb-0">

                            Membantu pengguna menemukan produk
                            dengan tampilan yang mudah digunakan.

                        </p>

                    </div>

                </div>


                <!-- Information 3 -->
                <div class="col-md-4">

                    <div class="info-card">

                        <i class="bi bi-shield-check"></i>

                        <h5>
                            Informasi Produk
                        </h5>

                        <p class="mb-0">

                            Menampilkan informasi nama, harga,
                            kategori, dan stok produk.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         FOOTER
    ========================= -->

    <footer class="footer">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-md-6 text-center text-md-start">

                    <div class="footer-title">

                        <i class="bi bi-shop me-2"></i>

                        Minimarket

                    </div>

                    <p class="mt-2">

                        Tempat memenuhi kebutuhan sehari-hari.

                    </p>

                </div>


                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">

                    <p>

                        Copyright &copy; Minimarket {{ date('Y') }}

                    </p>

                    <p class="small">

                        Tampilan produk masih menggunakan data dummy.

                    </p>

                </div>

            </div>

        </div>

    </footer>


    <!-- Bootstrap JavaScript -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    <!-- Dummy Product Notification -->
    <script>

        function showDummyMessage() {

            alert(
                'Fitur keranjang masih dalam tahap pengembangan. ' +
                'Produk yang ditampilkan masih berupa data dummy.'
            );

        }

    </script>

</body>

</html>
