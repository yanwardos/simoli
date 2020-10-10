<div class="container-fluid">
	<div class="row p-2">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<canvas id="chart" class="w-100"></canvas>
			<hr>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12">
			<div class="row">
				<div class="col">
					<label for="resolusi">Resolusi</label>
					<select class="form-control" name="resolusi" id="resolusi">
						<option value="1" resolusi='3600'>1 Jam</option>
						<option value="2" resolusi='21600'>6 Jam</option>
						<option value="3" resolusi='43200'>12 Jam</option>
					</select>
					<!--label for="id-sensor">Sensor</label>
					<hr>
					<select class="form-control" name="id-sensor" id="id-sensor">
						<?php
						foreach ($sensors as $key => $value)
						{
							?>
							<option value="<?php echo $value['id_sensor']?>"><?php echo $value['nama_sensor']?></option>
							<?php
						} ?>
					</select-->
					<hr>
					<label for="start-date">Start Date</label>
					<input class="form-control" type="date" name="start-date" id="start-date">
					<hr>
					<label for="end-date">End Date</label>
					<input class="form-control" type="date" name="end-date" id="end-date">
				</div>
				<div class="col">
					
				</div>
			</div>
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
		resolusi = $('#resolusi').val()
		switch(resolusi){
			case 1:
				resolusi = 3600
			break;
			case 2:
				resolusi = 21600
			break;
			case 3:
				resolusi = 43200
			break;
		}
		if(startDate.value!="" && endDate.value!="") update({
			resolusi: resolusi
		})
	})

	window.onload = function(){
		update()
	}
	
	function update(payload = {
		resolusi: 30
	}){
		getSensor(false, (sensors)=>{
			sensors_ = []
			sensors.forEach(element => {
				sensors_.push(element.id_sensor)
			});

			getData({
				"idSensors": sensors_,
				"start": "",
				"end":""
			}, (datas)=>{
				startDate = new Date()
				endDate = new Date()


				dataSet = []
				datas.forEach(element => {
					dataArus = []
					element.data.forEach(element=>{
						time = new Date(element.waktu_rekord)
						if(time>endDate) endDate = time
						if(time<startDate) startDate = time

						dataArus.push({
							x: formatDate(time),
							y: element.arus
						})
					})

					dataSet.push({
						"label": element.namaSensor,
						//"backgroundColor": 'rgb(0, 0, 132)',
						"borderColor": 'rgb('+ random() +', '+ random() +', '+ random() +')',
						"data": dataArus
					})
				})

				xLabel = []
				date = startDate
				while(date<endDate){
					xLabel.push(formatDate(date))
					date = dateAddSecond(date, payload.resolusi)
				}

				updateGrafik(xLabel, dataSet)
			})
		})
	}


	function updateGrafik(xLabel=[], dataSet=[{
		"label": "",
		"backgroundColor": 'rgb(255, 99, 132)',
		"borderColor": 'rgb(255, 99, 132)',
		"data": "kwhs"
	}]){
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

	function dateAddSecond(oldDate, seconds){
		newDate = new Date(oldDate.getTime() + 1000*seconds); 
		return newDate;
	}

	function formatDate(date){
		return date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()
	}

	function random(){
		return Math.round(Math.random()*1000) % 255
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