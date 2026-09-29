<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Tambah Produk - Admin Minimarket">
    <meta name="author" content="Minimarket">

    <title>Tambah Produk - Admin</title>

    <!-- Font Awesome -->
    <link href="{{ asset('asset/admin/vendor/fontawesome-free/css/all.min.css') }}"
          rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
          rel="stylesheet">

    <!-- SB Admin 2 -->
    <link href="{{ asset('asset/admin/css/sb-admin-2.min.css') }}"
          rel="stylesheet">

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
                    'pageTitle' => 'Tambah Produk'
                ])

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-0 text-gray-800">
                            Tambah Produk
                        </h1>

                        <a href="{{ route('admin.products.index') }}"
                           class="btn btn-secondary shadow-sm">

                            <i class="fas fa-arrow-left fa-sm text-white-50"></i>
                            Kembali ke Produk

                        </a>

                    </div>

                    <!-- Validation Error -->
                    @if ($errors->any())

                        <div class="alert alert-danger alert-dismissible fade show"
                             role="alert">

                            <div class="font-weight-bold mb-2">

                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Data belum dapat disimpan.

                            </div>

                            <ul class="mb-0 pl-3">

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

                    <!-- Product Form -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary">

                                <i class="fas fa-box mr-2"></i>
                                Form Tambah Produk

                            </h6>

                        </div>

                        <div class="card-body">

                            <form action="{{ route('admin.products.store') }}"
                                  method="POST">

                                @csrf
                            <div class="form-group">
                                <label for="sku">SKU</label>
                                <input
                                    type="text"
                                    name="sku"
                                    id="sku"
                                    class="form-control @error('sku') is-invalid @enderror"
                                    value="{{ old('sku') }}"
                                    placeholder="Contoh: STR001"
                                    required
                                >

                                @error('sku')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                                <!-- Nama Produk -->
                                <div class="form-group">

                                    <label for="name" class="font-weight-bold">
                                        Nama Produk
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           maxlength="255"
                                           placeholder="Masukkan nama produk"
                                           required
                                           autofocus>

                                    @error('name')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>
                                <!-- Kategori -->
                                <div class="form-group">

                                    <label for="category_id" class="font-weight-bold">
                                        Kategori
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="category_id"
                                            id="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror"
                                            required>

                                        <option value="">-- Pilih Kategori --</option>

                                        @foreach ($categories as $category)

                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                                {{ $category->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                    @error('category_id')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>
                                <!-- Harga -->
                                <div class="form-group">

                                    <label for="price" class="font-weight-bold">
                                        Harga
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Rp
                                            </span>
                                        </div>

                                        <input type="number"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price') }}"
                                               min="0"
                                               step="0.01"
                                               placeholder="Contoh: 15000"
                                               required>

                                    </div>

                                    @error('price')

                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    <small class="form-text text-muted">
                                        Masukkan harga produk dalam Rupiah.
                                    </small>

                                </div>

                                <!-- Stok -->
                                <div class="form-group">

                                    <label for="stock" class="font-weight-bold">
                                        Stok
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                           name="stock"
                                           id="stock"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           value="{{ old('stock') }}"
                                           min="0"
                                           step="1"
                                           placeholder="Contoh: 20"
                                           required>

                                    @error('stock')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    <small class="form-text text-muted">
                                        Stok harus berupa angka bulat dan tidak boleh negatif.
                                    </small>

                                </div>

                                <!-- Deskripsi -->
                                <div class="form-group">

                                    <label for="description" class="font-weight-bold">
                                        Deskripsi
                                    </label>

                                    <textarea name="description"
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="5"
                                              maxlength="1000"
                                              placeholder="Masukkan deskripsi produk (opsional)">{{ old('description') }}</textarea>

                                    @error('description')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    <small class="form-text text-muted">
                                        Deskripsi bersifat opsional, maksimal 1000 karakter.
                                    </small>

                                </div>

                                <hr>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between">

                                    <a href="{{ route('admin.products.index') }}"
                                       class="btn btn-secondary">

                                        <i class="fas fa-times mr-1"></i>
                                        Batal

                                    </a>

                                    <button type="submit"
                                            class="btn btn-primary">

                                        <i class="fas fa-save mr-1"></i>
                                        Simpan Produk

                                    </button>

                                </div>

                            </form>

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
