@inject('group_model', 'App\Group');
@inject('block_model', 'App\Block');
@inject('storequestion_model', 'App\StoreQuestion');
@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$groups = $group_model::where('id_user', Auth::id())->get();
	$included_groups = $group_control->included_groups(Auth::id());
	$categories = $group_control->all_categories();
	$included_categories = $group_control->included_categories(); //categories when user is included in group

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

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color:#58B19F;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CIF Easy</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="">Logout</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('home')}}">
							<i class="fa fa-home"></i> Inicio
						</a>
					</li>
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span> <i class="fa fa-users"></i> Projetos </span>
					</h6>
					@foreach($groups as $group)
						<li class="nav-item">
							<a class="nav-link" style="font-size:15px;" href="{{ route('group.preview.view', [$group->id, 'quizzes']) }}">
								{{$group->name}}
							</a>
						</li>
					@endforeach
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span> <i class="fa fa-user-plus"></i> Cadastrar</span>
					</h6>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('patient.create')}}">
							Paciente
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('teacher.create')}}">
							Professor
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('student.create')}}">
							Aluno
						</a>
					</li>
	
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span><i class="fa fa-question-circle"></i> Banco de Questoes</span>
					</h6>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('storequestion.view')}}">
							<span data-feather="home"></span>
							Questoes
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('storequestion.category.view')}}">
							Categorias
						</a>
					</li>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span><i class="fa fa-plus"></i> Outros</span>
					</h6>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="./patient/evaluate.html">
							<i class="fa fa-user-md"></i>  Avaliar Paciente
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('searchuser.view')}}">
							<i class="fa fa-search"></i> Buscar Usuario
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('searchpatient.view')}}">
							<i class="fa fa-search"></i> Buscar Paciente
						</a>
					</li>
				</ul>
				
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Banco de Questoes</h1>
		</div>

		<div class="row">
			<div class="col-md-12">
				<p class="text-right">
					<a href="{{route('storequestion.category.view')}}">
						<button type="submit" class="btn btn-secondary">Categorias</button>
					</a>
					<a href="#" data-toggle="modal" data-target="#modal-create-question">
						<button type="submit" class="btn btn-secondary">Nova Questao</button>
					</a>
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table id="display-storequestion" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<th>Questao</th>
							<th>Criado por</th>
							<th>Categoria</th>
							<th>Acoes</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
		<hr>

		<div class="row">
			<div class="col-md-12">
				<button id="select-all-storequestion" type="button" class="btn btn-secondary">Selecionar Todas Questoes</button>	
			</div>
		</div>
		</br>

		<div class="row">
			<div class="col-md-12">
				<b>Com os selecionados:</b></br>
				<button id="delete-all-storequestions" type="button" class="btn btn-danger">Apagar</button>
			</div>
		</div>
		</br>


		<!-- Modal Edit Group -->
		<div class="modal fade" id="modal-edit-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Grupo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<form method="POST" action="{{ route('group.edit.post') }}">
						@csrf
					<div class="modal-body">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" id="change-name" name="name" class="form-control">
							<input type="hidden" id="id-group" name="id_group" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-primary">Atualizar</button>
					</div>
				</form>
			</div>
			</div>
		</div>

		<script>
		$('#modal-edit-group').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Button that triggered the modal
			var recipient = button.data('whatever') // Extract info from data-* attributes
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			//console.log(recipient);
			var result = recipient.split(";");
			console.log(result);
			document.getElementById('id-group').value = result[0];
			document.getElementById('change-name').value = result[1];
		})
		</script>

		<!-- Modal Create Group -->
		<div class="modal fade" id="modal-create-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Novo Grupo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('group.create.post') }}">
						@csrf
					<div class="form-group">
						<label>Nome</label>
						<input type="text" name="name" class="form-control" placeholder="Nome Grupo">
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-primary">Criar</button>
				</form>
				</div>
			</div>
			</div>
		</div>


		<!-- Modal Edit Question -->
		<div class="modal fade" id="modal-edit-question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Grupo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Nome Grupo">
						<input type="hidden" class="form-control" id="recipient-id">
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-primary">Atualizar</button>
				</div>
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
								<form method="POST" action="{{ route('storequestion.create.post') }}">
									@csrf
									<div class="form-group">
										<label>Nova Questao </label>
										<input type="text" name="question" class="form-control">
									</div>
									<div class="form-group">
										<label>Categoria</label>
										<select name="id_category" class="form-control">
											@foreach($categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
											@endforeach
											@foreach($included_categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
											@endforeach
										</select>
									</div>
									<input type="hidden" name="type" value="1"/>
									<div class="form-group text-right">
										<button type="submit" class="btn btn-primary">Adicionar</button>
									</div>
								</form>
							</div>
							<div class="tab-pane fade" id="v-pills-b" role="tabpanel" aria-labelledby="v-pills-b-tab">
								<div class="alert alert-info" role="alert">
									Permite a seleção de simples ou múltiplas respostas de uma lista pré definida.
								</div>
								<form method="POST" action="{{ route('storequestion.create.post') }}">
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
									<div class="form-group">
										<label>Categoria</label>
										<select name="id_category" class="form-control">
											@foreach($categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
											@endforeach
											@foreach($included_categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
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
								<form method="POST" action="{{ route('storequestion.create.post') }}">
									@csrf
									<div class="form-group">
										<label>Nova Questao </label>
										<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
									</div>
									<input type="hidden" name="type" value="3"/>
									<div class="form-group">
										<label>Categoria</label>
										<select name="id_category" class="form-control">
											@foreach($categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
											@endforeach
											@foreach($included_categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
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
								<form method="POST" action="{{ route('storequestion.create.post') }}">
									@csrf
									<div class="form-group">
										<label>Nova Questao </label>
										<input type="text" name="question" placeholder="questionario exemplo" class="form-control">
									</div>
									<input type="hidden" name="type" value="4"/>
									<div class="form-group">
										<label>Categoria</label>
										<select name="id_category" class="form-control">
											@foreach($categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
											@endforeach
											@foreach($included_categories as $category)
												<option value="{{$category->id}}">
													{{$category->name}}
												</option>
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

		
	</main>
	
  </div>
</div>

<script>

function move(data) {
	var id_block = $('.block-value:selected')[0].value;
	if(confirm('Tem certeza que deseja mover as questoes selecionadas para o bloco?')) {
		var checkeds = $('.delete-storequestion:checkbox:checked');
		var i;
		for (i = 0; i < checkeds.length; i++) {
			$.get("/storequestion/move/"+checkeds[i].value+"/"+id_block, function(data, status){
				return true;
			});
		}
	}
}

function delete_storequestion(data) {
	var id_qest = data.id;
	if(confirm('Tem certeza que deseja deletar esta questao?')) {
		$.get("/storequestion/delete/"+id_qest, function(data, status){});
		window.location.reload(true); 
	}
}

function delete_group(data) {
	var id_group = data.id;
	if(confirm('Tem certeza que deseja deletar este grupo e todo conteudo pertencente como questionarios, blocos e questoes?')) {
		$.get("/group/delete/"+id_group, function(data, status){});
		window.location.reload(true); 
	}
}

$(document).ready(function() {
    var table = $('#display-storequestion').DataTable( {
        "ajax": "/search-storequestion",
		"language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json",
			"search": 'a',
			"searchPlaceholder": "Digite uma palavra chave..."
        },
		"dom": "<'row'<'col-md-9'f><'col-md-3'i>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
    });

	$('#select-all-storequestion').click(function () {    
		$('input.delete-storequestion:checkbox').prop('checked', true);    
	});

	$('#select-all-groups').click(function () {    
		$('input.delete-group:checkbox').prop('checked', true);    
	});
	 
	$('#delete-all-storequestions').click(function () {    
		if(confirm('Tem certeza que deseja apagar todos as questoes selecionadas do banco?')) {
			var checkeds = $('.delete-storequestion:checkbox:checked');
			var i;
			for (i = 0; i < checkeds.length; i++) {
				$.get("/storequestion/delete/"+checkeds[i].value, function(data, status){
					return true;
				});
			}
			window.location.reload(true); 
		}
 	});

	$('#delete-all-groups').click(function () {    
		if(confirm('Tem certeza que deseja apagar todos os grupos selecionados e seus conteudos?')) {
			var checkeds = $('.delete-group:checkbox:checked');
			var i;
			for (i = 0; i < checkeds.length; i++) {
				$.get("/group/delete/"+checkeds[i].value, function(data, status){
					return true;
				});
			}
			window.location.reload(true); 
		}
 	});
});

</script>

</body>
</html>
