<div id="content" class="container">
	<div class="row">
		<div class="col-lg-8 col-md-10 col-sm-12">
			<div class="row p-2">
				<div class="col-7 ">
					<h2>
						Data Sensor
					</h2>
				</div>
				<div class="col-5">
					<ul class="list-group list-group-horizontal float-right">
						<a href="<?php base_url()?>/tambahsensor" class="list-group-item p-2">
							Tambah Sensor
						</a>
					</ul>
				</div>
			</div>
			<table class="table table-striped table-dark table-borderless table-hover table-sm p-1 ">
				<thead>
					<tr class="d-flex">
						<th scope="col" class="col-1">
							Id Sensor
						</th>
						<th scope="col" class="col-5">
							Nama Sensor
						</th>
						<th scope="col" class="col-2">
							Gedung
						</th>
						<th scope="col" class="col-4">
							Aksi
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($sensors as $sensor)
					{
						?>
					<tr class="d-flex">
						<th scope="row" class="col-1">
							<?php echo $sensor['id_sensor'];?>
						</th>
						<td class="col-5">
							<?php echo $sensor['nama_sensor'];?>
						</td>
						<td class="col-2">
							<?php echo $sensor['id_gedung'];?>
						</td>
						<td class="col-4">
							<a href="<?php base_url() ?>/sensordet?id_sensor=<?php echo $sensor['id_sensor']?>" class="btn btn-dark btn-sm p-1 m-1">Cek data</a>
						</td>
					</tr>
						<?php
					} ?>
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