<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Transaksi - Admin Minimarket</title>

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

                    {{-- Judul Halaman --}}
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-0 text-gray-800">
                            Daftar Transaksi
                        </h1>

                        <a href="{{ url('/admin/cashier') }}"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-cash-register mr-2"></i>
                            Kembali ke Kasir
                        </a>

                    </div>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}

                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Pesan Error --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}

                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Ringkasan --}}
                    <div class="row">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Transaksi
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $transactions->total() }}
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">

                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Halaman Saat Ini
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $transactions->currentPage() }}
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-list fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">

                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Data di Halaman Ini
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $transactions->count() }}
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-database fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- Tabel Transaksi --}}
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history mr-2"></i>
                                Riwayat Transaksi
                            </h6>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover"
                                       width="100%"
                                       cellspacing="0">

                                    <thead class="thead-light">
                                        <tr>
                                            <th width="60">No.</th>
                                            <th>No. Transaksi</th>
                                            <th>Tanggal</th>
                                            <th>ID Kasir</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Total Pembayaran</th>
                                            <th width="180">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse ($transactions as $transaction)

                                            <tr>
                                                <td>
                                                    {{ $transactions->firstItem() + $loop->index }}
                                                </td>

                                                <td>
                                                    <span class="font-weight-bold text-primary">
                                                        TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ $transaction->created_at
                                                        ? $transaction->created_at->format('d-m-Y H:i')
                                                        : '-' }}
                                                </td>

                                                <td>
                                                    {{ $transaction->user_id ?? '-' }}
                                                </td>

                                                <td>
                                                    @if ($transaction->payment_method)
                                                        <span class="badge badge-info">
                                                            {{ strtoupper($transaction->payment_method) }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td class="text-right">
                                                    <span class="font-weight-bold">
                                                        Rp{{ number_format(
                                                            $transaction->total
                                                                ?? $transaction->grand_total
                                                                ?? 0,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <a
                                                        href="{{ route('admin.transactions.invoice', $transaction->id) }}"
                                                        class="btn btn-primary btn-sm"
                                                        title="Unduh Invoice PDF"
                                                    >
                                                        <i class="fas fa-file-pdf mr-1"></i>
                                                        Unduh Invoice PDF
                                                    </a>
                                                </td>
                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="7"
                                                    class="text-center py-5">

                                                    <i class="fas fa-receipt fa-3x text-gray-300 mb-3"></i>

                                                    <h5 class="text-gray-600 mt-3">
                                                        Belum Ada Transaksi
                                                    </h5>

                                                    <p class="text-muted mb-3">
                                                        Transaksi yang berhasil disimpan akan muncul di halaman ini.
                                                    </p>

                                                    <a href="{{ url('/admin/cashier') }}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-cash-register mr-1"></i>
                                                        Buka Kasir
                                                    </a>

                                                </td>
                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                            {{-- Pagination --}}
                            @if ($transactions->hasPages())

                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">

                                    <div class="text-muted small mb-2">
                                        Menampilkan
                                        {{ $transactions->firstItem() ?? 0 }}
                                        sampai
                                        {{ $transactions->lastItem() ?? 0 }}
                                        dari
                                        {{ $transactions->total() }}
                                        transaksi
                                    </div>

                                    <div>
                                        {{ $transactions->links() }}
                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Admin Minimarket &copy; {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    {{-- Scroll to Top --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- JavaScript --}}
    <script src="{{ asset('asset/admin/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('asset/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('asset/admin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
