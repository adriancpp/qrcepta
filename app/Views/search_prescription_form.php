<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Prescription list</h3>
                <hr>
                <form class="" action="/DashboardController/searchPrescription" method="post">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="pesel">Pesel</label>
                                <input type="text" class="form-control" name="pesel" id="pesel" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">Search prescription by pesel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if(count($posts)>0): ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 mt-5 pt-3 pb-3 bg-white ">

            <div class="col-12">
                <?php foreach ($posts as $post) : ?>

                    <?= view_cell('\App\Libraries\Prescription::postItem', ['post' => $post]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>