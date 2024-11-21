<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Serkom</title>
    <!-- link CSS Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- link CSS DataTables -->
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">SimpleCal</h1>
        <div class="card mt-4">
            <div class="card-body">
                <form action="<?= base_url('/') ?>" method="POST">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <input type="decimal" class="form-control" name="num1" placeholder="Enter number 1" required>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="operator" required>
                                <option value="+" selected>+ (tambah)</option>
                                <option value="-">- (kurang)</option>
                                <option value="*">* (kali)</option>
                                <option value="/">/ (bagi)</option>
                                <option value="%">% (mod)</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="decimal" class="form-control" name="num2" placeholder="Enter number 2" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Calculate</button>
                        </div>
                    </div>
                </form>

                <?php if (isset($hasil)) : ?>
                    <h2 class="mt-4">Hasil: <?= $hasil ?></h2>
                    <form action="<?= base_url('/') ?>" method="get">
                        <button class="btn btn-danger" type="submit">Reset Hasil</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5">
            <h2>Calculation History</h2>
            <table id="calculation-table" class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Number 1</th>
                        <th>Operator</th>
                        <th>Number 2</th>
                        <th>Hasil</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- mengambil data pada tabel db -->
                    <?php foreach ($calculations as $coba => $calculation) : ?>
                        <tr>
                            <td><?= $coba + 1 ?></td>
                            <td><?= $calculation['num1'] ?></td>
                            <td><?= $calculation['operator'] ?></td>
                            <td><?= $calculation['num2'] ?></td>
                            <td><?= $calculation['hasil'] ?></td>
                            <td>
                                <!-- Button action -->
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $calculation['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('/delete/' . $calculation['id']) ?>" class="btn btn-danger delete-link" data-id="<?= $calculation['id'] ?>"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $calculation['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $calculation['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $calculation['id'] ?>">Edit Calculated</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('/update') ?>" method="post">
                                            <input type="hidden" name="id" value="<?= $calculation['id'] ?>">
                                            <div class="row">
                                                <div class="form-group col-4">
                                                    <label for="editNum1">Number 1</label>
                                                    <input type="number" class="form-control" id="editNum1" name="editNum1" value="<?= $calculation['num1'] ?>" required>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="editOperator">Operator</label>
                                                    <select class="form-control" id="editOperator" name="editOperator" required>
                                                        <option value="+" <?= ($calculation['operator'] == '+') ? 'selected' : '' ?>>+ (tambah)</option>
                                                        <option value="-" <?= ($calculation['operator'] == '-') ? 'selected' : '' ?>>- (kurang)</option>
                                                        <option value="*" <?= ($calculation['operator'] == '*') ? 'selected' : '' ?>>* (kali)</option>
                                                        <option value="/" <?= ($calculation['operator'] == '/') ? 'selected' : '' ?>>/ (bagi)</option>
                                                        <option value="%" <?= ($calculation['operator'] == '%') ? 'selected' : '' ?>>% (mod)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="editNum2">Number 2</label>
                                                    <input type="number" class="form-control" id="editNum2" name="editNum2" value="<?= $calculation['num2'] ?>" required>
                                                </div>
                                                <div class="form-group col-4">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="mt-5 text-center">
        <p>&copy; 2024 Developed by Sevyra Nanda Octavianti - V3921034</p>
    </footer>

    <!-- Tambahkan script JavaScript Bootstrap (jika diperlukan) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            $('#calculation-table').DataTable();

            $('.delete-link').click(function(event) {
                event.preventDefault(); // Mencegah tindakan default dari tautan

                var url = $(this).attr('href'); // Mendapatkan URL dari tautan
                var id = $(this).data('id'); // Mendapatkan ID data

                // Menampilkan alert konfirmasi menggunakan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: "Tindakan ini tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna menekan "Ya, Hapus!", arahkan ke URL yang sesuai untuk menghapus data
                        Swal.fire(
                            'Berhasil!',
                            'Data berhasil dihapus.',
                            'success'
                        )
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</body>

</html>