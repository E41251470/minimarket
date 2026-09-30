<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <title>Kasir - Minimarket</title>

    <!-- Font Awesome -->
    <link
        href="{{ asset('asset/admin/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet">

    <!-- SB Admin 2 -->
    <link
        href="{{ asset('asset/admin/css/sb-admin-2.min.css') }}"
        rel="stylesheet">

    <style>

        .product-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
            z-index: 9999;
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }

        .search-wrapper {
            position: relative;
        }

        .product-result-item {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .product-result-item:hover {
            background: #f8f9fc;
        }

        .product-result-name {
            font-weight: 600;
            color: #333;
        }

        .product-result-price {
            font-size: 13px;
            color: #4e73df;
        }

        .cart-qty {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .cart-qty button {
            width: 30px;
            height: 30px;
            padding: 0;
        }

        .cart-qty input {
            width: 50px;
            text-align: center;
        }

        .empty-cart {
            text-align: center;
            padding: 40px !important;
            color: #858796;
        }

        .total-box {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
        }

        .grand-total {
            font-size: 24px;
            font-weight: bold;
            color: #1cc88a;
        }

        .payment-input {
            font-size: 22px;
            font-weight: bold;
            text-align: right;
        }

        .change-box {
            border-radius: 8px;
            padding: 15px;
            background: #f8f9fc;
            margin-top: 15px;
        }

        .change-box.short-payment {
            background: #f8d7da;
        }

        .change-label {
            font-size: 12px;
            font-weight: bold;
            color: #858796;
        }

        .change-value {
            font-size: 24px;
            font-weight: bold;
            color: #1cc88a;
        }

        .short-payment .change-value {
            color: #e74a3b;
        }

        .payment-method {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .payment-method button {
            border: 1px solid #d1d3e2;
            background: white;
            color: #5a5c69;
            border-radius: 5px;
            padding: 8px;
            cursor: pointer;
        }

        .payment-method button:hover {
            background: #f8f9fc;
        }

        .payment-method button.active {
            background: #4e73df;
            color: white;
            border-color: #4e73df;
        }

        .held-card {
            border-left: 4px solid #f6c23e;
        }

        .held-transaction-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .held-transaction-item:last-child {
            border-bottom: none;
        }

        .action-area {
            margin-top: 20px;
        }

        .action-area button {
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {

            .payment-method {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                font-size: 13px;
            }

        }

    </style>

</head>


<body id="page-top">


<div id="wrapper">


    <!-- SIDEBAR -->
    @include('admin.partials.sidebar')


    <!-- CONTENT WRAPPER -->
    <div id="content-wrapper"
        class="d-flex flex-column">


        <div id="content">


            <!-- TOPBAR -->
            @include('admin.partials.topbar', [
                'pageTitle' => 'Kasir'
            ])


            <!-- MAIN CONTENT -->
            <div class="container-fluid">


                <!-- PAGE TITLE -->
                <div class="d-sm-flex
                            align-items-center
                            justify-content-between
                            mb-4">

                    <h1 class="h3 mb-0 text-gray-800">

                        <i class="fas fa-cash-register"></i>

                        Kasir

                    </h1>

                </div>


                <!-- ===================================== -->
                <!-- TRANSAKSI DITAHAN -->
                <!-- ===================================== -->

                <div class="card shadow mb-4 held-card">

                    <div class="card-header py-3">

                        <h6 class="m-0 font-weight-bold text-warning">

                            <i class="fas fa-pause-circle"></i>

                            Transaksi Ditahan

                        </h6>

                    </div>


                    <div class="card-body">

                        <div id="heldTransactions">

                            @forelse($heldTransactions as $held)

                                <div
                                    class="held-transaction-item"
                                    id="held-{{ $held->id }}"
                                >

                                    <div class="row align-items-center">

                                        <div class="col-md-3">

                                            <strong>
                                                {{ $held->transaction_number }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">

                                                {{ $held->created_at->format('d/m/Y H:i') }}

                                            </small>

                                        </div>


                                        <div class="col-md-2">

                                            <span>

                                                {{ $held->details->sum('qty') }}

                                                Item

                                            </span>

                                        </div>


                                        <div class="col-md-3">

                                            <strong>

                                                Rp
                                                {{ number_format($held->grand_total, 0, ',', '.') }}

                                            </strong>

                                        </div>


                                        <div class="col-md-4 text-right">

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary"
                                                onclick="resumeTransaction({{ $held->id }})"
                                            >

                                                <i class="fas fa-play"></i>

                                                Lanjutkan

                                            </button>


                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                                onclick="deleteHeldTransaction({{ $held->id }})"
                                            >

                                                <i class="fas fa-trash"></i>

                                                Hapus

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div
                                    class="text-center text-muted"
                                    id="noHeldTransaction"
                                >

                                    <i class="fas fa-inbox fa-2x mb-2"></i>

                                    <br>

                                    Tidak ada transaksi yang ditahan.

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>


                <!-- ===================================== -->
                <!-- MAIN ROW -->
                <!-- ===================================== -->

                <div class="row">


                    <!-- ================================= -->
                    <!-- LEFT -->
                    <!-- ================================= -->

                    <div class="col-lg-8">


                        <!-- TAMBAH BARANG -->

                        <div class="card shadow mb-4">


                            <div class="card-header py-3">

                                <h6 class="m-0 font-weight-bold text-primary">

                                    <i class="fas fa-cart-plus"></i>

                                    Tambah Barang

                                </h6>

                            </div>


                            <div class="card-body">


                                <!-- SEARCH -->

                                <div class="form-group">

                                    <label
                                        class="font-weight-bold"
                                    >

                                        Cari Barang

                                    </label>


                                    <div class="search-wrapper">

                                        <div class="input-group">

                                            <input
                                                type="text"
                                                id="searchProduct"
                                                class="form-control"
                                                placeholder="Cari nama barang..."
                                                autocomplete="off"
                                            >


                                            <div class="input-group-append">

                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                    onclick="searchProduct()"
                                                >

                                                    <i class="fas fa-search"></i>

                                                    Cari

                                                </button>

                                            </div>

                                        </div>


                                        <div
                                            id="productResults"
                                            class="product-results"
                                        ></div>

                                    </div>

                                </div>


                            </div>

                        </div>


                        <!-- ================================= -->
                        <!-- CART -->
                        <!-- ================================= -->

                        <div class="card shadow mb-4">


                            <div class="card-header py-3">

                                <div class="d-flex
                                            justify-content-between
                                            align-items-center">

                                    <h6 class="m-0 font-weight-bold text-primary">

                                        <i class="fas fa-shopping-cart"></i>

                                        Keranjang Belanja

                                    </h6>


                                    <span
                                        id="itemCount"
                                        class="badge badge-primary"
                                    >

                                        0 Item

                                    </span>

                                </div>

                            </div>


                            <div class="card-body p-0">


                                <div class="table-responsive">


                                    <table class="table
                                                  table-bordered
                                                  table-hover
                                                  mb-0">

                                        <thead class="thead-light">

                                            <tr>

                                                <th width="50">
                                                    No
                                                </th>

                                                <th>
                                                    Barang
                                                </th>

                                                <th width="120">
                                                    Harga
                                                </th>

                                                <th width="150"
                                                    class="text-center">

                                                    Qty

                                                </th>

                                                <th width="140"
                                                    class="text-right">

                                                    Subtotal

                                                </th>

                                                <th width="60"
                                                    class="text-center">

                                                    Aksi

                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody id="cartBody">

                                            <tr id="emptyRow">

                                                <td
                                                    colspan="6"
                                                    class="empty-cart"
                                                >

                                                    <i class="fas fa-shopping-cart fa-2x mb-3"></i>

                                                    <br>

                                                    Keranjang masih kosong.

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>


                    </div>


                    <!-- ================================= -->
                    <!-- RIGHT -->
                    <!-- ================================= -->

                    <div class="col-lg-4">


                        <!-- ================================= -->
                        <!-- RINGKASAN -->
                        <!-- ================================= -->

                        <div class="card shadow mb-4">


                            <div class="card-header py-3">

                                <h6 class="m-0 font-weight-bold text-primary">

                                    <i class="fas fa-file-invoice-dollar"></i>

                                    Ringkasan Pembayaran

                                </h6>

                            </div>


                            <div class="card-body">


                                <!-- SUBTOTAL -->

                                <div class="d-flex
                                            justify-content-between
                                            mb-2">

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong id="subtotal">
                                        Rp 0
                                    </strong>

                                </div>


                                <!-- DISCOUNT PERCENT -->

                                <div class="form-group">

                                    <label>
                                        Diskon (%)
                                    </label>

                                    <input
                                        type="number"
                                        id="discountPercent"
                                        class="form-control"
                                        value="0"
                                        min="0"
                                        max="100"
                                        oninput="calculateTotal()"
                                    >

                                </div>


                                <!-- DISCOUNT NOMINAL -->

                                <div class="form-group">

                                    <label>
                                        Diskon (Rp)
                                    </label>

                                    <input
                                        type="number"
                                        id="discountAmount"
                                        class="form-control"
                                        value="0"
                                        min="0"
                                        oninput="calculateTotal()"
                                    >

                                </div>


                                <!-- TAX -->

                                <div class="form-group">

                                    <label>
                                        Pajak (Rp)
                                    </label>

                                    <input
                                        type="number"
                                        id="tax"
                                        class="form-control"
                                        value="0"
                                        min="0"
                                        oninput="calculateTotal()"
                                    >

                                </div>


                                <!-- OTHER FEE -->

                                <div class="form-group">

                                    <label>
                                        Biaya Lain (Rp)
                                    </label>

                                    <input
                                        type="number"
                                        id="otherFee"
                                        class="form-control"
                                        value="0"
                                        min="0"
                                        oninput="calculateTotal()"
                                    >

                                </div>


                                <hr>


                                <!-- GRAND TOTAL -->

                                <div class="total-box">

                                    <div class="small
                                                font-weight-bold
                                                text-uppercase
                                                text-muted">

                                        Total Akhir

                                    </div>


                                    <div
                                        id="grandTotal"
                                        class="grand-total"
                                    >

                                        Rp 0

                                    </div>

                                </div>


                            </div>

                        </div>


                        <!-- ================================= -->
                        <!-- PEMBAYARAN -->
                        <!-- ================================= -->

                        <div class="card shadow mb-4">


                            <div class="card-header py-3">

                                <h6 class="m-0 font-weight-bold text-primary">

                                    <i class="fas fa-money-bill-wave"></i>

                                    Pembayaran

                                </h6>

                            </div>


                            <div class="card-body">


                                <!-- PAYMENT -->

                                <div class="form-group">

                                    <label
                                        class="font-weight-bold"
                                    >

                                        Uang Dibayar

                                    </label>


                                    <input
                                        type="number"
                                        id="payment"
                                        class="form-control payment-input"
                                        placeholder="0"
                                        min="0"
                                        oninput="calculateChange()"
                                    >

                                </div>


                                <!-- PAYMENT METHOD -->

                                <div class="form-group">

                                    <label
                                        class="font-weight-bold"
                                    >

                                        Metode Pembayaran

                                    </label>


                                    <div class="payment-method">


                                        <button
                                            type="button"
                                            class="active"
                                            onclick="selectPayment(this)"
                                            data-method="Tunai"
                                        >

                                            <i class="fas fa-money-bill-wave"></i>

                                            Tunai

                                        </button>


                                        <button
                                            type="button"
                                            onclick="selectPayment(this)"
                                            data-method="QRIS"
                                        >

                                            <i class="fas fa-qrcode"></i>

                                            QRIS

                                        </button>


                                        <button
                                            type="button"
                                            onclick="selectPayment(this)"
                                            data-method="Debit"
                                        >

                                            <i class="fas fa-credit-card"></i>

                                            Debit

                                        </button>


                                        <button
                                            type="button"
                                            onclick="selectPayment(this)"
                                            data-method="Kredit"
                                        >

                                            <i class="fas fa-credit-card"></i>

                                            Kredit

                                        </button>


                                        <button
                                            type="button"
                                            onclick="selectPayment(this)"
                                            data-method="E-Wallet"
                                        >

                                            <i class="fas fa-wallet"></i>

                                            E-Wallet

                                        </button>


                                        <button
                                            type="button"
                                            onclick="selectPayment(this)"
                                            data-method="Transfer"
                                        >

                                            <i class="fas fa-university"></i>

                                            Transfer

                                        </button>


                                    </div>

                                </div>


                                <!-- CHANGE -->

                                <div
                                    class="change-box"
                                    id="changeBox"
                                >

                                    <div class="change-label">

                                        KEMBALIAN

                                    </div>


                                    <div
                                        class="change-value"
                                        id="change"
                                    >

                                        Rp 0

                                    </div>

                                </div>


                                <!-- PRINT FORMAT -->

                                <div class="form-group mt-3">

                                    <label
                                        class="font-weight-bold"
                                    >

                                        Format Cetak

                                    </label>


                                    <select
                                        id="printFormat"
                                        class="form-control"
                                    >

                                        <option value="thermal58">

                                            Thermal 58 mm

                                        </option>


                                        <option value="thermal80">

                                            Thermal 80 mm

                                        </option>


                                        <option value="a4">

                                            Printer Biasa / PDF

                                        </option>

                                    </select>

                                </div>


                                <!-- ACTION -->

                                <div class="action-area">


                                    <button
                                        type="button"
                                        class="btn btn-warning btn-block"
                                        onclick="holdTransaction()"
                                    >

                                        <i class="fas fa-pause"></i>

                                        Tahan

                                    </button>


                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block"
                                        onclick="cancelTransaction()"
                                    >

                                        <i class="fas fa-times"></i>

                                        Batal

                                    </button>


                                    <button
                                        type="button"
                                        id="payButton"
                                        class="btn btn-success btn-block"
                                        onclick="payTransaction()"
                                    >

                                        <i class="fas fa-print"></i>

                                        Bayar & Cetak

                                    </button>


                                </div>


                            </div>

                        </div>


                    </div>


                </div>


            </div>

        </div>


        <!-- FOOTER -->

        <footer class="sticky-footer bg-white">

            <div class="container my-auto">

                <div class="copyright text-center my-auto">

                    <span>
                        Copyright &copy; Minimarket
                        {{ date('Y') }}
                    </span>

                </div>

            </div>

        </footer>


    </div>

</div>


<!-- Scroll to Top -->

<a
    class="scroll-to-top rounded"
    href="#page-top"
>

    <i class="fas fa-angle-up"></i>

</a>


<!-- ========================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================= -->

<script>

    /* =====================================================
       DATA AWAL
    ===================================================== */

    let cart = [];

    let currentTransactionId = null;

    let selectedPaymentMethod = 'Tunai';


    const products = @json($products);


    /* =====================================================
       FORMAT RUPIAH
    ===================================================== */

    function formatRupiah(number) {

        number = Number(number) || 0;

        return new Intl.NumberFormat('id-ID', {

            style: 'currency',

            currency: 'IDR',

            minimumFractionDigits: 0

        }).format(number);

    }


    /* =====================================================
       ESCAPE HTML
    ===================================================== */

    function escapeHtml(value) {

        return String(value ?? '')

            .replace(/&/g, '&amp;')

            .replace(/</g, '&lt;')

            .replace(/>/g, '&gt;')

            .replace(/"/g, '&quot;')

            .replace(/'/g, '&#039;');

    }


    /* =====================================================
       SEARCH PRODUCT
    ===================================================== */

    const searchInput =
        document.getElementById('searchProduct');


    searchInput.addEventListener(
        'input',
        searchProduct
    );


    searchInput.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                const firstResult =
                    document.querySelector(
                        '.product-result-item'
                    );

                if (firstResult) {

                    firstResult.click();

                }

            }

        }
    );


    function searchProduct() {

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();


        const resultBox =
            document.getElementById(
                'productResults'
            );


        if (!keyword) {

            resultBox.innerHTML = '';

            resultBox.style.display = 'none';

            return;

        }


        const results =
            products.filter(product => {

                const name =
                    String(product.name || '')
                        .toLowerCase();

                const sku =
                    String(product.sku || '')
                        .toLowerCase();

                const code =
                    String(product.code || '')
                        .toLowerCase();

                return (
                    name.includes(keyword) ||
                    sku.includes(keyword) ||
                    code.includes(keyword)
                );

            });


        if (results.length === 0) {

            resultBox.innerHTML = `

                <div class="p-3 text-muted">

                    <i class="fas fa-search"></i>

                    Produk tidak ditemukan.

                </div>

            `;

            resultBox.style.display = 'block';

            return;

        }


        resultBox.innerHTML =
            results.map(product => `

                <div
                    class="product-result-item"
                    onclick="addToCart(${product.id})"
                >

                    <div class="product-result-name">

                        ${escapeHtml(product.name)}

                    </div>

                    <div class="product-result-price">

                        SKU:
                        ${escapeHtml(product.sku || '-')}

                        &nbsp; | &nbsp;

                        Stok:
                        ${product.stock}

                        &nbsp; | &nbsp;

                        ${formatRupiah(product.price)}

                    </div>

                </div>

            `).join('');


        resultBox.style.display = 'block';

    }


    /* =====================================================
       ADD TO CART
    ===================================================== */

    function addToCart(productId) {

        const product =
            products.find(
                p => Number(p.id) === Number(productId)
            );


        if (!product) {

            alert('Produk tidak ditemukan.');

            return;

        }


        const existing =
            cart.find(
                item =>
                    Number(item.id) === Number(product.id)
            );


        if (existing) {

            if (existing.qty >= Number(product.stock)) {

                alert(
                    'Jumlah barang melebihi stok yang tersedia.'
                );

                return;

            }

            existing.qty++;

        } else {

            cart.push({

                id: product.id,

                sku: product.sku || '',

                name: product.name,

                price: Number(product.price),

                stock: Number(product.stock),

                qty: 1

            });

        }


        searchInput.value = '';

        document.getElementById(
            'productResults'
        ).style.display = 'none';


        renderCart();

        searchInput.focus();

    }


    /* =====================================================
       RENDER CART
    ===================================================== */

    function renderCart() {

        const cartBody =
            document.getElementById('cartBody');


        const emptyRow =
            document.getElementById('emptyRow');


        if (cart.length === 0) {

            cartBody.innerHTML = `

                <tr id="emptyRow">

                    <td
                        colspan="6"
                        class="empty-cart"
                    >

                        <i class="fas fa-shopping-cart fa-2x mb-3"></i>

                        <br>

                        Keranjang masih kosong.

                    </td>

                </tr>

            `;

            document.getElementById(
                'itemCount'
            ).innerText = '0 Item';

            calculateTotal();

            return;

        }


        cartBody.innerHTML = '';


        let totalItem = 0;


        cart.forEach((item, index) => {

            totalItem += Number(item.qty);


            const subtotal =
                Number(item.price) *
                Number(item.qty);


            const row = document.createElement('tr');


            row.innerHTML = `

                <td>
                    ${index + 1}
                </td>


                <td>

                    <strong>
                        ${escapeHtml(item.name)}
                    </strong>

                    <br>

                    <small class="text-muted">

                        SKU:
                        ${escapeHtml(item.sku || '-')}

                    </small>

                </td>


                <td>

                    ${formatRupiah(item.price)}

                </td>


                <td>

                    <div class="cart-qty">

                        <button
                            type="button"
                            class="btn btn-sm btn-secondary"
                            onclick="changeQty(${index}, -1)"
                        >

                            <i class="fas fa-minus"></i>

                        </button>


                        <input
                            type="number"
                            class="form-control form-control-sm"
                            value="${item.qty}"
                            min="1"
                            max="${item.stock}"
                            onchange="updateQty(${index}, this.value)"
                        >


                        <button
                            type="button"
                            class="btn btn-sm btn-secondary"
                            onclick="changeQty(${index}, 1)"
                        >

                            <i class="fas fa-plus"></i>

                        </button>

                    </div>

                </td>


                <td class="text-right">

                    <strong>

                        ${formatRupiah(subtotal)}

                    </strong>

                </td>


                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        onclick="removeItem(${index})"
                    >

                        <i class="fas fa-trash"></i>

                    </button>

                </td>

            `;


            cartBody.appendChild(row);

        });


        document.getElementById(
            'itemCount'
        ).innerText =
            `${totalItem} Item`;


        calculateTotal();

    }


    /* =====================================================
       CHANGE QTY
    ===================================================== */

    function changeQty(index, amount) {

        if (!cart[index]) {

            return;

        }


        const newQty =
            Number(cart[index].qty) +
            Number(amount);


        if (newQty < 1) {

            return;

        }


        if (newQty > Number(cart[index].stock)) {

            alert(
                `Stok ${cart[index].name} hanya tersedia ${cart[index].stock}.`
            );

            return;

        }


        cart[index].qty = newQty;


        renderCart();

    }


    /* =====================================================
       UPDATE QTY
    ===================================================== */

    function updateQty(index, value) {

        if (!cart[index]) {

            return;

        }


        let qty = parseInt(value) || 1;


        if (qty < 1) {

            qty = 1;

        }


        if (qty > Number(cart[index].stock)) {

            qty = Number(cart[index].stock);

            alert(
                `Stok ${cart[index].name} hanya tersedia ${cart[index].stock}.`
            );

        }


        cart[index].qty = qty;


        renderCart();

    }


    /* =====================================================
       REMOVE ITEM
    ===================================================== */

    function removeItem(index) {

        if (!cart[index]) {

            return;

        }


        cart.splice(index, 1);


        renderCart();

    }


    /* =====================================================
       CALCULATE TOTAL
    ===================================================== */

    function calculateTotal() {

        let subtotal = 0;


        cart.forEach(item => {

            subtotal +=
                Number(item.price) *
                Number(item.qty);

        });


        const discountPercent =
            parseFloat(
                document.getElementById(
                    'discountPercent'
                ).value
            ) || 0;


        const discountAmount =
            parseFloat(
                document.getElementById(
                    'discountAmount'
                ).value
            ) || 0;


        const tax =
            parseFloat(
                document.getElementById(
                    'tax'
                ).value
            ) || 0;


        const otherFee =
            parseFloat(
                document.getElementById(
                    'otherFee'
                ).value
            ) || 0;


        const discountPercentAmount =
            subtotal *
            discountPercent /
            100;


        const totalDiscount =
            discountPercentAmount +
            discountAmount;


        const grandTotal =
            Math.max(
                0,
                subtotal -
                totalDiscount +
                tax +
                otherFee
            );


        document.getElementById(
            'subtotal'
        ).innerText =
            formatRupiah(subtotal);


        document.getElementById(
            'grandTotal'
        ).innerText =
            formatRupiah(grandTotal);


        calculateChange();

    }


    /* =====================================================
       GET GRAND TOTAL
    ===================================================== */

    function getGrandTotal() {

        let subtotal = 0;


        cart.forEach(item => {

            subtotal +=
                Number(item.price) *
                Number(item.qty);

        });


        const discountPercent =
            parseFloat(
                document.getElementById(
                    'discountPercent'
                ).value
            ) || 0;


        const discountAmount =
            parseFloat(
                document.getElementById(
                    'discountAmount'
                ).value
            ) || 0;


        const tax =
            parseFloat(
                document.getElementById(
                    'tax'
                ).value
            ) || 0;


        const otherFee =
            parseFloat(
                document.getElementById(
                    'otherFee'
                ).value
            ) || 0;


        const discount =
            (
                subtotal *
                discountPercent /
                100
            ) +
            discountAmount;


        return Math.max(
            0,
            subtotal -
            discount +
            tax +
            otherFee
        );

    }


    /* =====================================================
       CALCULATE CHANGE
    ===================================================== */

    function calculateChange() {

        const total =
            getGrandTotal();


        const payment =
            parseFloat(
                document.getElementById(
                    'payment'
                ).value
            ) || 0;


        const change =
            payment - total;


        const changeBox =
            document.getElementById(
                'changeBox'
            );


        const changeElement =
            document.getElementById(
                'change'
            );


        if (payment < total) {

            changeBox.classList.add(
                'short-payment'
            );


            changeBox
                .querySelector('.change-label')
                .innerText =
                'UANG KURANG';


            changeElement.innerText =
                formatRupiah(
                    Math.abs(change)
                );

        } else {

            changeBox.classList.remove(
                'short-payment'
            );


            changeBox
                .querySelector('.change-label')
                .innerText =
                'KEMBALIAN';


            changeElement.innerText =
                formatRupiah(
                    change
                );

        }

    }


    /* =====================================================
       PAYMENT METHOD
    ===================================================== */

    function selectPayment(button) {

        document
            .querySelectorAll(
                '.payment-method button'
            )
            .forEach(btn => {

                btn.classList.remove(
                    'active'
                );

            });


        button.classList.add(
            'active'
        );


        selectedPaymentMethod =
            button.dataset.method;

    }


    /* =====================================================
       HOLD TRANSACTION
    ===================================================== */

    async function holdTransaction() {

        if (cart.length === 0) {

            alert(
                'Tidak ada transaksi untuk ditahan.'
            );

            return;

        }


        const subtotal =
            cart.reduce(
                (sum, item) =>
                    sum +
                    Number(item.price) *
                    Number(item.qty),
                0
            );


        const discountPercent =
            parseFloat(
                document.getElementById(
                    'discountPercent'
                ).value
            ) || 0;


        const discountAmount =
            parseFloat(
                document.getElementById(
                    'discountAmount'
                ).value
            ) || 0;


        const discount =
            (
                subtotal *
                discountPercent /
                100
            ) +
            discountAmount;


        const tax =
            parseFloat(
                document.getElementById(
                    'tax'
                ).value
            ) || 0;


        const otherFee =
            parseFloat(
                document.getElementById(
                    'otherFee'
                ).value
            ) || 0;


        const payload = {

            items: cart.map(item => ({

                id: item.id,

                qty: Number(item.qty)

            })),

            discount: discount,

            tax: tax,

            other_fee: otherFee

        };


        try {

            const response =
                await fetch(
                    "{{ route('admin.cashier.hold') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute(
                                        'content'
                                    )

                        },

                        body:
                            JSON.stringify(
                                payload
                            )

                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Gagal menahan transaksi.'
                );

            }


            alert(
                data.message ||
                'Transaksi berhasil ditahan.'
            );


            resetTransaction();


            location.reload();


        } catch (error) {

            alert(
                error.message ||
                'Terjadi kesalahan.'
            );

        }

    }


    /* =====================================================
       RESUME TRANSACTION
    ===================================================== */

    async function resumeTransaction(
        transactionId
    ) {

        try {

            const response =
                await fetch(
                    `/admin/cashier/held/${transactionId}`,
                    {

                        method: 'GET',

                        headers: {

                            'Accept':
                                'application/json'

                        }

                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Gagal mengambil transaksi.'
                );

            }


            const transaction =
                data.transaction;


            currentTransactionId =
                transaction.id;


            cart =
                transaction.details.map(
                    detail => ({

                        id: detail.product_id,

                        name:
                            detail.product_name,

                        price:
                            Number(detail.price),

                        qty:
                            Number(detail.qty),

                        stock:
                            getProductStock(
                                detail.product_id
                            ),

                        sku:
                            getProductSku(
                                detail.product_id
                            )

                    })
                );


            /*
             * Ambil kembali nilai transaksi
             */

            const subtotal =
                Number(
                    transaction.subtotal
                );


            const discount =
                Number(
                    transaction.discount
                );


            const tax =
                Number(
                    transaction.tax
                );


            const otherFee =
                Number(
                    transaction.other_fee
                );


            /*
             * Karena backend menyimpan total
             * diskon gabungan, kita masukkan
             * kembali ke diskon nominal.
             */

            document.getElementById(
                'discountPercent'
            ).value = 0;


            document.getElementById(
                'discountAmount'
            ).value = discount;


            document.getElementById(
                'tax'
            ).value = tax;


            document.getElementById(
                'otherFee'
            ).value = otherFee;


            document.getElementById(
                'payment'
            ).value = '';


            renderCart();


            calculateTotal();


            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });


            alert(
                'Transaksi berhasil dilanjutkan.'
            );


        } catch (error) {

            alert(
                error.message ||
                'Gagal melanjutkan transaksi.'
            );

        }

    }


    /* =====================================================
       GET PRODUCT STOCK
    ===================================================== */

    function getProductStock(productId) {

        const product =
            products.find(
                p =>
                    Number(p.id) ===
                    Number(productId)
            );


        return product
            ? Number(product.stock)
            : 0;

    }


    /* =====================================================
       GET PRODUCT SKU
    ===================================================== */

    function getProductSku(productId) {

        const product =
            products.find(
                p =>
                    Number(p.id) ===
                    Number(productId)
            );


        return product
            ? (product.sku || '')
            : '';

    }


    /* =====================================================
       DELETE HELD TRANSACTION
    ===================================================== */

    async function deleteHeldTransaction(
        transactionId
    ) {

        if (
            !confirm(
                'Hapus transaksi yang ditahan ini?'
            )
        ) {

            return;

        }


        try {

            const response =
                await fetch(
                    `/admin/cashier/held/${transactionId}`,
                    {

                        method: 'DELETE',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute(
                                        'content'
                                    )

                        }

                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Gagal menghapus transaksi.'
                );

            }


            alert(
                data.message ||
                'Transaksi berhasil dihapus.'
            );


            location.reload();


        } catch (error) {

            alert(
                error.message ||
                'Terjadi kesalahan.'
            );

        }

    }


    /* =====================================================
       PAY TRANSACTION
    ===================================================== */

    async function payTransaction() {

        if (cart.length === 0) {

            alert(
                'Keranjang masih kosong.'
            );

            return;

        }


        const total =
            getGrandTotal();


        const payment =
            parseFloat(
                document.getElementById(
                    'payment'
                ).value
            ) || 0;


        if (payment < total) {

            alert(
                'Uang pembayaran masih kurang.'
            );

            return;

        }


        const printFormat =
            document.getElementById(
                'printFormat'
            ).value;


        const discountPercent =
            parseFloat(
                document.getElementById(
                    'discountPercent'
                ).value
            ) || 0;


        const discountAmount =
            parseFloat(
                document.getElementById(
                    'discountAmount'
                ).value
            ) || 0;


        const subtotal =
            cart.reduce(
                (sum, item) =>
                    sum +
                    Number(item.price) *
                    Number(item.qty),
                0
            );


        const discount =
            (
                subtotal *
                discountPercent /
                100
            ) +
            discountAmount;


        const tax =
            parseFloat(
                document.getElementById(
                    'tax'
                ).value
            ) || 0;


        const otherFee =
            parseFloat(
                document.getElementById(
                    'otherFee'
                ).value
            ) || 0;


        const change =
            payment - total;


        /*
         * Buka print window terlebih dahulu
         * agar tidak dianggap popup otomatis
         * oleh browser.
         */

        const printWindow =
            window.open(
                '',
                '_blank',
                'width=500,height=700'
            );


        if (!printWindow) {

            alert(
                'Popup diblokir browser. Silakan izinkan popup untuk halaman ini.'
            );

            return;

        }


        printWindow.document.write(`

            <!DOCTYPE html>

            <html>

            <head>

                <title>Struk Pembayaran</title>

            </head>

            <body>

                <p style="font-family:Arial;text-align:center;">

                    Menyiapkan struk...

                </p>

            </body>

            </html>

        `);


        printWindow.document.close();


        const payload = {

            transaction_id:
                currentTransactionId,

            items:
                cart.map(item => ({

                    id: item.id,

                    qty: Number(item.qty)

                })),

            discount:
                discount,

            tax:
                tax,

            other_fee:
                otherFee,

            paid_amount:
                payment,

            payment_method:
                selectedPaymentMethod

        };


        try {

            const response =
                await fetch(
                    "{{ route('admin.cashier.pay') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute(
                                        'content'
                                    )

                        },

                        body:
                            JSON.stringify(
                                payload
                            )

                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Pembayaran gagal.'
                );

            }


            /*
             * Buat struk
             */

            createPrintReceipt(

                printWindow,

                printFormat,

                data.transaction,

                cart,

                subtotal,

                discount,

                tax,

                otherFee,

                payment,

                selectedPaymentMethod,

                change

            );


            alert(

                'Pembayaran berhasil!\n\n' +

                'Total : ' +
                formatRupiah(total) +

                '\nBayar : ' +
                formatRupiah(payment) +

                '\nKembali : ' +
                formatRupiah(change)

            );


            resetTransaction();


            location.reload();


        } catch (error) {

            if (printWindow) {

                printWindow.close();

            }


            alert(
                error.message ||
                'Terjadi kesalahan saat pembayaran.'
            );

        }

    }


    /* =====================================================
       CREATE PRINT RECEIPT
    ===================================================== */

    function createPrintReceipt(

        printWindow,

        printFormat,

        transaction,

        cartItems,

        subtotal,

        discount,

        tax,

        otherFee,

        payment,

        paymentMethod,

        change

    ) {


        let pageSize = '80mm auto';

        let receiptWidth = '72mm';

        let fontSize = '11px';


        if (
            printFormat === 'thermal58'
        ) {

            pageSize =
                '58mm auto';

            receiptWidth =
                '48mm';

            fontSize =
                '10px';

        }


        if (
            printFormat === 'thermal80'
        ) {

            pageSize =
                '80mm auto';

            receiptWidth =
                '72mm';

            fontSize =
                '11px';

        }


        if (
            printFormat === 'a4'
        ) {

            pageSize =
                'A4';

            receiptWidth =
                '80mm';

            fontSize =
                '12px';

        }


        const date =
            new Date();


        const dateText =
            date.toLocaleDateString(
                'id-ID'
            );


        const timeText =
            date.toLocaleTimeString(
                'id-ID'
            );


        const cashierName =
            @json(Auth::user()->name);


        const transactionNumber =
            transaction.transaction_number ||
            '-';


        let itemsHtml = '';


        cartItems.forEach(item => {

            const itemSubtotal =
                Number(item.price) *
                Number(item.qty);


            itemsHtml += `

                <div class="item">

                    <div class="item-name">

                        ${escapeHtml(item.name)}

                    </div>


                    <div class="item-detail">

                        <span>

                            ${item.qty}
                            x
                            ${formatRupiah(item.price)}

                        </span>


                        <span>

                            ${formatRupiah(itemSubtotal)}

                        </span>

                    </div>

                </div>

            `;

        });


        const grandTotal =
            Math.max(

                0,

                Number(subtotal) -
                Number(discount) +
                Number(tax) +
                Number(otherFee)

            );


        const receiptHtml = `

            <!DOCTYPE html>

            <html lang="id">

            <head>

                <meta charset="UTF-8">

                <title>
                    Struk ${escapeHtml(transactionNumber)}
                </title>


                <style>

                    @page {

                        size: ${pageSize};

                        margin: 0;

                    }


                    * {

                        box-sizing: border-box;

                    }


                    html,
                    body {

                        margin: 0;

                        padding: 0;

                    }


                    body {

                        font-family:

                            Arial,
                            Helvetica,
                            sans-serif;

                        font-size:
                            ${fontSize};

                        color: #000;

                    }


                    .receipt {

                        width:
                            ${receiptWidth};

                        margin:
                            0 auto;

                        padding:
                            8px;

                    }


                    .center {

                        text-align: center;

                    }


                    .bold {

                        font-weight: bold;

                    }


                    .store-name {

                        font-size:
                            16px;

                        font-weight:
                            bold;

                        margin-bottom:
                            3px;

                    }


                    .store-info {

                        font-size:
                            9px;

                        line-height:
                            1.4;

                    }


                    .line {

                        border-top:
                            1px dashed #000;

                        margin:
                            8px 0;

                    }


                    .info-row {

                        display:
                            flex;

                        justify-content:
                            space-between;

                        gap: 5px;

                        margin:
                            2px 0;

                    }


                    .item {

                        margin:
                            6px 0;

                    }


                    .item-name {

                        font-weight:
                            bold;

                        word-break:
                            break-word;

                    }


                    .item-detail {

                        display:
                            flex;

                        justify-content:
                            space-between;

                        gap: 5px;

                    }


                    .summary-row {

                        display:
                            flex;

                        justify-content:
                            space-between;

                        gap: 5px;

                        margin:
                            3px 0;

                    }


                    .grand-total {

                        font-size:
                            14px;

                        font-weight:
                            bold;

                        margin:
                            5px 0;

                    }


                    .footer {

                        margin-top:
                            12px;

                        text-align:
                            center;

                        font-size:
                            10px;

                    }


                    .print-button {

                        display:
                            block;

                        margin:
                            20px auto;

                        padding:
                            8px 15px;

                        cursor:
                            pointer;

                    }


                    @media print {

                        .print-button {

                            display:
                                none;

                        }

                    }

                </style>

            </head>


            <body>


                <div class="receipt">


                    <!-- HEADER -->

                    <div class="center">

                        <div class="store-name">

                            MINIMARKET

                        </div>


                        <div class="store-info">

                            Jl. Contoh No. 123

                            <br>

                            Jember

                            <br>

                            Telp. 0812-xxxx-xxxx

                        </div>

                    </div>


                    <div class="line"></div>


                    <!-- TRANSACTION INFO -->

                    <div class="info-row">

                        <span>
                            No. Transaksi
                        </span>

                        <span class="bold">

                            ${escapeHtml(
                                transactionNumber
                            )}

                        </span>

                    </div>


                    <div class="info-row">

                        <span>
                            Tanggal
                        </span>

                        <span>

                            ${dateText}

                        </span>

                    </div>


                    <div class="info-row">

                        <span>
                            Jam
                        </span>

                        <span>

                            ${timeText}

                        </span>

                    </div>


                    <div class="info-row">

                        <span>
                            Kasir
                        </span>

                        <span>

                            ${escapeHtml(
                                cashierName
                            )}

                        </span>

                    </div>


                    <div class="line"></div>


                    <!-- ITEMS -->

                    ${itemsHtml}


                    <div class="line"></div>


                    <!-- SUMMARY -->

                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <span>

                            ${formatRupiah(
                                subtotal
                            )}

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Diskon
                        </span>

                        <span>

                            ${formatRupiah(
                                discount
                            )}

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Pajak
                        </span>

                        <span>

                            ${formatRupiah(
                                tax
                            )}

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Biaya Lain
                        </span>

                        <span>

                            ${formatRupiah(
                                otherFee
                            )}

                        </span>

                    </div>


                    <div class="line"></div>


                    <div class="summary-row grand-total">

                        <span>
                            TOTAL
                        </span>

                        <span>

                            ${formatRupiah(
                                grandTotal
                            )}

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Bayar
                        </span>

                        <span>

                            ${formatRupiah(
                                payment
                            )}

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Metode
                        </span>

                        <span>

                            ${escapeHtml(
                                paymentMethod
                            )}

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Kembali
                        </span>

                        <span>

                            ${formatRupiah(
                                change
                            )}

                        </span>

                    </div>


                    <div class="line"></div>


                    <!-- FOOTER -->

                    <div class="footer">

                        <strong>
                            TERIMA KASIH
                        </strong>

                        <br>

                        Selamat berbelanja kembali.

                    </div>


                    <button
                        class="print-button"
                        onclick="window.print()"
                    >

                        Cetak

                    </button>


                </div>


                <script>

                    window.onload = function() {

                        setTimeout(
                            function() {

                                window.print();

                            },
                            500
                        );

                    };

                <\/script>


            </body>

            </html>

        `;


        printWindow.document.open();

        printWindow.document.write(
            receiptHtml
        );

        printWindow.document.close();

        printWindow.focus();

    }


    /* =====================================================
       RESET TRANSACTION
    ===================================================== */

    function resetTransaction() {

        cart = [];

        currentTransactionId = null;


        document.getElementById(
            'payment'
        ).value = '';


        document.getElementById(
            'discountPercent'
        ).value = 0;


        document.getElementById(
            'discountAmount'
        ).value = 0;


        document.getElementById(
            'tax'
        ).value = 0;


        document.getElementById(
            'otherFee'
        ).value = 0;


        document.getElementById(
            'searchProduct'
        ).value = '';


        document.getElementById(
            'productResults'
        ).style.display = 'none';


        document.getElementById(
            'productResults'
        ).innerHTML = '';


        selectedPaymentMethod =
            'Tunai';


        document
            .querySelectorAll(
                '.payment-method button'
            )
            .forEach(btn => {

                btn.classList.remove(
                    'active'
                );

            });


        const tunaiButton =
            document.querySelector(
                '.payment-method button[data-method="Tunai"]'
            );


        if (tunaiButton) {

            tunaiButton.classList.add(
                'active'
            );

        }


        renderCart();

    }


    /* =====================================================
       CANCEL TRANSACTION
    ===================================================== */

    function cancelTransaction() {

        if (cart.length === 0) {

            return;

        }


        if (
            !confirm(
                'Batalkan transaksi ini?'
            )
        ) {

            return;

        }


        resetTransaction();

    }


    /* =====================================================
       CLICK OUTSIDE SEARCH
    ===================================================== */

    document.addEventListener(
        'click',
        function(event) {

            const wrapper =
                document.querySelector(
                    '.search-wrapper'
                );


            if (
                wrapper &&
                !wrapper.contains(
                    event.target
                )
            ) {

                document.getElementById(
                    'productResults'
                ).style.display = 'none';

            }

        }
    );


    /* =====================================================
       KEYBOARD SHORTCUT
    ===================================================== */

    document.addEventListener(
        'keydown',
        function(event) {


            /*
             * F2 = fokus pencarian
             */

            if (
                event.key === 'F2'
            ) {

                event.preventDefault();

                searchInput.focus();

            }


            /*
             * F4 = fokus pembayaran
             */

            if (
                event.key === 'F4'
            ) {

                event.preventDefault();

                document
                    .getElementById(
                        'payment'
                    )
                    .focus();

            }


            /*
             * Escape = batal
             */

            if (
                event.key === 'Escape'
            ) {

                if (
                    cart.length > 0
                ) {

                    cancelTransaction();

                }

            }

        }
    );


    /* =====================================================
       INITIAL
    ===================================================== */

    renderCart();

    calculateTotal();

</script>


<!-- SB ADMIN 2 JS -->

<script src="{{ asset('asset/admin/vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('asset/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('asset/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ asset('asset/admin/js/sb-admin-2.min.js') }}"></script>


</body>

</html>
