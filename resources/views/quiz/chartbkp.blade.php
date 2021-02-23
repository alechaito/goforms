@php
	$keys = json_encode($data[0]);
	$values = json_encode($data[1]);

	var_dump($key);
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Highcharts Example - LaravelCode</title>
</head>
   
<body>

<div id="container"></div>

</body>
  
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<style>
@import 'https://code.highcharts.com/css/highcharts.css';

#container {
	height: 400px;
	min-width: 300px;
	max-width: 800px;
	margin: 0 auto;
}
</style>

<script type="text/javascript">
    
   
	Highcharts.chart('container', {
		chart: {
    		type: 'column',
   	 		styledMode: true,
    		options3d: {
      			enabled: true,
      			alpha: 15,
      			beta: 15,
      			depth: 50
    		}
  		},
  		title: {
    		text: 'Visao Geral dos Avaliados'
  		},
		plotOptions: {
			column: {
				depth: 25
			}
		},
		yAxis:{
			title: {
				text: 'Total'
			}
		},
		xAxis: {
			categories: {{$keys}},
			title: {
				text: "{{$key}}"
			}
		},
  		series: [{
			data: {{$values}},
			name: "Contador",
			colorByPoint: true,
			showInLegend: false
  		}]
});

</script>

</html>