<div class="container-fluid">
	<div class="row p-2">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<canvas id="chart" class="w-100"></canvas>
			<hr>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12">
			<!--div class="row">
				<div class="col">
					<label for="id-gedung">Gedung</label>
					<select class="form-control" name="id-gedung" id="id-gedung">
						<?php
						foreach ($gedungs as $key => $value)
						{
							?>
							<option value="<?php echo $value['id_gedung']?>"><?php echo $value['nama_gedung']?></option>
							<?php
						} ?>
					</select>
					<hr>
					<label for="start-date">Start Date</label>
					<input class="form-control" type="date" name="start-date" id="start-date">
					<hr>
					<label for="end-date">End Date</label>
					<input class="form-control" type="date" name="end-date" id="end-date">
				</div>
				<div class="col">
					
				</div>
			</div-->
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
	var idGedung = document.getElementById('id-gedung');
	
	window.onload = function(){
		updateGrafik();
		update();

		
	}
	
	function update(){
		getData({
			"idSensors": [1, 2, 3],
			"start": "",
			"end": ""
		}, function(data){
			
			data = data[0]
			idSensors = [data.idSensor]
			namaSensors = [data.namaSensor]
			arus = data.data

			xLabel = new Array()
			arusSet = new Array()
			
			data.data.forEach(element => {
				xLabel.push(element.waktu_rekord)
				arusSet.push(element.arus)
			});

			dataSet = []
			dataSet.push({
				"label": namaSensors[0],
				"backgroundColor": 'rgb(255, 99, 132)',
				"borderColor": 'rgb(255, 99, 132)',
				"data": arusSet
			})

			updateGrafik(xLabel, dataSet)
		})
	}


	function updateGrafik(xLabel=[], dataSet=[{
		"label": "",
		"backgroundColor": 'rgb(255, 99, 132)',
		"borderColor": 'rgb(255, 99, 132)',
		"data": "kwhs"
	}]){
		console.log(dataSet)
		var ctx = document.getElementById('chart').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: xLabel,
				datasets: dataSet
			},

			// Configuration options go here
			options: {}
		});
	}

	/*
	Request format
		localhost:8000/datamonitoring?data={"idSensors":[1],"start":"2020-09-22", "end":"2020-09-23"}
	*/

	function getData(data={
		"idSensors": [],
		"start": "",
		"end":""
	}, onSucces=function(){}){
		$.ajax({
			type  : 'GET',
			url   : '<?php base_url()?>/datamonitoring',
			data: {
				data: JSON.stringify(data)
			},
			async : true,
			dataType : 'json',
			success : function(data){
				onSucces(data);
			}
		});
		return true;
	}
</script>