@inject('block_model', 'App\Block');
@inject('question_model', 'App\Question');
@inject('quiz_model', 'App\Quiz');
@inject('quiz_control', 'App\Http\Controllers\QuizController')
@inject('QuestionController', 'App\Http\Controllers\QuestionController')

@php
	$indexes_block = explode(',', $quiz->block_index);

	//$questions_from_block = $question_model::where('id_block', $block->id)->get()->pluck('id');
	//$questions = $question_model::where('id_block', $block->id)->get();
	
	$index = 1;		
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

<!-- Awesomplete -->
<script src="{{ asset('js/awesomplete.js') }}"></script> 
<link href="{{ asset('css/awesomplete.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color:#58B19F;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CIF Easy</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Logout</a>
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
							<span data-feather="home"></span>
							Inicio
						</a>
					</li>
				</ul>
				
			</div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">
					Pre-Visualizacao - {{$quiz->name}}
				</h1>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Navegacao Blocos </h5>
							<p class="card-text">
								<div class="row">
									<div class="col-md-12" style="margin-bottom: 5px;">
										<ul class="nav">
											@foreach($blocks as $block)
												<li class="nav-item" style="padding:5px;">
													<a href="#move-{{$block->id}}" class="btn btn-secondary">
														{{$block->name}}
													</a>
												</li>
											@endforeach
										</ul>
									</div>
								</div>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					
				</div>
			</div>
			</br>
			@php
				$az = range('A', 'Z');
				$index_az = 0;
			@endphp
			@foreach($blocks as $block)
				@if($block != NULL)
					@php
						$indexes_question = explode(',', $block->question_index);
					@endphp
					<div id="move-{{$block->id}}" class="row">
						<div class="col-md-12">
							
							@foreach($indexes_question as $index_question)
								@php
									$question = DB::table('questions')->where('id', $index_question)->first();
									$index_qest = 1;
								@endphp

								<div style="margin-top:15px;" class="card">
									<div class="card-header">
										Questao {{$az[$index_az]}}{{$index_qest}} - {{$block->name ?? ''}}	
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-8">
												{{ $question->question ?? '' }}
											</div>
											<div class="col-md-4">
												@if($question != Null)
													@if($question->type == 1)
														<input id="{{$question->id}}" type="text" class="form-control" placeholder="Escreva sua resposta...">
														(somente letras permitidas)
													@elseif($question->type == 2)
														@php
															$choices = $QuestionController->question_choices($question->id);
														@endphp
														Selecione uma alternativa:
														<ul style="list-style-type:none;">
															@php
																$ch = 0;
															@endphp
															@foreach($choices as $choice)
																@if($choice != "")
																	<li>
																		<input id="{{$question->id}}" value="{{$ch}}" class="option" type="radio" name="choice-{{$question->id}}"> {{$choice}}
																	</li>
																	@php
																		$ch += 1;
																	@endphp
																@endif
															@endforeach
														</ul>
													@elseif($question->type == 3)
														<input id="{{$question->id}}" type="number" class="form-control" placeholder="Escreva sua resposta...">
														(somente numeros permitidos)
													@elseif($question->type == 4)
														Selecione uma alternativa:
													
														<div class="form-check">
															<input id="{{$question->id}}" class="option" type="radio" name="confirm-{{$question->id}}"  value="0">
															<label class="form-check-label">
																Sim
															</label>
														</div>
														<div class="form-check">
															<input id="{{$question->id}}" class="option" type="radio" name="confirm-{{$question->id}}" value="1">
															<label class="form-check-label">
																Nao
															</label>
														</div>
													@endif
												@endif

											</div>
										</div> <!--FIM ROW-->
									</div> <!--FIM CARD BODY-->
									<div class="card-footer text-muted">
									</div>
								</div>
								@php
									$index_qest += 1
								@endphp
							@endforeach
							@php
								$index_az += 1
							@endphp
						</div>
						</br>
					</div>
				@endif
			@endforeach
			</br>
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="" class="btn btn-primary">
						Finalizar
					</a>
				</div>
			</div>
			</br>
		</main>
	
  	</div>
</div>


</body>


</html>
