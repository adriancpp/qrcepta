<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Prescription #<?= $prescription['id']; ?>  details</h3>
                <hr>
                <b>Recommendation:</b>
                <p>
                    <?= $prescription['recommendation']; ?>
                </p>
                <b>Medicines:</b>
                <p>
                    <?= $prescription['medicines']; ?>
                </p>
                <b>Status:</b>
                <p>
                    <?= $prescription['status']; ?>
                </p>
                <b>Security code:</b>
                <p>
                    <?= $prescription['security_code']; ?>
                </p>
            </div>
        </div>
    </div>
</div>