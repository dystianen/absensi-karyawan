<?= $this->extend("layouts/app") ?>
<?= $this->section("content") ?>
    <div class="container-fluid">

        <div class="d-sm-flex flex-column mb-4">
            <h1 class="h3 mb-3 text-gray-800">Evaluation</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/evaluation">Evaluation</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="card-title mb-0 text-gray-900">Create Evaluation</h5>
            </div>

            <div class="card-body mt-2">
                <form action="<?php echo base_url(); ?>/admin/evaluation/create/submit" method="post">
                    <?= csrf_field(); ?>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user" class="form-label">User <span style="color: red">*</span></label>
                                    <select id="employee" name="user_id"
                                            class="form-select <?= ($validation->hasError('user_id') ? 'is-invalid' : '') ?>"
                                            id="basicSelect">
                                        <option value="">--please select--</option>
                                        <?php foreach ($user as $e) : ?>
                                            <option value="<?= $e['userId'] ?>" <?php if (old('user_id') == $e['userId']) {
                                                echo 'selected';
                                            } ?>><?= $e['fullname'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('user_id') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">A. PERILAKU KERJA (40%)</div>
                                    <div class="card-body">
                                        <div class="mt-3 row">
                                            <label for="disiplin" class="col-sm-4 col-form-label">Disiplin</label>
                                            <div class="col-sm-6">
                                                <input name="disiplin" type="number" min="0" max="100" class="form-control"
                                                       id="disiplin">
                                                <div class="disiplin-invalid-feedback" style="color: #dc3545; font-size: 12px"></div>
                                            </div>
                                        </div>
                                        <div class="mt-3 row">
                                            <label for="loyalitas" class="col-sm-4 col-form-label">Loyalitas</label>
                                            <div class="col-sm-6">
                                                <input name="loyalitas" type="number" min="0" max="100" class="form-control"
                                                       id="loyalitas">
                                                <div class="loyalitas-invalid-feedback" style="color: #dc3545; font-size: 12px"></div>
                                            </div>
                                        </div>
                                        <div class="mt-3 row">
                                            <label for="kerjasama" class="col-sm-4 col-form-label">Kerja Sama</label>
                                            <div class="col-sm-6">
                                                <input name="kerjasama" type="number" min="0" max="100" class="form-control"
                                                       id="kerjasama">
                                                <div class="kerjasama-invalid-feedback" style="color: #dc3545; font-size: 12px"></div>
                                            </div>
                                        </div>
                                        <div class="mt-3 row">
                                            <label for="perilaku" class="col-sm-4 col-form-label">Perilaku</label>
                                            <div class="col-sm-6">
                                                <input name="perilaku" type="number" min="0" max="100" class="form-control"
                                                       id="perilaku">
                                                <div class="perilaku-invalid-feedback" style="color: #dc3545; font-size: 12px"></div>
                                            </div>
                                        </div>
                                        <div class="mt-5 row">
                                            <label for="total" class="col-sm-4 col-form-label">Total</label>
                                            <div class="col-sm-6">
                                                <input readonly name="total_sikap" type="number" class="form-control" id="total">
                                            </div>
                                        </div>
                                        <div class="mt-2 row">
                                            <label for="total" class="col-sm-4 col-form-label font-bold">SCORE 40%</label>
                                            <div class="col-sm-6">
                                                <input readonly name="total_percentage_sikap" type="number" class="form-control" id="total_percentage_sikap">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">B. HASIL PEKERJAAN (60%)</div>
                                    <div class="card-body">
                                        <div class="mt-3 row">
                                            <div class="col-sm-6">
                                                <select id="job_id" name="job_id" class="form-select <?= ($validation->hasError('job_id') ? 'is-invalid' : '') ?>" id="basicSelect">
                                                    <option value="">--please select--</option>
                                                    <?php foreach ($job as $j) : ?>
                                                        <option value="<?= $j['jobId'] ?>" <?php if (old('job_id') == $j['jobId']) {
                                                            echo 'selected';
                                                        } ?>><?= $j['type_of_work'] ?></option>
                                                    <?php endforeach; ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('job_id') ?>
                                                    </div>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <input id="type" name="value_job_type" type="number" min="0" max="100" class="form-control">
                                                <div class="type-invalid-feedback" style="color: #dc3545; font-size: 12px"></div>
                                            </div>
                                        </div>

                                        <div class="row" style="padding-top: 13rem">
                                            <label for="total" class="col-sm-6 col-form-label">Total</label>
                                            <div class="col-sm-6">
                                                <input readonly name="total_working_result" class="form-control" id="total_working">
                                            </div>
                                        </div>
                                        <div class="mt-2 row">
                                            <label for="total" class="col-sm-6 col-form-label font-bold">SCORE 60%</label>
                                            <div class="col-sm-6">
                                                <input readonly name="total_percentage_working_result" class="form-control" id="total_percentage_working_result">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="mt-3 row">
                            <label for="totalNilai" class="col-sm-2 col-form-label">Total Nilai (A+B)</label>
                            <div class="col-sm-3">
                                <input readonly name="totalNilai" type="number" class="form-control" id="totalNilai">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="mt-3 row">
                            <label for="totalNilai" class="col-sm-2 col-form-label">Predikat</label>
                            <div class="col-sm-3">
                                <input readonly name="predikat" class="form-control" id="predikat">
                            </div>
                        </div>
                    </div>


                    <div class="float-end pt-3">
                        <a type="button" class="btn btn-secondary" href="/admin/evaluation">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        $("#disiplin, #loyalitas, #kerjasama, #perilaku").change(function () {
            let disiplin = document.getElementById('disiplin').value;
            let loyalitas = document.getElementById('loyalitas').value;
            let kerjasama = document.getElementById('kerjasama').value;
            let perilaku = document.getElementById('perilaku').value;

            let total = null;
            if (disiplin && loyalitas && kerjasama && perilaku) {
                total = Number(disiplin) + Number(loyalitas) + Number(kerjasama) + Number(perilaku);
                document.getElementById("total").value = total / 4;
                document.getElementById("total_percentage_sikap").value = 40 / 100 * document.getElementById("total").value;
            }
        });

        $('#type').change(function () {
            let totalWorking = document.getElementById('type').value;
            let percentageSikap = document.getElementById("total_percentage_sikap").value;
            document.getElementById("total_working").value = totalWorking / 1;
            document.getElementById("total_percentage_working_result").value = 60 / 100 * totalWorking;

            let percentageWorking = document.getElementById("total_percentage_working_result").value;
            const res =  Number(percentageSikap) + Number(percentageWorking);
            document.getElementById("totalNilai").value = res;
            
            if (res) {
                if (res > 90) {
                    document.getElementById("predikat").value = 'Sangat Baik'
                } else if (res > 75) {
                    document.getElementById("predikat").value = 'Baik'
                } else if (res > 60) {
                    document.getElementById("predikat").value = 'Cukup'
                } else if (res < 60) {
                    document.getElementById("predikat").value = 'Kurang'
                }
            }
        });

        let maximum = new RegExp('^[1-9][0-9]?$|^100$');

        $("#disiplin").change(function () {
            let disiplin = document.getElementById('disiplin').value;
            if (!maximum.test(disiplin)) {
                $(this).addClass('is-invalid');
                $('.disiplin-invalid-feedback').text("Max 100!");
            } else {
                $(this).removeClass('is-invalid')
                $('.disiplin-invalid-feedback').remove();
            }
        })

        $("#loyalitas").change(function () {
            let loyalitas = document.getElementById('loyalitas').value;
            if (!maximum.test(loyalitas)) {
                $(this).addClass('is-invalid');
                $('.loyalitas-invalid-feedback').text("Max 100!");
            } else {
                $(this).removeClass('is-invalid');
                $('.loyalitas-invalid-feedback').remove();
            }
        })

        $("#kerjasama").change(function () {
            let kerjasama = document.getElementById('kerjasama').value;
            if (!maximum.test(kerjasama)) {
                $(this).addClass('is-invalid');
                $('.kerjasama-invalid-feedback').text("Max 100!");
            } else {
                $(this).removeClass('is-invalid');
                $('.kerjasama-invalid-feedback').remove();
            }
        })

        $("#perilaku").change(function () {
            let perilaku = document.getElementById('perilaku').value;
            if (!maximum.test(perilaku)) {
                $(this).addClass('is-invalid');
                $('.perilaku-invalid-feedback').text("Max 100!")
            } else {
                $(this).removeClass('is-invalid')
                $('.perilaku-invalid-feedback').remove()
            }
        })

        $("#type").change(function () {
            let type = document.getElementById('type').value;
            if (!maximum.test(type)) {
                $(this).addClass('is-invalid');
                $('.type-invalid-feedback').text("Max 100!");
            } else {
                $(this).removeClass('is-invalid')
                $('.type-invalid-feedback').remove();
            }
        })
    </script>
<?= $this->endSection() ?>