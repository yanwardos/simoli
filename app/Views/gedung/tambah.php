<div id="content" class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="row p-2">
                <div class="col-7 ">
                    <h2>
                        Data Gedung
                    </h2>
                </div>
                <div class="col-5">
                    <ul class="list-group list-group-horizontal float-right">
                        <a href="<?php base_url()?>/gedung" class="list-group-item p-2">
                            Kembali
                        </a>
                    </ul>
                </div>
            </div>
            <div class="card">
                <form action="<?php echo base_url().'/adged'?>" method="POST">
                    <div class="card-header p-1">Tambah Data Gedung</div>
                    <div class="card-body p-2 container">
                        <div class="row">
                            <div class="form-group col-lg-6 float-left">
                                <label for="nama" class="mr-sm-2 m-0">Nama Gedung</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary btn-md p-1 m-1 float-right">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>