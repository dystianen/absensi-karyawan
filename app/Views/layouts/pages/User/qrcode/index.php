<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>

<section class="d-flex flex-column align-items-center text-center">
    <span class="mb-5" style="color: gray">Please scan this QR Code for today!</span>

    <?php if ($qrToday === null) : ?>
        <div class="card card-success d-flex align-items-center p-5 w-100">
            <span><i class="bi bi-info" style="font-size: 50px; color: blue"></i></span>
            <h5 class="text-center">Waiting for admin to generate QR Code today!</h5>
        </div>
    <?php else :  ?>
        <img style="width: 15rem;" src="<?= base_url($qrToday) ?>">
    <?php endif; ?>
</section>

<?= $this->endSection() ?>