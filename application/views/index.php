<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Proyek - By Fadlila Afida</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="assets/css/stateRestore.bootstrap5.css">
</head>

<body class="bg-light">
    <nav class=" navbar navbar-expand-lg bg-emphasis border-bottom border-body">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/img/Logo.png" alt="Bootstrap" height="100%">
            </a>
        </div>
    </nav>

    <!-- table proyek -->
    <div class="container mt-5">
        <div class="row mt-3">
            <div class="col-12">
                <h3>Data Proyek</h3>
                <table id="proyek" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Proyek</th>
                            <th>Client</th>
                            <th>Tanggal mulai</th>
                            <th>Tanggal selesai</th>
                            <th>Pimpinan proyek</th>
                            <th>Nama Lokasi</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- table proyek -->

    <!-- table lokasi -->
    <div class="container mb-5">
        <div class="row mt-3">
            <div class="col-12">
                <h3>Data Lokasi</h3>
                <table id="lokasi" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Lokasi</th>
                            <th>Negara</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- table lokasi -->

    <script src="assets/jquery/jquery-3.7.1.js"></script>
    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dataTables.js"></script>
    <script src="assets/js/dataTables.bootstrap5.js"></script>
    <script src="assets/js/dataTables.responsive.js"></script>
    <script src="assets/js/responsive.bootstrap5.js"></script>
    <script src="assets/js/dataTables.stateRestore.js"></script>
    <script src="assets/js/stateRestore.bootstrap5.js"></script>
    <script src="assets/js/dataTables.buttons.js"></script>
    <script src="assets/js/buttons.bootstrap5.js"></script>

    <script>
        function deleteLokasi(id_lokasi) {
            // Konfirmasi sebelum menghapus
            if (confirm('Apakah Anda yakin ingin menghapus data lokasi ini?')) {
                $.ajax({
                    url: `http://localhost:8080/api/lokasi/${id_lokasi}`,
                    type: 'DELETE',
                    success: function(response) {
                        alert('Data lokasi berhasil dihapus!');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat menyimpan lokasi.');
                    }
                });
            }
        }

        function deleteProyek(id_proyek) {
            // Konfirmasi sebelum menghapus
            if (confirm('Apakah Anda yakin ingin menghapus data proyek ini?')) {
                $.ajax({
                    url: `http://localhost:8080/api/proyek/${id_proyek}`,
                    type: 'DELETE',
                    success: function(response) {
                        alert('Data proyek berhasil dihapus!');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat menyimpan lokasi.');
                    }
                });
            }
        }

        $(document).ready(function() {

            function formatDate(dateString) {
                const date = new Date(dateString);

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Tambah 1 karena getMonth() mulai dari 0
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            const proyekTable = new DataTable('#proyek', {
                responsive: true,
                layout: {
                    topStart: {
                        buttons: [{
                            text: '+ Tambah Proyek Baru',
                            action: function(e, dt, button, config) {
                                window.location = '<?= site_url('proyek/tambah_proyek'); ?>';
                            }
                        }]
                    }
                }
            });

            const lokasiTable = new DataTable('#lokasi', {
                responsive: true,
                layout: {
                    topStart: {
                        buttons: [{
                            text: '+ Tambah Lokasi Baru',
                            action: function(e, dt, button, config) {
                                window.location = '<?= site_url('lokasi/tambah_lokasi'); ?>';
                            }
                        }]
                    }
                }
            });

            $.ajax({
                url: 'http://localhost:8080/api/proyek',
                method: 'GET',
                success: function(data) {
                    $.each(data, function(index, proyek) {
                        proyekTable.row
                            .add([
                                proyek.namaProyek,
                                proyek.client,
                                formatDate(proyek.tglMulai),
                                formatDate(proyek.tglSelesai),
                                proyek.pimpinanProyek,
                                proyek.lokasiList[0].namaLokasi,
                                proyek.keterangan,
                                formatDate(proyek.createdAt),
                                `<a href="<?= site_url(); ?>/proyek/ubah_proyek/${proyek.id}" class="btn btn-warning me-1">Edit</a><a onclick="deleteProyek('${proyek.id}')" class="btn btn-danger">Delete</a>`
                            ])
                            .draw(false);
                    });
                },
                error: function(error) {
                    alert(`Error ${error}`)
                }
            });

            $.ajax({
                url: 'http://localhost:8080/api/lokasi',
                method: 'GET',
                success: function(data) {
                    $.each(data, function(index, lokasi) {
                        lokasiTable.row
                            .add([
                                lokasi.namaLokasi,
                                lokasi.negara,
                                lokasi.provinsi,
                                lokasi.kota,
                                formatDate(lokasi.createdAt),
                                `<a href="<?= site_url(); ?>/lokasi/ubah_lokasi/${lokasi.id}" class="btn btn-warning me-1">Edit</a><a onclick="deleteLokasi('${lokasi.id}')" class="btn btn-danger">Delete</a>`
                            ])
                            .draw(false);
                    });
                },
                error: function(error) {
                    alert(`Error ${error}`);
                }
            });

        });
    </script>
</body>

</html>