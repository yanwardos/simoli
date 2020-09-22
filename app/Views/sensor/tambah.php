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
						<a href="<?php base_url()?>/sensor" class="list-group-item p-2">
							Kembali
						</a>
					</ul>
				</div>
			</div>
			<div class="card">
				<form action="<?php echo base_url() . '/adsen'?>" method="POST">
					<div class="card-header p-1">Tambah Data Sensor</div>
					<div class="card-body p-2 container">
						<div class="row">
							<div class="form-group col-lg-6 float-left">
								<label for="nama" class="mr-sm-2 m-0">Nama Sensor</label>
								<input type="text" name="nama" id="nama" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 float-left">
								<label for="gedung" class="mr-sm-2 m-0">Gedung</label>
								<select name="id_gedung" id="gedung" class="custom-select mr-sm-2">
									<option selected value="-1">Pilih Gedung</option>
									<?php
									foreach ($gedungs as $item)
									{
										?>
										<option value="<?php echo $item['id_gedung']?>"><?php echo $item['nama_gedung']?></option>
										<?php
									}?>
								</select>
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