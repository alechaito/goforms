@inject('block_model', 'App\Block');
@inject('group_model', 'App\Group');
@inject('question_model', 'App\Question');
@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$blocks_quiz = $block_model::where('id_quiz', $quiz->id)->get();
	$groups = $group_control::groups_user(Auth::id());
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color:#58B19F;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CIF Easy</a>
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
								<a class="nav-link" style="font-size:15px;" href="{{ route('group.preview.view', [$group->id, 'quizzes']) }}">
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
									<a class="nav-link" href="{{ route('block.edit.view', $block->id) }}">
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
						<a class="nav-link" href="#e" onclick="activaTab('e')" data-toggle="tab">
							Gerar Relatorio
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
					{{$quiz->name}}
					<a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
				</h2>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					@if(session()->has('success'))
						<div class="alert alert-success">
							{{ session()->get('success') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
					<div class="alert alert-primary" role="alert">
						Este questionario possui um total de {{sizeof($blocks_quiz)}} blocos.
					</div>
				</div>
				<div class="col-md-6 text-right">
					<a href="{{route('quiz.preview', $quiz->id)}}">
						<button type="submit" class="btn btn-secondary">Pre-Visualizar</button>
					</a>
					<a href="#" data-toggle="modal" data-target="#modal-create-block">
						<button type="submit" class="btn btn-secondary">Adicionar Bloco</button>
					</a>
				</div>
			</div>
			</br>
			
			@if($quiz->block_index != NULL)
				@php
					$indexes_block = explode(',', $quiz->block_index);
				@endphp
				@foreach($indexes_block as $index_block)
					@php
						$block = $block_model::find($index_block);
						$indexes_questions = explode(',', $block->question_index);
						$questions = $question_model::where('id_block', $block->id)->get();
						$i_question = 1;
					@endphp
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col-md-6">
										<input class="delete-block" type="checkbox" value="{{$block->id}}">
										<a href="{{ route('block.edit.view', $block->id) }}">
											{{$block->name}} <i class="fa fa-eye"></i>
										</a>
									
								</div>
								<div class="col-md-6 text-right">
									<a href="{{ route('block.preview.view', $block->id) }}">
										<i class="fa fa-search" style="font-size:16px"></i>
									</a>

									<a href="{{ route('block.delete', $block->id) }}">
										<i class="fa fa-times"></i>
									</a>
									
									<form id="update-up-{{$block->id}}" style="display: inline;" method="POST" action="{{ route('block.update.index') }}">
										@csrf
										<input type="hidden" name="id_block" value="{{$block->id}}"/>
										<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
										<input type="hidden" name="type" value="0"/>
										<a href="#" onclick="document.getElementById('update-up-{{$block->id}}').submit();">
											<i class="fa fa-arrow-up"></i>
										</a>
									</form>
									<form id="update-down-{{$block->id}}" style="display: inline;" method="POST" action="{{ route('block.update.index') }}">
										@csrf
										<input type="hidden" name="id_block" value="{{$block->id}}"/>
										<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
										<input type="hidden" name="type" value="1"/>
										<a href="#" onclick="document.getElementById('update-down-{{$block->id}}').submit();">
											<i class="fa fa-arrow-down"></i>
										</a>
									</form>
									

									
									<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#modal-create-question">
										<i class="fa fa-plus"></i> Nova questao
									</button>
									
								</div>
								
							</div>
							
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped">
										<tbody>
											@php
												$count = 1;
											@endphp
											@foreach($indexes_questions as $index_qest)
												@php
													$question = $question_model::find($index_qest);
												@endphp
												@if($question != NULL)
													<tr>
														<th width="5%" scope="row">{{$count}}</th>
														<td width="70%">
															<a href="{{ route('question.edit',  $question->id) }}">
																{{$question->question}} <i class="fa fa-eye"></i>
															</a>
														</td>
														<td>
															<a href="#" data-toggle="modal" data-target=".bd-example-modal-xl" data-id-question="{{$question->id}}">
																<i class="fa fa-search"></i>
															</a>
															<a href="{{route('question.delete', $question->id)}}">
																<i class="fa fa-times"></i>
															</a>
														</td>
														<td>
															<a href="{{ route('question.index.update', [$question->id, 0]) }}">
																<i class="fa fa-arrow-up"></i>
															</a>
															<a href="{{ route('question.index.update', [$question->id, 1]) }}">
																<i class="fa fa-arrow-down"></i>
															</a>
														</td>
													</tr>
													@php
														$count += 1;
													@endphp
												@endif
											@endforeach
											
										</tbody>
									</table>
								</div>
							</div> <!--FIM ROW-->
						</div> <!--FIM CARD BODY-->
					</div> <!--FIM CARD-->
				</br>
				@endforeach
			@endif

			
			<div class="row mb-3 mt-3">
				<div class="col-md-12">
					<button id="select-all" type="button" class="btn btn-secondary">Selecionar Todos Blocos</button>	
				</div>
			</div>
			<div class="row mb-3 mt-3">
				<div class="col-md-12">
					<b>Com os selecionados:</b></br>
					<button id="delete-all" type="button" class="btn btn-danger">Apagar</button>
				</div>
			</div>
		</main> <!-- END MAIN CONTENT-->
	</div> <!-- END ROW-->
</div>

<!-- INIT MODALS CONTENT-->

<!-- Preview question modal -->
<div id="show-question" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Previa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8">
						<div id="question-text"></div>
					</div>
					<div class="col-md-4">
						<div id="question-content"></div>
					</div>
				</div> <!--FIM ROW-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Create Block -->
<div class="modal fade" id="modal-create-block" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Novo Bloco</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{ route('block.create.post') }}">
					@csrf
				<div class="row">
					<div class="col-md-12">
						<label>Nome </label>
						<div class="form-group">
							<input type="text" name="name" placeholder="nome do bloco" class="form-control">
						</div>
						<input type="hidden" name="id_quiz" value="{{$quiz->id}}">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
				<button type="submit" class="btn btn-primary">Adicionar</button>
			</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal Create Question -->
<div class="modal fade" id="modal-create-question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nova Questao</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3">
						<h6>Questoes</h6>
						<hr>
						<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
							<a class="nav-link active" id="v-pills-a-tab" data-toggle="pill" href="#v-pills-a" role="tab" aria-controls="v-pills-a" aria-selected="true">Resposta curta</a>
							<a class="nav-link" id="v-pills-b-tab" data-toggle="pill" href="#v-pills-b" role="tab" aria-controls="v-pills-b" aria-selected="false">Multipla escolha</a>
							<a class="nav-link" id="v-pills-c-tab" data-toggle="pill" href="#v-pills-c" role="tab" aria-controls="v-pills-c" aria-selected="false">Numerico</a>
							<a class="nav-link" id="v-pills-d-tab" data-toggle="pill" href="#v-pills-d" role="tab" aria-controls="v-pills-d" aria-selected="false">Sim/Nao</a>
						</div>
					</div>
					<div class="col-md-9">
						<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="v-pills-a" role="tabpanel" aria-labelledby="v-pills-a-tab">
							<div class="alert alert-info" role="alert">
								Permite uma resposta de uma ou de poucas palavras.
							</div>
							<form method="POST" action="{{ route('question.create.post') }}">
								@csrf
								<div class="form-group">
									<label>Nova Questao </label>
									<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
								</div>
								<input type="hidden" name="type" value="1"/>
								<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
								<div class="form-group">
									<label>Adicionar no Bloco </label>
									<select class="form-control" name="id_block">
										@foreach($blocks_quiz as $block)
											<option value="{{$block->id}}">{{$block->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group text-right">
									<button type="submit" class="btn btn-primary">Adicionar</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="v-pills-b" role="tabpanel" aria-labelledby="v-pills-b-tab">
							<div class="alert alert-info" role="alert">
								Permite a seleção de simples ou múltiplas respostas de uma lista pré definida.
							</div>
							<form method="POST" action="{{ route('question.create.post') }}">
								@csrf
								<div class="form-group">
									<label>Nova Questao </label>
									<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
								</div>
								<label>Opcoes (separado por virgula) </label>
								<div class="form-group">
									<input type="text" name="choices" placeholder="leve, moderado, grave" class="form-control">
								</div>
								<input type="hidden" name="type" value="2"/>
								<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
								<div class="form-group">
									<label>Adicionar no Bloco </label>
									<select class="form-control" name="id_block">
										@foreach($blocks_quiz as $block)
											<option value="{{$block->id}}">{{$block->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group text-right">
									<button type="submit" class="btn btn-primary">Adicionar</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="v-pills-c" role="tabpanel" aria-labelledby="v-pills-c-tab">
							<div class="alert alert-info" role="alert">
								Permite uma resposta numérica.
							</div>
							<form method="POST" action="{{ route('question.create.post') }}">
								@csrf
								<div class="form-group">
									<label>Nova Questao </label>
									<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
								</div>
								<input type="hidden" name="type" value="3"/>
								<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
								<div class="form-group">
									<label>Adicionar no Bloco </label>
									<select class="form-control" name="id_block">
										@foreach($blocks_quiz as $block)
											<option value="{{$block->id}}">{{$block->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group text-right">
									<button type="submit" class="btn btn-primary">Adicionar</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="v-pills-d" role="tabpanel" aria-labelledby="v-pills-d-tab">
							<div class="alert alert-info" role="alert">
								Uma questao simples de multipla escolha com apenas duas opcoes "sim" ou "nao".
							</div>
							<form method="POST" action="{{ route('question.create.post') }}">
								@csrf
								<div class="form-group">
									<label>Nova Questao </label>
									<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
								</div>
								<input type="hidden" name="type" value="4"/>
								<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
								<div class="form-group">
									<label>Adicionar no Bloco </label>
									<select class="form-control" name="id_block">
										@foreach($blocks_quiz as $block)
											<option value="{{$block->id}}">{{$block->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group text-right">
									<button type="submit" class="btn btn-primary">Adicionar</button>
								</div>
							</form>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Create Question -->


<!-- END MODALS CONTENT -->


<!-- INIT PREVIEW-QUESTION MODAL -->

<script>
	$('#show-question').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var id_question = button.data('id-question') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		var url = "/question/preview/"+id_question;
		$.getJSON(url, function(data) {
			console.log(data);
			var text = document.getElementById('question-text');
			text.innerHTML = data.question;
			var content = document.getElementById('question-content');
			content.innerHTML = data.content;
		});
	})
</script>

<!-- END PREVIEW-QUESTION MODAL -->


<script>
$('#select-all').click(function () {    
	$('input:checkbox').prop('checked', true);    
});
 
$('#delete-all').click(function () {    
	var checkeds = $('.delete-block:checkbox:checked');
	var i;
	var ids = "";
	if(confirm("Voce tem certeza que deseja apagar todos blocos selecionados e as questoes que elas possuem?")) {
		for (i = 0; i < checkeds.length; i++) {
			ids += checkeds[i].value + "-";
		}
	}
	window.location.replace("/block/deleteall/"+ids);
});
</script>



</body>
</html>
