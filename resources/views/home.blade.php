@inject('group_model', 'App\Group');
@inject('block_model', 'App\Block');
@inject('storequestion_model', 'App\StoreQuestion');
@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$groups = $group_control::groups_user(Auth::id());
	
	//$groups = $group_model::where('id_user', Auth::id())->get();
	//$included_groups = $group_control->included_groups(Auth::id());
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
						<a class="nav-link" style="font-size:15px;" href="{{route('home')}}">
							<i class="fa fa-home"></i> Inicio
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
						<span> <i class="fa fa-user-plus"></i> Cadastrar</span>
					</h6>
					<li class="nav-item">
						<a class="nav-link" style="font-size:15px;" href="{{route('patient.create')}}">
							Paciente
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
			<h1 class="h2">Projetos</h1>
		</div>
			
		<div class="row">
			<div class="col-md-12">
				<p class="text-right">
					<a href="#" data-toggle="modal" data-target="#modal-create-group">
						<button type="submit" class="btn btn-secondary">Novo Projeto</button>
					</a>
				</p>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">
							</th>
							<th scope="col">Nome</th>
							<th scope="col">Descrição</th>
							<th scope="col">Ações</th>
						</tr>
					</thead>
					<tbody>
						
						@foreach($groups as $group)
							@php
								$quizzes = DB::table('quizzes')->where('id_group', $group->id)
									->orderByRaw('name ASC')->get();
							@endphp
							<tr>
								<td><input type="checkbox" value="{{$group->id}}" class="delete-group"></td>
								<td>
									<a href="{{ route('group.view.get', $group->id) }}" data-toggle="tooltip" data-placement="bottom" title="Visualizar">
										{{$group->name}} <i class="fa fa-eye"></i>
									</a>
									<ul>
										@foreach($quizzes as $quiz)
											<li style="color:#6c757d;">
												<a href="{{ route('quiz.view.get', $quiz->id) }}">
													{{$quiz->name}} <i class="fa fa-eye"></i>
												</a>
												<a href="{{ route('quiz.edit.get', $quiz->id) }}">
													<i class="fa fa-cog"></i>
												</a>
											 </li>
										@endforeach
									</ul>
								</td>
								<td>{{$group->resume}}</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-edit-group" data-whatever="{{$group->id}};{{$group->name}};{{$group->resume}}" data-toggle="tooltip" data-placement="bottom" title="Editar">
										<i class="fa fa-cog"></i>
									</a>
									<a id="{{$group->id}}" href="#" onclick="delete_group(this)" data-toggle="tooltip" data-placement="bottom" title="Apagar">
										<i class="fa fa-times"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<button id="select-all-groups" type="button" class="btn btn-secondary">Selecionar Todos Projetos</button>	
			</div>
		</div>
		</br>

		<div class="row">
			<div class="col-md-12">
				<b>Com os selecionados:</b></br>
				<button id="delete-all-groups" type="button" class="btn btn-danger">Apagar</button>
			</div>
		</div>



		<!----------------------------------------------------> 

		<!-- Modal Edit Group -->
		<div class="modal fade" id="modal-edit-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Projeto</h5>
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
						<div class="form-group">
							<label>Descricao</label>
							<textarea class="form-control" id="change-resume" name="resume" rows="1"></textarea>
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
			document.getElementById('change-resume').value = result[2];
		})
		</script>

		<!-- Modal Create Group -->
		<div class="modal fade" id="modal-create-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Novo Projeto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('group.create.post') }}">
						@csrf
					<div class="form-group">
						<label>Nome</label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="form-group">
						<label>Descricao</label>
						<textarea class="form-control" name="resume" rows="1"></textarea>
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

		
	</main>
	
  </div>
</div>

<script>



function delete_group(data) {
	var id_group = data.id;
	if(confirm('Tem certeza que deseja deletar este grupo e todo conteudo pertencente como questionarios, blocos e questoes?')) {
		$.get("http://localhost:8000/group/delete/"+id_group, function(data, status){});
		window.location.reload(true); 
	}
}

$(document).ready(function() {
	$('#select-all-groups').click(function () {    
		$('input.delete-group:checkbox').prop('checked', true);    
	});
	 

	$('#delete-all-groups').click(function () {    
		if(confirm('Tem certeza que deseja apagar todos os grupos selecionados e seus conteudos?')) {
			var checkeds = $('.delete-group:checkbox:checked');
			var i;
			var ids = "";
			for (i = 0; i < checkeds.length; i++) {
				ids += checkeds[i].value + "-";
			}
			window.location.replace("/group/deleteall/"+ids);
		}
 	});
});

$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})

</script>

</body>
</html>
