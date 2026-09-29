<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Produk - Admin Minimarket</title>

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

                    {{-- Header --}}
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-0 text-gray-800">
                            Detail Produk
                        </h1>

                        <a href="{{ route('admin.products.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                    </div>

                    {{-- Detail Produk --}}
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Informasi Produk
                            </h6>
                        </div>

                        <div class="card-body">

                            {{-- SKU --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    SKU
                                </div>

                                <div class="col-md-8">
                                    <span class="badge badge-secondary">
                                        {{ $product->sku }}
                                    </span>
                                </div>
                            </div>

                            <hr>

                            {{-- Kategori --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    Kategori
                                </div>

                                <div class="col-md-8">
                                    {{ $product->category->name ?? '-' }}
                                </div>
                            </div>

                            <hr>

                            {{-- Nama Produk --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    Nama Produk
                                </div>

                                <div class="col-md-8">
                                    {{ $product->name }}
                                </div>
                            </div>

                            <hr>

                            {{-- Harga --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    Harga
                                </div>

                                <div class="col-md-8 text-success font-weight-bold">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <hr>

                            {{-- Stok --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    Stok
                                </div>

                                <div class="col-md-8">

                                    @if ($product->stock > 10)

                                        <span class="badge badge-success">
                                            {{ $product->stock }} Stok
                                        </span>

                                    @elseif ($product->stock > 0)

                                        <span class="badge badge-warning">
                                            {{ $product->stock }} Stok
                                        </span>

                                    @else

                                        <span class="badge badge-danger">
                                            Habis
                                        </span>

                                    @endif

                                </div>
                            </div>

                            <hr>

                            {{-- Deskripsi --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    Deskripsi
                                </div>

                                <div class="col-md-8">
                                    {{ $product->description ?: '-' }}
                                </div>
                            </div>

                            <hr>

                            {{-- Dibuat --}}
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">
                                    Dibuat Pada
                                </div>

                                <div class="col-md-8">
                                    {{ $product->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>

                            <hr>

                            {{-- Diperbarui --}}
                            <div class="row">
                                <div class="col-md-4 font-weight-bold">
                                    Terakhir Diperbarui
                                </div>

                                <div class="col-md-8">
                                    {{ $product->updated_at->format('d-m-Y H:i') }}
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-4">

                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-warning">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Produk
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger">
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus Produk
                                    </button>

                                </form>

                                <a href="{{ route('admin.products.index') }}"
                                   class="btn btn-secondary">
                                    <i class="fas fa-list mr-2"></i>
                                    Daftar Produk
                                </a>

                            </div>

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
