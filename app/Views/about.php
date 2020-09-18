<div id="content" class="container-fluid">
    <div class="row my-2">
        <div class="col-lg-1 col-md-0 col-sm-0 p-0 w-0"></div>
        <?php foreach ($data as $item) { ?>
            <div class="col-lg-2 col-md-6 col-sm-4 p-1">
                <div class="card m-1 p-1 m-1">
                    <div class="card-body p-2">
                        <img src="assets/img/avatar/<?php echo $item['img']?>" alt="" class="img-fluid img-thumbnail rounded mx-auto d-block w-100" style="max-height: 150px; object-fit:cover">
                        <h6 class="text-center pt-3"><?php echo $item['nama']?></h6>
                        <p class="text-justify" style="max-height: 200px; overflow:scroll;" >
                            <?php echo $item['keterangan']?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-lg-1 col-md-0 col-sm-0"></div>
    </div>
</div>