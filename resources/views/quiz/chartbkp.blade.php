@inject('block_model', 'App\Block')
@inject('group_model', 'App\Group')
@inject('qest_model', 'App\Question')
@inject('question_model', 'App\Question')
@inject('group_control', 'App\Http\Controllers\GroupController')
@inject('qest_control', 'App\Http\Controllers\QuestionController')
@inject('quiz_control', 'App\Http\Controllers\QuizController')

@php
	$blocks_quiz = $block_model::where('id_quiz', $quiz->id)->get();
	$groups = $group_control::get_own_and_included_groups(Auth::id());
	$blocks_quiz = $block_model::where('id_quiz', $quiz->id)->get();
	//--------------------------------------------------------

	$stack_choice = $quiz_control->count_data_multiple_choices($quiz->id);
	$stack_text = $quiz_control->count_data_text($quiz->id);

@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Highcharts Example - LaravelCode</title>

	<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<style>
@import 'https://code.highcharts.com/css/highcharts.css';

#container {
	height: 300px;
	width: 400px;
	margin: 0 auto;
}
</style>
</head>
   
<body>
	@foreach($stack_choice as $each) 
		@php
			$result = $quiz_control->make_data_for_choice($each);
			$totals = $result[0];
			$graph_key = $result[1];
			$question = $result[2];
			$opts = $result[3];
		@endphp
		<center>
			<div id="container-{{$graph_key}}" style="width:900px; margin-top: 30px; border:1px solid #CCCCCC;""></div>
		</center>
		<script type="text/javascript">

			var opts = <?php echo json_encode($opts); ?>;
			var question = "<?php echo $question; ?>";

			Highcharts.chart('container-{{$graph_key}}', {
				chart: {
					type: 'column',
				},
				title: {
					text: question
				},
				yAxis:{
					min: 0,
					title: {
						text: 'Total'
					}
				},
				xAxis: {
					categories: opts
				},
				series: [{
					data: {{$totals}},
					name: "Total",
					colorByPoint: true,
					showInLegend: false
				}]
		});

		</script>
	@endforeach

	@foreach($stack_text as $each) 
		@php
			$result = $quiz_control->make_data_for_text($each);
			$totals = $result[0];
			$graph_key = $result[1];
			$question = $result[2];
			$opts = $result[3];
		@endphp
		<center>
			<div id="container-{{$graph_key}}" style="width:900px; margin-top: 30px; border:1px solid #CCCCCC;"></div>
		</center>
		<script type="text/javascript">

			var opts = <?php echo json_encode($opts); ?>;
			var question = "<?php echo $question; ?>";

			Highcharts.chart('container-{{$graph_key}}', {
				chart: {
					type: 'column',
				},
				title: {
					text: question
				},
				yAxis:{
					min: 0,
					title: {
						text: 'Total'
					}
				},
				xAxis: {
					categories: opts
				},
				series: [{
					data: {{$totals}},
					name: "Total",
					colorByPoint: true,
					showInLegend: false
				}]
		});

		</script>
	@endforeach

</body>
  



</html>
