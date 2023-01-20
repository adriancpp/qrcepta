
<div class="container" >
        <h5 class=""><?= $post->created_at; ?></h5>
        <p class="card-text"><?= $post->recommendation; ?></p>
        <a href="/DashboardController/detailsPrescription/<?= $post->id; ?>" class="btn">Details</a>
    <hr style="width:95%">
</div>
