<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Daftar Produk Admin Minimarket">
    <meta name="author" content="Minimarket">

    <title>Daftar Produk - Admin</title>

    <!-- Font Awesome -->
    <link href="{{ asset('asset/admin/vendor/fontawesome-free/css/all.min.css') }}"
          rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
          rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('asset/admin/css/sb-admin-2.min.css') }}"
          rel="stylesheet">

    <style>
        .pagination {
            margin-bottom: 0;
        }

        .table th {
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.partials.topbar', [
                    'pageTitle' => 'Produk'
                ])

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-0 text-gray-800">
                            Daftar Produk
                        </h1>

                        <a href="{{ route('admin.products.create') }}"
                           class="btn btn-primary shadow-sm">

                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Tambah Produk

                        </a>

                    </div>

                    <!-- Success Alert -->
                    @if (session('success'))

                        <div class="alert alert-success alert-dismissible fade show"
                             role="alert">

                            <i class="fas fa-check-circle mr-2"></i>

                            {{ session('success') }}

                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close">

                                <span aria-hidden="true">&times;</span>

                            </button>

                        </div>

                    @endif

                    <!-- Error Alert -->
                    @if ($errors->any())

                        <div class="alert alert-danger alert-dismissible fade show"
                             role="alert">

                            <i class="fas fa-exclamation-circle mr-2"></i>

                            <strong>Terjadi kesalahan:</strong>

                            <ul class="mb-0 mt-2">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close">

                                <span aria-hidden="true">&times;</span>

                            </button>

                        </div>

                    @endif

                    <!-- Product Card -->
                    <div class="card shadow mb-4">

                        <!-- Card Header -->
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">

                            <h6 class="m-0 font-weight-bold text-primary">

                                <i class="fas fa-box mr-2"></i>

                                Data Produk

                            </h6>

                            <span class="text-muted small">

                                Total:
                                {{ $products->total() }}
                                produk

                            </span>

                        </div>

                        <!-- Card Body -->
                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered"
                                       width="100%"
                                       cellspacing="0">

                                    <thead class="thead-light">

                                        <tr>

                                            <th width="5%">
                                                No
                                            </th>

                                            <th width="15%">
                                                SKU
                                            </th>

                                            <th width="20%">
                                                Nama Produk
                                            </th>

                                            <th width="15%">
                                                Kategori
                                            </th>

                                            <th width="15%">
                                                Harga
                                            </th>

                                            <th width="10%">
                                                Stok
                                            </th>

                                            <th>
                                                Deskripsi
                                            </th>

                                            <th width="18%">
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse ($products as $product)

                                            <tr>

                                                <!-- Nomor -->
                                                <td>
                                                    {{ $products->firstItem() + $loop->index }}
                                                </td>

                                                <!-- SKU -->
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        {{ $product->sku }}
                                                    </span>
                                                </td>

                                                <!-- Nama -->
                                                <td>
                                                    <strong>
                                                        {{ $product->name }}
                                                    </strong>
                                                </td>

                                                <!-- Kategori -->
                                                <td>
                                                    {{ $product->category->name ?? '-' }}
                                                </td>

                                                <!-- Harga -->
                                                <td>
                                                    Rp
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                </td>

                                                <!-- Stok -->
                                                <td>

                                                    @if ($product->stock <= 0)

                                                        <span class="badge badge-danger">
                                                            Habis
                                                        </span>

                                                    @elseif ($product->stock <= 5)

                                                        <span class="badge badge-warning">
                                                            {{ $product->stock }}
                                                        </span>

                                                    @else

                                                        <span class="badge badge-success">
                                                            {{ $product->stock }}
                                                        </span>

                                                    @endif

                                                </td>

                                                <!-- Deskripsi -->
                                                <td>

                                                    {{ $product->description ?? '-' }}

                                                </td>

                                                <!-- Aksi -->
                                                <td>

                                                    <!-- Detail -->
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                       class="btn btn-info btn-sm"
                                                       title="Lihat Detail">

                                                        <i class="fas fa-eye"></i>

                                                    </a>

                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                       class="btn btn-warning btn-sm"
                                                       title="Edit Produk">

                                                        <i class="fas fa-edit"></i>

                                                    </a>

                                                    <!-- Hapus -->
                                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')">

                                                        @csrf

                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                title="Hapus Produk">

                                                            <i class="fas fa-trash"></i>

                                                        </button>

                                                    </form>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="8"
                                                    class="text-center py-5">

                                                    <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>

                                                    <h5 class="text-gray-600">
                                                        Belum ada produk
                                                    </h5>

                                                    <p class="text-gray-500 mb-3">
                                                        Belum terdapat data produk.
                                                    </p>

                                                    <a href="{{ route('admin.products.create') }}"
                                                       class="btn btn-primary">

                                                        <i class="fas fa-plus mr-1"></i>

                                                        Tambah Produk

                                                    </a>

                                                </td>

                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                            <!-- Pagination -->
                            @if ($products->hasPages())

                                <div class="d-flex justify-content-between align-items-center mt-3">

                                    <div class="text-muted small">

                                        Menampilkan
                                        {{ $products->firstItem() }}
                                        -
                                        {{ $products->lastItem() }}
                                        dari
                                        {{ $products->total() }}
                                        produk

                                    </div>

                                    <div>
                                        {{ $products->links('pagination::bootstrap-4') }}
                                    </div>

                                </div>

                            @endif

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
    <a class="scroll-to-top rounded"
       href="#page-top">

        <i class="fas fa-angle-up"></i>

    </a>

    <!-- JavaScript -->
    <script src="{{ asset('asset/admin/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('asset/admin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
