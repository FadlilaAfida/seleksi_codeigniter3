<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Lokasi Baru</title>
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
                <h3 class="mb-3">Tambah Lokasi Baru</h3>
                <form action="" method="post" id="lokasiForm">

                    <div class="form-group mb-3">
                        <label for="nama_lokasi" class="form-label">Nama Lokasi:</label>
                        <input type="text" id="nama_lokasi" name="nama_lokasi" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="client" class="form-label">Negara:</label>
                        <input type="text" id="negara" name="negara" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="client" class="form-label">Provinsi:</label>
                        <input type="text" id="provinsi" name="provinsi" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="kota" class="form-label">Kota:</label>
                        <input type="text" id="kota" name="kota" class="form-control" required>
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
            $('#lokasiForm').on('submit', function(event) {
                event.preventDefault();

                var lokasiData = {
                    namaLokasi: $('#nama_lokasi').val(),
                    negara: $('#negara').val(),
                    provinsi: $('#provinsi').val(),
                    kota: $('#kota').val()
                };

                $.ajax({
                    url: 'http://localhost:8080/api/lokasi',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(lokasiData),
                    success: function(response) {
                        alert('Lokasi berhasil disimpan!');
                        $('#lokasiForm')[0].reset();
                        window.location.href = "<?= base_url(); ?>";
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat menyimpan lokasi.');
                    }
                });
            });
        });
    </script>

</body>

</html>