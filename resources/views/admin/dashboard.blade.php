
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Dashboard Admin Minimarket">

    <meta name="author" content="Minimarket">

    <title>Dashboard Admin - Minimarket</title>

    <!-- Font Awesome -->
    <link href="{{ asset('asset/admin/vendor/fontawesome-free/css/all.min.css') }}"
          rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
          rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('asset/admin/css/sb-admin-2.min.css') }}"
          rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar dari Partial -->
        @include('admin.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar dari Partial -->
                @include('admin.partials.topbar', [
                    'pageTitle' => 'Dashboard Admin'
                ])

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-0 text-gray-800">
                            Dashboard
                        </h1>

                    </div>

                    <!-- Welcome Message -->
                    <div class="card shadow mb-4">

                        <div class="card-body">

                            <h4 class="text-primary font-weight-bold">

                                Selamat Datang,
                                {{ Auth::user()->name }}!

                            </h4>

                            <p class="mb-0 text-gray-600">

                                Selamat datang di halaman Dashboard Admin Minimarket.
                                Silakan kelola data melalui menu yang tersedia.

                            </p>

                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Card Produk -->
                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Produk
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Kelola Produk
                                            </div>

                                        </div>

                                        <div class="col-auto">

                                            <i class="fas fa-box fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Card Kategori -->
                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-success shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Kategori
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Kelola Kategori
                                            </div>

                                        </div>

                                        <div class="col-auto">

                                            <i class="fas fa-tags fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Card Supplier -->
                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-info shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Supplier
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Kelola Supplier
                                            </div>

                                        </div>

                                        <div class="col-auto">

                                            <i class="fas fa-truck fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Card Transaksi -->
                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-warning shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Transaksi
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Kelola Transaksi
                                            </div>

                                        </div>

                                        <div class="col-auto">

                                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Informasi Admin -->
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card shadow mb-4">

                                <div class="card-header py-3">

                                    <h6 class="m-0 font-weight-bold text-primary">
                                        Informasi Admin
                                    </h6>

                                </div>

                                <div class="card-body">

                                    <p>
                                        <strong>Nama:</strong>
                                        {{ Auth::user()->name }}
                                    </p>

                                    <p>
                                        <strong>Email:</strong>
                                        {{ Auth::user()->email }}
                                    </p>

                                    <p class="mb-0">
                                        <strong>Role:</strong>
                                        {{ Auth::user()->role }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">

                <div class="container my-auto">

                    <div class="copyright text-center my-auto">

                        <span>
                            Copyright &copy; Minimarket {{ date('Y') }}
                        </span>

                    </div>

                </div>

            </footer>

        </div>

    </div>

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">

        <i class="fas fa-angle-up"></i>

    </a>


    <!-- JavaScript -->
    <script src="{{ asset('asset/admin/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('asset/admin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
