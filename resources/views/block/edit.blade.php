
@inject('question_model', 'App\Question');

@php
	$groups = DB::table('groups')->where('id_user', Auth::id())->get();
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
						<span>{{$block->name}}</span>
					</h6>

					<li class="nav-item">
						<a class="nav-link" href="#a" onclick="activaTab('a')">
							Listar Questoes
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#b" onclick="activaTab('b')">
							Editar
						</a>
					</li>
					
					
				</ul>
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">
				{{$block->name}} 
				<a href="{{ route('quiz.edit.view', [$block->id_quiz, 'view']) }}" class="btn btn-secondary">Voltar</a>
			</h1>
		</div>

		<div class="tab-content" id="tabs"> <!-- TAB CONTENT -->
			</br>
			<!----------------------------------------------------> 
			<div class="tab-pane" id="b">
				<div class="row">
					<div class="col-md-6">
						<form method="POST" action="{{ route('block.updatename.post') }}">
							@csrf
							<label>Nome </label>
							<div class="form-group">
								<input type="text" name="name" value="{{$block->name}}" class="form-control">
								<input type="hidden" name="id_block" value="{{$block->id}}">							
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Atualizar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!----------------------------------------------------> 
			<div class="tab-pane" id="a">

				<div class="row" style="margin-bottom:16px;">
					<div class="col-md-12 text-right">
						
						<div class="btn-group">
							<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
								Adicionar Questao
							</button>
							<div class="dropdown-menu dropdown-menu-lg-right">
								<button class="dropdown-item" type="button" data-toggle="modal" data-target="#modal-create-question">
									<i class="fa fa-plus"></i> uma nova questao
								</button>
								<button class="dropdown-item" type="button" data-toggle="modal" data-target="#modal-storequestion">
									<i class="fa fa-plus"></i> do banco de questoes
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col"></th>
									<th scope="col">Questao</th>
									<th scope="col">Acao</th>
									<th scope="col">Mover</th>
								</tr>
							</thead>
							<tbody>
								@if($block->question_index != NULL)
								@php
									$indexes_quest = explode(',', $block->question_index);
									$count = 1;
								@endphp
									@foreach($indexes_quest as $index_quest)
										@php
											$question = $question_model::find($index_quest);
										@endphp
										<tr>
											<td>
												<input class="delete-question" type="checkbox" value="{{$question->id}}">
											</td>
											<th scope="row">{{$count}}</th>
											<td>
												<a href="{{ route('question.edit', $question->id) }}">
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
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>

				</br>
				<div class="row">
					<div class="col-md-12">
						<button id="select-all" type="button" class="btn btn-secondary">Selecionar Todas Questoes</button>	
					</div>
				</div>
				</br>

				<div class="row">
					<div class="col-md-12">
						<b>Com os selecionados:</b></br>
						<button id="delete-all" type="button" class="btn btn-danger">Apagar</button>
					</div>
				</div>
				</br>


			</div>
			<!----------------------------------------------------> 
		</div>

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

		<!-- Modal Display Store Questions to Include -->
		<div class="modal fade" id="modal-storequestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Banco de Questoes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<table id="display-storequestions-include" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Questao</th>
										<th>Criado por.</th>
										<th>Categoria</th>
										<th>Adicionar</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button id="move-all-storequestion" type="button" class="btn btn-secondary">
								Adicionar questoes selecionadas para o bloco
							</button>	
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
		<div class="modal fade" id="modal-create-question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Texto da Questao</h5>
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
										<label>Texto da Questao </label>
										<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
									</div>
									<input type="hidden" name="type" value="1"/>
									<div class="form-group">
										<label>Adicionar no Bloco </label>
										<select class="form-control" name="id_block">
											<option value="{{$block->id}}">{{$block->name}}</option>
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
										<label>Texto da Questao </label>
										<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
									</div>
									<label>Opcoes (separado por virgula) </label>
									<div class="form-group">
										<input type="text" name="choices" placeholder="leve, moderado, grave" class="form-control">
									</div>
									<input type="hidden" name="type" value="2"/>
									<div class="form-group">
										<label>Adicionar no Bloco </label>
										<select class="form-control" name="id_block">			
											<option value="{{$block->id}}">{{$block->name}}</option>
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
										<label>Texto da Questao </label>
										<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
									</div>
									<input type="hidden" name="type" value="3"/>
									<div class="form-group">
										<label>Adicionar no Bloco </label>
										<select class="form-control" name="id_block">				
											<option value="{{$block->id}}">{{$block->name}}</option>
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
										<label>Texto da Questao </label>
										<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
									</div>
									<input type="hidden" name="type" value="4"/>
									<div class="form-group">
										<label>Adicionar no Bloco </label>
										<select class="form-control" name="id_block">
											<option value="{{$block->id}}">{{$block->name}}</option>			
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

    </main>
  </div>
</div>

<script>
	function activaTab(tab){
    $('.nav-item a[href="#' + tab + '"]').tab('show');
};
activaTab('a');

$('#select-all').click(function () {    
	$('input:checkbox').prop('checked', true);    
});

function move(data) {
	if(confirm('Tem certeza que deseja mover as questoes selecionadas para o banco de questoes?')) {
		var checkeds = $('.delete-question:checkbox:checked');
		for (var i = 0; i < checkeds.length; i++) {
			console.log(checkeds[i].value);
			$.get("http://"+window.location.hostname+"/question/move/"+checkeds[i].value, function(data, status){
				console.log(status);
				console.log(data);
				return true;
			});
		}
	}
}

$('#move-all-storequestion').click(function () {    
	var checkeds = $('.move-storequestion:checkbox:checked');
	var i;
	var ids = "";
	for (i = 0; i < checkeds.length; i++) {
		ids += checkeds[i].value + "-";
		id_block = checkeds[i].id;
	}
	window.location.replace("/storequestion/moveall/"+ids+"/"+id_block);
});
	 
$('#delete-all').click(function () {    
	var checkeds = $('.delete-question:checkbox:checked');
	var i;
	var ids = "";
	if(confirm("Voce tem certeza que deseja apagar todas questoes selecionados?")) {
		for (i = 0; i < checkeds.length; i++) {
			ids += checkeds[i].value + "-";
		}
		//fetch("/question/deleteall/"+ids);
		window.location.replace("/question/deleteall/"+ids);
	}
});

$(document).ready(function() {
	var table2 = $('#display-storequestions-include');
	console.log(table2);
    var table = $('#display-storequestions-include').DataTable( {
        "ajax": "/search-storequestion/block/{{$block->id}}",
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

</script>

</body>
</html>
