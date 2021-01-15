@php
$groups_inside = DB::table('group_participants')
	->where('id_participant', $patient->id)
	->leftJoin('groups', 'group_participants.id_group', '=', 'groups.id')
	->get();

$all_groups = DB::table('groups')
	->where('id_user', Auth::User()->id)
	->get();
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
						<span>Projetos</span>
					</h6>
			</div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">
					Editando Paciente
				</h1>
			</div>

			<p class="text-right">
				<a href="{{route('patient.delete.get', $patient->id)}}">
					<button type="button" class="btn btn-danger">
						Excluir Paciente
					</button>
				</a>
			</p>

		
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<form method="POST" action="{{ route('patient.edit.post', $patient->id) }}">
							@csrf
							<input type="hidden" name="id_patient" value="{{$patient->id}}">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" name="name" value="{{$patient->name}}" class="form-control">
							</div>
							<div class="form-group">
								<label>CPF/RG</label>
								<input type="text" name="document" value="{{$patient->document}}" class="form-control">
							</div>
							<div class="form-group">
								<label>Idade</label>
								<input type="text" name="age" value="{{$patient->age}}" class="form-control">
							</div>
							<div class="form-group">
								<label>Sexo</label>
								<select name="sex" class="form-control">
									@if($patient->sex == 0)
										<option value="0" selected>Masculino</option>
										<option value="1">Feminino</option>
									@else
										<option value="0">Masculino</option>
										<option value="1" selected>Feminino</option>
									@endif
								</select>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Atualizar</button>
							</div>
						</form>
					</div>
				</div>
			</div>

    	</main>
  	</div>
</div>

<!-- Modal Include in a Group -->
<div class="modal fade" id="modal-include" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Incluir em um Grupo</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form method="POST" action="{{ route('group.insert.participant.post') }}">
				@csrf
				<input type="hidden" name="id_participant" value="{{ $patient->id }}">
				<input type="hidden" name="id_role" value="2">
				<div class="form-group">
					<label>Selecione um grupo de interesse</label>
					<select name="id_group" class="form-control">
						@foreach($all_groups as $group)
							<option value="{{$group->id}}">
								{{$group->name}}
							</option>
						@endforeach
					</select>
				</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
			<button type="submit" class="btn btn-primary">Incluir</button>
			</form>
		</div>
		</div>
	</div>
</div>

</body>
<script>
	function activaTab(tab){
		$('.nav-tabs a[href="#' + tab + '"]').tab('show');
	};
	activaTab('a');
</script>

</html>
