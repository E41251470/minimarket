<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Produk - Admin Minimarket</title>

    <link
        href="{{ asset('asset/admin/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet">

    <link
        href="{{ asset('asset/admin/css/sb-admin-2.min.css') }}"
        rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        @include('admin.partials.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('admin.partials.topbar')

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-0 text-gray-800">
                            Edit Produk
                        </h1>

                        <a href="{{ route('admin.products.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Periksa kembali data:</strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Form Edit Produk
                            </h6>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('admin.products.update', $product->id) }}"
                                  method="POST">

                                @csrf
                                @method('PUT')

                                {{-- SKU --}}
                                <div class="form-group">
                                    <label for="sku">
                                        SKU
                                    </label>

                                    <input type="text"
                                           name="sku"
                                           id="sku"
                                           class="form-control @error('sku') is-invalid @enderror"
                                           value="{{ old('sku', $product->sku) }}"
                                           placeholder="Contoh: STR001"
                                           required>

                                    @error('sku')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Kategori --}}
                                <div class="form-group">
                                    <label for="category_id">
                                        Kategori
                                    </label>

                                    <select name="category_id"
                                            id="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror"
                                            required>

                                        <option value="">
                                            -- Pilih Kategori --
                                        </option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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

                                {{-- Nama Produk --}}
                                <div class="form-group">
                                    <label for="name">
                                        Nama Produk
                                    </label>

                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $product->name) }}"
                                           required>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Harga --}}
                                <div class="form-group">
                                    <label for="price">
                                        Harga Produk
                                    </label>

                                    <input type="number"
                                           name="price"
                                           id="price"
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $product->price) }}"
                                           min="0"
                                           required>

                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="form-group">
                                    <label for="stock">
                                        Stok Produk
                                    </label>

                                    <input type="number"
                                           name="stock"
                                           id="stock"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           value="{{ old('stock', $product->stock) }}"
                                           min="0"
                                           required>

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div class="form-group">
                                    <label for="description">
                                        Deskripsi Produk
                                    </label>

                                    <textarea name="description"
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="4">{{ old('description', $product->description) }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Tombol --}}
                                <button type="submit"
                                        class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>

                                <a href="{{ route('admin.products.index') }}"
                                   class="btn btn-secondary">
                                    Batal
                                </a>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('asset/admin/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('asset/admin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
