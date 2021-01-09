<!DOCTYPE html>
<html>
	<head>
		<link rel="manifest" href="{{ route('manifest') }}">

		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="msapplication-starturl" content="/">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="theme-color" content="#e5e5e5">  
		 
		<title>Page Title</title>

		<!-- Data Table -->
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> 
		<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> 
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

		<link href="{{ URL::asset('/css/dashboard.css') }}" rel="stylesheet">
		<script src="{{ URL::asset('/js/dashboard.js') }}"></script>
		

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
						<a class="nav-link" href="./index.html">
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
					Questionario - {{$quiz->name}}
					<a href="{{ route('group.preview.view', [$quiz->id_group, 'quizzes']) }}" class="btn btn-secondary">Voltar</a>
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
											@foreach($indexes_block as $index_block)
												@php
													//$block = $block_model::find($index_block);
												@endphp
												<li class="nav-item" style="padding:5px;">
													<a href="#move-{{$block->id}}">
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
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Paciente Cadastrado - Dados</h5>
							<p class="card-text">
								<div class="row">
									<div class="col-md-12" style="margin-bottom: 5px;">
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-patient">
											Selecionar Paciente
										</button>
										<a class="btn btn-secondary">Novo Paciente</a>
									</div>			
								</div>
							</p>
						</div>
					</div>
				</div>
			</div>
			</br>
			@php
				$az = range('A', 'Z');
				$index_az = 0;
			@endphp
			@foreach($indexes_block as $index_block)
					@php
						$block = $block_model::find($index_block);
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
			@endforeach
			</br>
			<div class="row">
				<div class="col-md-12 text-right">
						<a id="send" class="btn btn-primary">
							Finalizar
						</a>
				</div>
			</div>
			
		</main>
	
  	</div>
</div>

<!-- Modal Display Users to Include -->
<div class="modal fade" id="modal-patient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Incluir Usuario</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<table id="display-patients-include" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th width="50%">Nome</th>
								<th>Adicionar</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
		</div>
	</div>
	</div>
</div>

</body>

<script>

	$(document).ready(function() {
		var table = $('#display-patients-include').DataTable( {
			"ajax": "http://localhost:8000/search-patients",
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json",
				"search": 'a',
				"searchPlaceholder": "Digite uma palavra chave..."
			},
			"dom": "<'row'<'col-md-9'f><'col-md-3'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
		});
	});




	//checking if have connection and sincronizing
	if(navigator.onLine) {
		console.log("Internet connection...");
		var index = localStorage.getItem("index");
		for(i=0; i < index; i++) {
			var item = localStorage.getItem(i);
			console.log(item);
		}
	}
	
	$('#send').click(function () {   
		let new_obj = { 'id_quiz': 3, 'id_patient': 3, 'data': [] };

		//Getting all inputs type radio
		let input_options = $("input:radio:checked");
		for(i=0; i<input_options.length; i++) {
			var input = input_options[i];
			new_obj.data.push({'id_question':input.id, 'value':input.value});
		}

		//Getting all inputs type numbers
		let input_numbers = document.querySelectorAll('input[type=number]');
		for(i=0; i<input_numbers.length; i++) {
			var input = input_numbers[i];
			new_obj.data.push({'id_question':input.id, 'value':input.value});
		}

		//Getting all inputs type text
		let input_text = $("input:text");
		for(i=0; i<input_text.length; i++) {
			var input = input_text[i];
			new_obj.data.push({'id_question':input.id, 'value':input.value});
		}

		console.log(new_obj.data);
		//maintence index
		var index = localStorage.getItem("index");
		if(index == 0 || index == null) {
			localStorage.setItem("0", JSON.stringify(new_obj));
			localStorage.setItem("index", 1);
		}
		else {
			localStorage.setItem(parseInt(index), JSON.stringify(new_obj));
			localStorage.setItem("index", parseInt(index) + 1);
		}
		console.log(index);
	});


</script>

</html>
