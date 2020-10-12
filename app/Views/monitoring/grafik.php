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
						<option value="1" resolusi='3600'>30 Detik</option>
						<option value="2" resolusi='21600'>6 Jam</option>
						<option value="3" resolusi='43200'>12 Jam</option>
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
		resolusi = parseInt(resolusi)
		switch(resolusi){
			case 1:
				resolusi = 30
			break;
			case 2:
				resolusi = 60*60*6
			break;
			case 3:
				resolusi = 60*60*12
			break;
		}

		strDate = $('#start-date').val()
		edDate = $('#end-date').val()
		if(startDate.value!="" && endDate.value!="") update({
			resolusi: resolusi,
			sDate: strDate,
			eDate: edDate
		})
	})

	window.onload = function(){
		update()
	}
	
	function update(payload = {
		resolusi: 30,
		sDate: "",
		eDate: ""
	}){
		getSensor(<?php 
		if(isset($sensors)){
			echo json_encode($sensors);
		}else{
			echo "false";
		}?>, (sensors)=>{
			sensors_ = []
			sensors.forEach(element => {
				sensors_.push(element.id_sensor)
			});

			getData({
				"idSensors": sensors_,
				"start": payload.sDate,
				"end": payload.eDate
			}, (datas)=>{
				startDate = false
				endDate = false

				dataSet = []
				datas.forEach(element => {
					dataArus = []
					timeIndv = false
					endTimeIndv = false
					sensorElm = element
					element.data.forEach(element=>{
						time = new Date(element.waktu_rekord)
						if(timeIndv==false && endTimeIndv==false){
							timeIndv = time
							endTimeIndv = new Date(sensorElm.data.length-1)
						}
						if(startDate==false && endDate==false){
							startDate=time
							endDate=time
						}
						if(time>endDate) endDate = time
						if(time<startDate) startDate = time

						do{
							dataArus.push({
								x: formatDate(time),
								y: element.arus
							})
							timeIndv = dateAddSecond(timeIndv, resolusi)
						}while(timeIndv<=endTimeIndv)
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
				do{
					xLabel.push(formatDate(date))
					date = dateAddSecond(date, resolusi)
				}while(date<=endDate)

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
			data: {
				sensor: sensor
			},
			async : true,
			dataType : 'json',
			success : function(data){
				onSuccess(data);
			}
		})
	}
</script>