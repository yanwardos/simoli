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
                        <a href="<?php base_url()?>/tambahgedung" class="list-group-item p-2">
                            Tambah Gedung
                        </a>
                    </ul>
                </div>
            </div>
            <table class="table table-striped table-dark table-borderless table-hover table-sm p-1 ">
                <thead>
                    <tr class="d-flex">
                        <th scope="col" class="col-2">
                            Id Gedung
                        </th>
                        <th scope="col" class="col-6">
                            Nama Gedung
                        </th>
                        <th scope="col" class="col-4">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gedungs as $gedung) {?>
                    <tr class="d-flex">
                        <th scope="row" class="col-2">
                            <?php echo $gedung['id_gedung'];?>
                        </th>
                        <td class="col-6">
                            <?php echo $gedung['nama_gedung'];?>
                        </td>
                        <td class="col-4">
                            <button class="btn btn-dark btn-sm p-1 m-1">Edit</button>
                            <button class="btn btn-dark btn-sm p-1 m-1">Hapus</button>
                            <a href="#" class="btn btn-dark btn-sm p-1 m-1">Cek data</a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">
                            Data
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>