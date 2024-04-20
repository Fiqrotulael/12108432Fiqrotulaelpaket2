<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Kasir</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>CRUD Kasir</h1>

    <!-- Form untuk menambah produk -->
    <h2>Tambah Produk</h2>
    <form id="form-tambah">
        <label for="nama">Nama Produk:</label><br>
        <input type="text" id="nama" name="nama"><br>
        <label for="harga">Harga:</label><br>
        <input type="text" id="harga" name="harga"><br>
        <label for="stok">Stok:</label><br>
        <input type="text" id="stok" name="stok"><br><br>
        <input type="submit" value="Tambah Produk">
    </form>

    <!-- Tabel untuk menampilkan produk -->
    <h2>Daftar Produk</h2>
    <table id="tabel-produk">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data produk akan ditampilkan di sini -->
        </tbody>
    </table>

    <script>
        // Script JavaScript untuk menangani submit form dan menampilkan data produk
        document.addEventListener('DOMContentLoaded', function() {
            const formTambah = document.getElementById('form-tambah');
            const tabelProduk = document.getElementById('tabel-produk');

            // Fungsi untuk menampilkan data produk
            function tampilkanProduk() {
                fetch('/api/produk')
                    .then(response => response.json())
                    .then(data => {
                        // Hapus semua baris di dalam tabel
                        tabelProduk.querySelectorAll('tbody tr').forEach(tr => tr.remove());
                        // Tambahkan kembali baris baru berdasarkan data produk
                        data.forEach(produk => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${produk.id}</td>
                                <td>${produk.nama}</td>
                                <td>${produk.harga}</td>
                                <td>${produk.stok}</td>
                                <td>
                                    <button onclick="hapusProduk(${produk.id})">Hapus</button>
                                </td>
                            `;
                            tabelProduk.querySelector('tbody').appendChild(tr);
                        });
                    });
            }

            // Event listener untuk menangani submit form tambah
            formTambah.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('/api/produk', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        tampilkanProduk(); // Tampilkan kembali data produk setelah menambahkan produk baru
                        formTambah.reset(); // Reset form setelah berhasil menambahkan produk
                    }
                });
            });

            // Fungsi untuk menghapus produk
            window.hapusProduk = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    fetch(`/api/produk/${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => {
                        if (response.ok) {
                            tampilkanProduk(); // Tampilkan kembali data produk setelah menghapus produk
                        }
                    });
                }
            };

            // Tampilkan data produk saat halaman dimuat
            tampilkanProduk();
        });
    </script>
</body>
</html>
