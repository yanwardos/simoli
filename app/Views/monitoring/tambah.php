<div id="content" class="container">
    <div class="row">
        <div class="col-md-10 p-2">
            <div class="row p-2">
                <div class="col-7 ">
                    <h2>
                        Data Monitoring
                    </h2>
                </div>
                <div class="col-5">
                    <ul class="list-group list-group-horizontal float-right">
                        <a href="<?php base_url()?>/monitoring" class="list-group-item p-2">
                            Kembali
                        </a>
                    </ul>
                </div>
            </div>

            <div class="card col-lg-12 col-md-8 col-sm-12 p-1 container">
                <form action="<?php echo base_url().'/admon'?>" method="POST">
                    <div class="card-header p-1">Tambah Data</div>
                    <div class="card-body p-2 container">
                        <div class="row">
                            <div class="form-group col-lg-6 float-left">
                                <label for="gedung" class="mr-sm-2 m-0">Gedung</label>
                                <select name="gedung" id="gedung" class="custom-select mr-sm-2">
                                    <option selected value="-1">Pilih Gedung ...</option>
                                    <?php foreach ($gedungs as $item ) { ?>
                                        <option value="<?php echo $item['id_gedung']?>"><?php echo $item['nama_gedung']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <div class="row">
                                    <div class="col">
                                        <label for="waktu-tanggal">Tanggal</label>
                                        <input type="date" name="waktu-tanggal" id="waktu-tanggal" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="waktu-jam" class="">Jam</label>
                                        <input type="time" name="waktu-jam" id="waktu-jam" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <label for="tegangan" class="mr-sm-2 m-0">Tegangan</label>
                                <input type="number" name="tegangan" id="tegangan" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <label for="kwh" class="mr-sm-2 m-0">KwH</label>
                                <input type="number" name="kwh" id="kwh" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <label for="arus" class="mr-sm-2 m-0">Arus</label>
                                <input type="number" name="arus" id="arus" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <label for="frekuensi" class="mr-sm-2 m-0">Frekuensi</label>
                                <input type="number" name="frekuensi" id="frekuensi" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <label for="daya_aktif" class="mr-sm-2 m-0">Daya Aktif</label>
                                <input type="number" name="daya_aktif" id="daya_aktif" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 float-left">
                                <label for="daya_tampak" class="mr-sm-2 m-0">Daya Tampak</label>
                                <input type="number" name="daya_tampak" id="daya_tampak" class="form-control">
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