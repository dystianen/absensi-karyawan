<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="d-sm-flex flex-column mb-4">
            <h1 class="h3 mb-3 text-gray-800">QR</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">QR
                    </li>
                </ol>
            </nav>
        </div>

        <?php if (session()->getFlashData('success_qr')) : ?>
            <div class="alert success alert-success" role="alert">
                <?php echo session("success_qr") ?>
            </div>
        <?php endif; ?>

        <?php if (!$qrToday) : ?>
            <div class="alert info alert-info" role="alert">
                Please Create a QR CODE for Today!
            </div>
        <?php endif; ?>

        <div class="m-3" id="ip" style="font-weight: bold">ip</div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Content</th>
                            <th>File</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($qr as $q) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= (strlen(htmlspecialchars($q['content'])) > 13)
                                        ? substr(htmlspecialchars($q['content']), 0, 10) . '...'
                                        : htmlspecialchars(
                                            $q['content']
                                        ); ?>
                                <td><?= (strlen(htmlspecialchars($q['file'])) > 13)
                                        ? substr(htmlspecialchars($q['file']), 0, 10) . '...'
                                        : htmlspecialchars(
                                            $q['file']
                                        ); ?>
                                <td><?= date_format(date_create($q['created_at']), 'd M Y H:i') ?></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="<?= base_url($q['file']) ?>"
                                       target="_blank">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $q['qrId'] ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Generate QR CODE -->
        <?php foreach ($qr as $q) : ?>
            <div class="modal fade" id="generateModal" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h3>Are you sure</h3>
                            Do you want to make a QR Code?
                            </br>
                            <div class="pt-3">
                                <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                                <form class="d-inline" method="post" action="<?php echo base_url(); ?>/admin/qr/save">
                                    <button type="submit" class="btn btn-danger m-2">Yes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Modal Delete -->
        <?php foreach ($qr as $q) : ?>
            <div class="modal fade" id="deleteModal<?= $q['qrId'] ?>" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h3>Are you sure?</h3>
                            Do you really delete this data?
                            </br>
                            <div class="pt-3">
                                <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                                <form class="d-inline" method="post"
                                      action="<?= base_url(); ?>/admin/qr/delete/<?= $q['qrId'] ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger m-2">Yes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <script type="text/javascript">
        //regular expressions to extract IP and country values
        const countryCodeExpression = /loc=([\w]{2})/;
        const userIPExpression = /ip=([\w\.]+)/;

        //automatic country determination.
        function initCountry() {
            return new Promise((resolve, reject) => {
                let xhr = new XMLHttpRequest();
                xhr.timeout = 3000;
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            const countryCode = countryCodeExpression.exec(this.responseText)
                            const ip = userIPExpression.exec(this.responseText)
                            if (countryCode === null || countryCode[1] === '' ||
                                ip === null || ip[1] === '') {
                                reject('IP/Country code detection failed');
                            }
                            let result = {
                                countryCode: countryCode[1],
                                IP: ip[1]
                            };
                            resolve(result)
                            document.getElementById("ip").innerHTML = "IP Address : " + result.IP
                        } else {
                            reject(xhr.status)
                        }
                    }
                }
                xhr.ontimeout = function () {
                    reject('timeout')
                }
                xhr.open('GET', 'https://www.cloudflare.com/cdn-cgi/trace', true);
                xhr.send();
            });
        }

        initCountry().then(result => console.log(JSON.stringify(result))).catch(e => console.log(e))

        let isQrToday = '<?php echo $qrCreated; ?>';

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
                    {
                        text: 'Generate QR',
                        action: function (e, node, config) {
                            if (!isQrToday) {
                                $('#generateModal').modal('show')
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'FYI!',
                                    text: 'Unable to generate QR Code because it was already created for today!',
                                    showConfirmButton: false,
                                    showCloseButton: true,
                                    heightAuto: false,
                                })
                            }
                        }
                    }
                ]
            });
        });

        $(".success").fadeTo(2000, 500).slideUp(500, function () {
            $(".success").slideUp(500);
        });

    </script>
<?= $this->endSection() ?>