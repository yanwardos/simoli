<div class="container-fluid">
	<div class="row p-2">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<canvas id="chart" class="w-100"></canvas>
			<hr>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12">
			<!--div class="row">
				<div class="col">
					<label for="resolusi">Resolusi</label>
					<select class="form-control" name="resolusi" id="resolusi">
						<option value="1">1 Jam</option>
						<option value="2">6 Jam</option>
						<option value="3">12 Jam</option>
					</select>
					<label for="id-sensor">Sensor</label>
					<hr>
					<select class="form-control" name="id-sensor" id="id-sensor">
						<?php
						foreach ($sensors as $key => $value)
						{
							?>
							<option value="<?php echo $value['id_sensor']?>"><?php echo $value['nama_sensor']?></option>
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
	var startDate = document.getElementById('start-date');
	var endDate = document.getElementById('end-date');
	var idSensor = document.getElementById('id-sensor');
	var resolusi = document.getElementById('resolusi');
	var sensorCount = <?php //print_r($sensors) ?>


	$('.form-control').change(function(){
		if(startDate.value!="" && endDate.value!="") updateGrafik(startDate.value, endDate.value);
	})

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
		}, function(datas){
			dataSet = []

			for(i=0; i<datas.length; i++){
				data = datas[i]
				idSensors = [data.idSensor]
				namaSensors = [data.namaSensor]
				arus = data.data

				xLabel = new Array()
				arusSet = new Array()
				
				data.data.forEach(element => {
					xLabel.push(element.waktu_rekord)
					arusSet.push(element.arus)
				});

				
				dataSet.push({
					"label": namaSensors[0],
					// "backgroundColor": 'rgb(255, 99, 132)',
					"borderColor": 'rgb(255, 99, 132)',
					"data": arusSet
				})	
			}

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

	function dateAddMinutes(oldDate, minutes){
		newDate = new Date(oldDate.getTime() + 60000*minutes); 
		return newDate;
	}

	function getSensor(sensor=false, onSuccess=function(){}){
		$.ajax({
			type  : 'GET',
			url   : '<?php base_url()?>/sensor/all',
			async : true,
			dataType : 'json',
			success : function(data){
				onSuccess(data);
			}
		})
	}
</script>