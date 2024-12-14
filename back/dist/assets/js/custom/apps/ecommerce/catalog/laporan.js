"use strict";

var KTAppEcommerceProducts = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            "paging": true, // Aktifkan pagination
            "pageLength": 5,
            "columnDefs": [
                { render: DataTable.render.number(',', '.', 2), targets: 3 }
            ]
        });

        // Re-init functions on datatable re-draws
        datatable.on('draw', function () {
            handleDeleteRows();
        });

        // Mengaktifkan tombol Previous dan Next
        $('#kt_ecommerce_products_table_previous').on('click', function () {
            datatable.page('previous').draw('page');
        });

        $('#kt_ecommerce_products_table_next').on('click', function () {
            datatable.page('next').draw('page');
        });
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#kt_ecommerce_products_table');

            if (!table) {
                return;
            }

            initDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceProducts.init();
});

// Buat koneksi awal ke server SSE
let eventSource = new EventSource('proses/ssePesanan.php'); // Sesuaikan dengan URL server SSE yang sesuai.

eventSource.onopen = function () {
    console.log('Koneksi SSE berhasil.');
};

eventSource.onmessage = function (event) {
    const data = JSON.parse(event.data);
    // Update tabel dengan data yang diterima dari server
    // Cari baris yang sesuai dengan kode pesanan
    const existingRow = document.getElementById('row_' + data.kode_p);

    // Jika baris sudah ada, perbarui data di dalamnya
    if (existingRow) {
        existingRow.cells[1].textContent = data.customer;
        existingRow.cells[2].textContent = data.t_item;
        existingRow.cells[3].textContent = data.t_harga;

        // Menggabungkan detail pesanan menjadi satu teks
        var detailPesananText = '';
        data.detail_pesanan.forEach(function (item) {
            detailPesananText += 'Nama Barang: ' + item.nama_produk + '<br>';
            detailPesananText += 'Jumlah Item: ' + item.jumlah + '<br>';
            detailPesananText += 'Harga Per Item: ' + item.harga_per_item + '<br><br>';
        });
        existingRow.cells[4].innerHTML = detailPesananText;
        existingRow.cells[5].innerHTML = data.aksi;
    } else {
        // Jika baris belum ada, tambahkan baris baru ke tabel
        const table = document.getElementById('kt_ecommerce_products_table');
        const newRow = table.insertRow(1); // 1 karena baris pertama adalah header
        newRow.id = 'row_' + data.kode_p; // Atur id untuk baris baru
        // Kolom-kolom tabel
        const cellNoPesanan = newRow.insertCell(0);
        const cellCustomer = newRow.insertCell(1);
        const cellTotalQty = newRow.insertCell(2);
        const cellTotalHarga = newRow.insertCell(3);
        const cellDetailPesanan = newRow.insertCell(4);
        const cellAksi = newRow.insertCell(5);

        // Isi kolom-kolom tabel dengan data pesanan
        cellNoPesanan.textContent = data.kode_p;
        cellCustomer.textContent = data.customer;
        cellTotalQty.textContent = data.t_item;
        cellTotalHarga.textContent = data.t_harga;

        // Menggabungkan detail pesanan menjadi satu teks
        var detailPesananText = '';
        data.detail_pesanan.forEach(function (item) {
            detailPesananText += 'Nama Barang: ' + item.nama_produk + '<br>';
            detailPesananText += 'Jumlah Item: ' + item.jumlah + '<br>';
            detailPesananText += 'Harga Per Item: ' + item.harga_per_item + '<br><br>';
        });
        cellDetailPesanan.innerHTML = detailPesananText;

        cellAksi.innerHTML = data.aksi;
    }
};

eventSource.onerror = function (error) {
    console.error('Terjadi kesalahan SSE:', error);

    // Coba menyambung kembali jika terjadi kesalahan koneksi
    setTimeout(function () {
        eventSource.close(); // Tutup koneksi yang terputus
        eventSource = new EventSource('proses/ssePesanan.php'); // Buat koneksi baru
        eventSource.onopen = function () {
            console.log('Koneksi SSE berhasil disambungkan kembali.');
        };
    }, 5000); // Coba menyambung kembali setelah 3 detik (sesuaikan dengan kebutuhan Anda)
};

// Anda dapat menambahkan event listeners di sini jika diperlukan
eventSource.addEventListener('customEvent', function (event) {
    // Tangani peristiwa khusus yang diberikan oleh server SSE
    const eventData = JSON.parse(event.data);

    // Contoh: Menampilkan pesan notifikasi kepada pengguna
    const notificationMessage = `Pesanan ${eventData.kode_p} telah diperbarui menjadi ${eventData.status}`;
    showNotification(notificationMessage);
});

// Fungsi untuk menampilkan pesan notifikasi (contoh)
function showNotification(message) {
    // Tambahkan logika untuk menampilkan pesan notifikasi kepada pengguna di sini
    console.log('Notifikasi:', message);
}
