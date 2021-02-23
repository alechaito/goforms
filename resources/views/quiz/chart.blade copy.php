@inject('block_model', 'App\Block');
@inject('group_model', 'App\Group');
@inject('qest_model', 'App\Question');
@inject('question_model', 'App\Question');
@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$blocks_quiz = $block_model::where('id_quiz', $quiz->id)->get();
	$groups = $group_control::get_own_and_included_groups(Auth::id());

	$keys = json_encode($data[0]);
	$values = json_encode($data[1]);


	//--------------------------------------------------------
	$blocks_quiz = $block_model::where('id_quiz', $quiz->id)->get();
	$questions = array();

	$count_values = array();

	foreach($blocks_quiz as $block) {
		$question = DB::table('questions')->where('id_block', $block->id)->get();
		array_push($questions, $question);
	}

	foreach($questions as $question) {
		var_dump($question);
		break;
		/*if($question->type == 2) {
			$choices = DB::table('multiple_choices')
			->where('id_question', $question->id)
			->get();

			$exploded = explode(",", $choices);

			for ($i = 0; $i <= count($exploded); $i++) {
				$count = DB::table('evaluates')
				->where('question_id', $question->id)
				->where('question_response', $i)
				->count();

				array_push($count_values, array('id' => $question_id, 'option' => $i, 'total' => $count));
			}

			
		}*/
	}
	var_dump("--------------------");
	var_dump($questions);

@endphp

<html>
<head>
<link href="{{ URL::asset('/css/dashboard.css') }}" rel="stylesheet">
<script src="{{ URL::asset('/js/dashboard.js') }}"></script>

<!-- Data Table -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
@import 'https://code.highcharts.com/css/highcharts.css';

#container {
	height: 400px;
	min-width: 300px;
	max-width: 800px;
	margin: 0 auto;
}
</style>

</head>
<body>
<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color:#58B19F;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">GOForms</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="{{route('logout')}}">Logout</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" href="{{route('home')}}">
							Inicio
						</a>
					</li>
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<a data-toggle="collapse" href="#collapse-groups" aria-expanded="false" aria-controls="collapse-groups">
 						
							<span> <i class="fa fa-users"></i> Projetos </span>
						</a>
					</h6>
					<div class="collapse" id="collapse-groups">
						@foreach($groups as $group)
							<li class="nav-item">
								<a class="nav-link" style="font-size:15px;" href="{{ route('group.view.get', $group->id) }}">
									{{$group->name}}
								</a>
							</li>
						@endforeach
					</div>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<a data-toggle="collapse" href="#collapse-blocks" aria-expanded="false" aria-controls="collapse-blocks">
 							<span> <i class="fa fa-th-large"></i> Blocos</span>
						</a>
					</h6>
					<div class="collapse" id="collapse-blocks">
						@if($quiz->block_index != NULL)
							@php
								$indexes_block = explode(',', $quiz->block_index);
							@endphp
							@foreach($indexes_block as $index_block)
								@php
									$block = $block_model::find($index_block);
								@endphp
								<li class="nav-item">
									<a class="nav-link" href="{{ route('block.view.get', $block->id) }}">
										<span data-feather="home"></span>
										{{$block->name}}
									</a>
								</li>
							@endforeach
						@endif
					</div>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span><span><i class="fa fa-file"></i> {{$quiz->name}}</span>
					</h6>
					
					
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quiz.view.get', $quiz->id) }}">
							Blocos e Questoes
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quiz.export.get', $quiz->id) }}" >
							Exportar Avaliacoes
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quiz.edit.get', $quiz->id) }}">
							Editar
						</a>
					</li>

				</ul>
			</div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h2 class="h2">
					Grafico dos Pacientes Avaliados
					<a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
				</h2>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="{{ route('quiz.chart.get', [$quiz->id, 'idade']) }}" class="btn btn-secondary">
						Idade
					</a>
					<a href="{{ route('quiz.chart.get', [$quiz->id, 'sexo']) }}" class="btn btn-secondary">
						Sexo
					</a>
					<div id="container"></div>
				</div>
			</div>
			
			
		</main> <!-- END MAIN CONTENT-->
	</div> <!-- END ROW-->
</div>


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
		@if($key == 'sexo')
			xAxis: {
				categories: ['Masculino', 'Feminino'],
				title: {
					text: "sexo"
				}
			},
		@else
			xAxis: {
				categories: {{$keys}},
				title: {
					text: "{{$key}}"
				}
			},
		@endif
  		series: [{
			data: {{$values}},
			name: "Contador",
			colorByPoint: true,
			showInLegend: false
  		}]
});

</script>




</body>
</html>
