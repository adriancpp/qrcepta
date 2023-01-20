<script src="/assets/FileSaver.js"></script>
<script>

    function saveStaticDataToFile() {
        <?php
            $dataToSave = '"';
        if (isset($newPassword))
            $dataToSave.= '\nPassword: '.$newPassword;
        if (isset($securityCode))
            $dataToSave.= '\nSecure Code: '.$securityCode;

        $dataToSave.='"';
        ?>

        var blob = new Blob([<?= $dataToSave ?>],
            { type: "text/plain;charset=utf-8" });
        saveAs(blob, "static.txt");
    }

</script>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Create Prescription</h3>
                <hr>
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                    <?php if (isset($newPassword)): ?>
                        <div class="alert alert-info" role="alert">
                            New patient password: <?= $newPassword ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($securityCode)): ?>
                        <div class="alert alert-info" role="alert">
                            Security Code: <?= $securityCode ?>
                        </div>
                    <?php endif; ?>
                    <button type="button" onclick="saveStaticDataToFile();" style="margin-bottom: 20px;">Print</button>

                <?php endif; ?>
                <form class="" action="/DashboardController/createPrescription" method="post">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="pesel">Pesel</label>
                                <input type="text" class="form-control" name="pesel" id="pesel" value="<?= (isset($pesel)? $pesel : '') ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" value="<?= (isset($firstname)? $firstname : '') ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" value="<?= (isset($lastname)? $lastname : '') ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="text" class="form-control" name="email" id="email" value="<?= (isset($email)? $email : '') ?>">
                            </div>
                        </div>

                        <div class="col-12 row-3">
                            <div class="form-group">
                                <label for="recommendation">Recommendation</label>
                                <textarea type="text" class="form-control" name="recommendation" id="recommendation"></textarea>
                            </div>
                        </div>
                        <div class="col-12 row-3">
                            <div class="form-group">
                                <label for="medicines">Medicines</label>
                                <textarea type="text" class="form-control" name="medicines" id="medicines"></textarea>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($validation)): ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>