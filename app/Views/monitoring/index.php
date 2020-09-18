<div id="content" class="container">
    <div class="row">
        
        <div class="col-md-10">

            <div class="row p-2">
                <div class="col-7 ">
                    <h2>
                        Data Monitoring
                    </h2>
                </div>
                <div class="col-5">
                    <ul class="list-group list-group-horizontal float-right">
                        <a href="<?php base_url()?>/tambahrekord" class="list-group-item p-2">
                            Tambah Data
                        </a>
                    </ul>
                </div>
            </div>
            <table class="table table-striped table-dark table-borderless table-hover table-sm p-1 col-lg-75 col-md-">
                <thead>
                    <tr class="">
                        <th scope="col" class="">
                            Id Rekord
                        </th>
                        <th scope="col">
                            Waktu Rekord
                        </th>
                        <th scope="col">
                            Gedung
                        </th>
                        <th scope="col">
                            Tegangan
                        </th>
                        <th scope="col">
                            KWh
                        </th>
                        <th scope="col">
                            Arus
                        </th>
                        <th scope="col">
                            Frekuensi
                        </th>
                        <th scope="col">
                            Daya Aktif
                        </th>
                        <th scope="col">
                            Daya Tampak
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monitorings as $data) {?>
                    <tr class="">
                        <th scope="row">
                            <?php echo $data['id_rekord']?>
                        </th>
                        <td>
                            <?php echo $data['waktu_rekord']?>
                            </td>
                            <td>
                            <?php echo $data['id_gedung']?>
                            </td>
                            <td>
                            <?php echo $data['tegangan']?>
                            </td>
                            <td>
                            <?php echo $data['kwh']?>
                            </td>
                            <td>
                            <?php echo $data['arus']?>
                            </td>
                            <td>
                            <?php echo $data['frekuensi']?>
                            </td>
                            <td>
                            <?php echo $data['daya_aktif']?>
                            </td>
                            <td>
                            <?php echo $data['daya_tampak']?>
                            </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">
                            <div>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            
        </div>
    </div>
</div>