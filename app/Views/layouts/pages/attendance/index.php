<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="container-fluid">

        <div class="d-sm-flex flex-column mb-4">
            <h1 class="h3 mb-3 text-gray-800">Attedance</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dahsboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attedance</li>
                </ol>
            </nav>
        </div>

        <?php if (session()->getFlashData('success_change_status')) : ?>
            <div class="alert success alert-success" role="alert">
                <?php echo session("success_change_status") ?>
            </div>
        <?php endif; ?>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Employee</th>
                            <th>Category</th>
                            <th>Reason</th>
                            <th>File</th>
                            <th>Absent Sign In</th>
                            <th>Absent Sign Out</th>
                            <th>Late</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($attendance as $e) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $e['fullname']; ?></td>

                                <!--START CATEGORY-->
                                <?php if ($e['name']) : ?>
                                    <td><?= $e['name']; ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <!--END CATEGORY-->

                                <!--START DESC-->
                                <?php if ($e['description']) : ?>
                                    <td><?= $e['description']; ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <!--END DESC-->

                                <!--START FILE-->
                                <?php if ($e['user_proof_file']) : ?>
                                    <td><?= substr($e['user_proof_file'], 0, 15) ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <!--END FILE-->

                                <!--START SIGN IN-->
                                <td><?= date_format(date_create($e['created_at']), 'd M Y H:i') ?></td>
                                <!--END SIGN IN-->

                                <!--START SIGN OUT-->
                                <?php if ($e['updated_at']) : ?>
                                    <td><?= date_format(date_create($e['updated_at']), 'd M Y H:i') ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <!--END SIGN OUT-->

                                <!--START LATE TIME-->
                                <?php if ($late === true && $e['category'] === 'hadir') : ?>
                                    <td><?= date_format(date_create($e['created_at']), 'H:i') ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <!--END LATE TIME-->

                                <!--START STATUS ATTENDANCE-->
                                <?php if ($late === true && $e['category'] === 'hadir') : ?>
                                    <td><span class="badge rounded-pill bg-danger">Late</span></td>
                                <?php elseif ($late === false && $e['category'] === 'hadir') : ?>
                                    <td><span class="badge rounded-pill bg-success">On Time</span></td>
                                <?php elseif ($e['category'] !== 'hadir' && $e['status'] === 'PENDING') : ?>
                                    <td><span class="badge rounded-pill bg-warning">Pending</span></td>
                                <?php elseif ($e['status'] === 'APPROVED') : ?>
                                    <td><span class="badge rounded-pill bg-success">Approve</span></td>
                                <?php elseif ($e['status'] === 'REJECTED') : ?>
                                    <td><span class="badge rounded-pill bg-danger">Reject</span></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <!--END STATUS ATTENDANCE-->

                                <!--START ACTION-->
                                <?php if ($e['status'] === 'PENDING') : ?>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#approveModal<?= $e['attendanceId'] ?>">
                                            <i class="bi bi-aye-fill">Detail</i>
                                        </button>
                                    </td>
                                <?php else : ?>
                                    <td>No action</td>
                                <?php endif; ?>
                                <!--END ACTION-->
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Approve -->
    <?php foreach ($attendance as $e) : ?>
        <div class="modal fade" id="approveModal<?= $e['attendanceId'] ?>" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <img style="width: 100%" src="<?= base_url() . "/assets/media/berkas/" . $e['user_proof_file'] ?>">
                        </br>
                        <div class="pt-3 text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form class="d-inline" method="post"
                                  action="<?= base_url(); ?>/admin/attendance/<?= $e['attendanceId'] ?>/rejected">
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                            <form class="d-inline" method="post"
                                  action="<?= base_url(); ?>/admin/attendance/<?= $e['attendanceId'] ?>/approved">
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable({
                "dom": `Q
                <'row mt-3'
                    <'col-sm-12 col-md-4'l>
                    <'col-sm-12 col-md-8'
                        <'row'
                            <'col-sm-12 col-md-9'f>
                            <'col-sm-12 col-md-3'B>
                        >
                    >
                >
                ` +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "responsive": true,
                "paging": true,
                "ordering": true,
                "info": true,
                "buttons": [
                    'excel',
                ]
            });
        });

        $(".success").fadeTo(2000, 500).slideUp(500, function () {
            $(".success").slideUp(500);
        });

    </script>
<?= $this->endSection() ?>