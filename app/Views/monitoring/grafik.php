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

	function updateGrafik(startDate=false, endDate=false){

		getSensor(false, function(sensors){
			sensorsData = new Array();
			sensors.forEach(sensor=>{
				idSensor = sensor.id_sensor;
				sensorData = [];
				getData(idSensor, startDate, endDate, function(data){
					data.forEach(element => {
						sensorData.push({
							jam: element.waktu_rekord,
							arus: element.arus
						});
					});
				});
				sensorsData.push({
					namaSensor: sensor.nama_sensor,
					data: sensorData
				});
			});

			window.sensorsData = sensorsData;

			// Data preparation
			start = new Date(startDate + " 00:00:01");
			end = new Date(endDate + " 23:59:59");

			var resolution;
			switch(resolusi.value){
				case "1":
					resolution = 60;
				break;
				case "2":
					resolution = 360;
				break;
				case "3":
					resolution = 720;
				break;
			}

			setTimeout(function(){
				// Label
				labels = Array();
				times = Array();
				dateLabel = start;
				labels.push(dateLabel.getFullYear()+"-"+dateLabel.getMonth()+"-"+dateLabel.getDate()+" "+dateLabel.getHours()+":"+dateLabel.getMinutes());
				times.push(dateLabel);
				do{
					dateLabel = dateAddMinutes(dateLabel, resolution);
					labels.push(dateLabel.getFullYear()+"-"+dateLabel.getMonth()+"-"+dateLabel.getDate()+" "+dateLabel.getHours()+":"+dateLabel.getMinutes());
					times.push(dateLabel);
				}while(dateLabel.getTime()<end.getTime());

				// Datasets
				myDatasets = Array();
				window.sensorsData.forEach(element=>{
					arusSensors = element.data;
					arus = Array();

					if(arusSensors.length>0){
						times.forEach(element=>{
							var i = 0;
							var tmp;
							batasBawah = element;

							jamArus = new Date(arusSensors[i].jam);
							// console.log(arusSensors[i])
							while(jamArus.getTime()<=element.getTime()){
								tmp=arusSensors[i].arus;
								i++;
								jamArus = new Date(arusSensors[i]);
							}
							arus.push(tmp);
						})
					}
					

					myDatasets.push({
						label: element.namaSensor,
						data: arus,
						borderColor: 'rgb(255, 99, '+(Math.round(Math.random()*1000))%254 +')',

					})
				})
				
				window.myd = myDatasets;

				var ctx = document.getElementById('chart').getContext('2d');
				var chart = new Chart(ctx, {
					// The type of chart we want to create
					type: 'line',

					// The data for our dataset
					data: {
						labels: labels,
						datasets: myDatasets
					},

					// Configuration options go here
					options: {}
				});
			}, 1000)
			
		})
	}


	function getData(idSensor, startDate, endDate, onSucces){
		$.ajax({
			type  : 'GET',
			url   : '<?php base_url()?>/datamonitoring',
			data:{
				idSensor: idSensor,
				startDate: startDate,
				endDate: endDate
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