<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Proyek Baru</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>

<body class="bg-light">
    <nav class=" navbar navbar-expand-lg bg-emphasis border-bottom border-body">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src=<?php echo base_url('assets/img/Logo.png'); ?> alt="Bootstrap" height="100%">
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row mt-3">
            <div class="col-md-8 offset-md-2">
                <h3 class="mb-3">Ubah Proyek Baru</h3>
                <form action="" method="post" id="editProyekForm">

                    <div class="form-group mb-3">
                        <label for="namaProyek" class="form-label">Nama Proyek:</label>
                        <input type="text" id="namaProyek" name="namaProyek" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="client" class="form-label">Client:</label>
                        <input type="text" id="client" name="client" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tglMulai" class="form-label">Tanggal Mulai:</label>
                        <input type="datetime-local" id="tglMulai" name="tglMulai" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tglSelesai" class="form-label">Tanggal Selesai:</label>
                        <input type="datetime-local" id="tglSelesai" name="tglSelesai" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="pimpinanProyek" class="form-label">Pimpinan Proyek:</label>
                        <input type="text" id="pimpinanProyek" name="pimpinanProyek" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="lokasiList" class="form-label">Pilih Lokasi:</label>
                        <select id="lokasiList" name="lokasiList" class="form-select" required>
                            <option value="" selected disabled>Pilih Lokasi</option>
                            <!-- Lokasi akan diisi secara dinamis menggunakan AJAX -->
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan" class="form-label">Keterangan:</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="d-flex gap-2 mb-4">
                        <button type="submit" class="btn btn-secondary">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('assets/jquery/jquery-3.7.1.js'); ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            function formatDate(dateString) {
                const date = new Date(dateString);

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            function loadProyek() {
                let idLokasiCurrent = 0;
                $.ajax({
                    url: 'http://localhost:8080/api/proyek/' + <?= $id_proyek; ?>,
                    type: 'GET',
                    success: function(response) {
                        $('#namaProyek').val(response.namaProyek);
                        $('#client').val(response.client);
                        $('#tglMulai').val(formatDate(response.tglMulai));
                        $('#tglSelesai').val(formatDate(response.tglSelesai));
                        $('#pimpinanProyek').val(response.pimpinanProyek);
                        $('#keterangan').val(response.keterangan);

                        idLokasiCurrent = response.lokasiList[0].id;
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat mengambil data lokasi: ' + error);
                    }
                });

                $.ajax({
                    url: `http://localhost:8080/api/lokasi`,
                    type: 'GET',
                    success: function(data) {
                        var lokasiSelect = $('#lokasiList');

                        lokasiSelect.empty();

                        lokasiSelect.append('<option value="" selected disabled>Pilih Lokasi</option>');

                        $.each(data, function(index, lokasi) {
                            let selectedOption = lokasi.id == idLokasiCurrent ? 'selected' : '';
                            lokasiSelect.append(`<option ${selectedOption} value="${lokasi.id}">${lokasi.namaLokasi}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal memuat data lokasi: ' + error);
                    }
                });
            }
            loadProyek();

            $('#editProyekForm').on('submit', function(e) {
                event.preventDefault();

                var proyekData = {
                    namaProyek: $('#namaProyek').val(),
                    client: $('#client').val(),
                    tglMulai: $('#tglMulai').val(),
                    tglSelesai: $('#tglSelesai').val(),
                    pimpinanProyek: $('#pimpinanProyek').val(),
                    keterangan: $('#keterangan').val(),
                    lokasiList: [{
                        id: parseInt($('#lokasiList').val())
                    }]
                };

                var locationId = "<?= $id_proyek; ?>";

                $.ajax({
                    url: `http://localhost:8080/api/proyek/${locationId}`,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(proyekData),
                    success: function(response) {
                        alert('Proyek berhasil diubah!');
                        window.location.href = "<?= base_url(); ?>";
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal mengubah proyek.');
                    }
                });
            });
        });
    </script>

</body>

</html>