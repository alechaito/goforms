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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
						<a class="nav-link" href="{{ route('home') }}">
							<span data-feather="home"></span>
							Inicio
						</a>
					</li>
				</ul>
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Avaliando Paciente</h1>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h6>Informacoes do Paciente</h6>
					<table>
						<tr>
							<td>
								Nome: {{$patient->name}}	
							</td>
						</tr>
						<tr>
							<td>
								Idade: {{$patient->age}}
							</td>
						</tr>
						<tr>
							<td>
								Sexo: {{$patient->sex}}
							</td>
						</tr>
					</table>
				</div>
			</div>
			<hr>
			<form method="POST" action="{{ route('patient.evaluate.post') }}">
				@csrf
				<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
				<input type="hidden" name="id_patient" value="{{$patient->id}}"/>
				<div class="row">
					<div class="col-md-12">

						@foreach($indexes_block as $idx_block)
							@php
								$block = $block_model::Find($idx_block);
							@endphp
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

											<div class="card mt-3 mb-3">
												<div class="card-header">
													{{$block->name ?? ''}}	
												</div>
												<div class="card-body">
													<div class="row">
														<div class="col-md-8">
															{{ $question->question ?? '' }}
														</div>
														<div class="col-md-4">
															@if($question != Null)
																@if($question->type == 1)
																	<input name="{{$question->id}}" type="text" class="form-control" placeholder="Escreva sua resposta...">
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
																					<input name="{{$question->id}}" value="{{$ch}}" class="option" type="radio" name="choice-{{$question->id}}"> {{$choice}}
																				</li>
																				@php
																					$ch += 1;
																				@endphp
																			@endif
																		@endforeach
																	</ul>
																@elseif($question->type == 3)
																	<input name="{{$question->id}}" type="number" class="form-control" placeholder="Escreva sua resposta...">
																	(somente numeros permitidos)
																@elseif($question->type == 4)
																	Selecione uma alternativa:
																
																	<div class="form-check">
																		<input class="option" type="radio" name="{{$question->id}}"  value="0">
																		<label class="form-check-label">
																			Sim
																		</label>
																	</div>
																	<div class="form-check">
																		<input class="option" type="radio" name="{{$question->id}}" value="1">
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

										@endforeach	
									</div>
								</div>
							@endif
						@endforeach


					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-secondary float-right mt-3 mb-3">
							Finalizar
						</button>
					</div>
				</div>
			</form>



		</div>
		
		

    </main>
  </div>
</div>
</body>
</html>
