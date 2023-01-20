<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Prescription list</h3>
                <hr>
                <form class="" action="/DashboardController/prescriptionRead" method="post">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="security_code">Security code</label>
                                <input type="text" class="form-control" name="security_code" id="security_code" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">Search prescription by code</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if(isset($prescription)): ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 mt-5 pt-3 pb-3 bg-white ">
            <div class="col-12">
                <div class="container">
                    <h3>Prescription #<?= $prescription->id; ?>  details</h3>
                    <hr>
                    <b>Recommendation:</b>
                    <p>
                        <?= $prescription->recommendation; ?>
                    </p>
                    <b>Medicines:</b>
                    <p>
                        <?= $prescription->medicines; ?>
                    </p>
                    <b>Status:</b>
                    <p>
                        <?= $prescription->status; ?>
                    </p>
                    <form class="" action="/DashboardController/prescriptionRead" method="post">
                        <input type="hidden" name="status" id="status" value="1">
                        <input type="hidden" name="security_code" id="security_code" value="<?= $prescription->security_code; ?>">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <button type="submit" class="btn btn-primary">Completed</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>