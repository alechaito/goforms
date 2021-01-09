@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$student_groups = $group_control::groups_user($student->id);
	$groups = $group_control::groups_user(Auth::id());
@endphp
<html>
<head>
<link href="{{ URL::asset('/css/dashboard.css') }}" rel="stylesheet">
<script src="{{ URL::asset('/js/dashboard.js') }}"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color:#58B19F;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CIF Easy</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="{{ route('logout') }}">Logout</a>
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
					@foreach($groups as $group)
						<li class="nav-item">
							<a class="nav-link" href="{{ route('group.preview.view', [$group->id, 'quizzes']) }}">
								{{$group->name}}
							</a>
						</li>
					@endforeach
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>Banco de Questoes</span>
					</h6>
					<li class="nav-item">
						<a class="nav-link" href="{{route('storequestion.view')}}">
							<span data-feather="home"></span>
							Questoes
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('storequestion.category.view')}}">
							<span data-feather="home"></span>
							Categorias
						</a>
					</li>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>Outros</span>
					</h6>
					<li class="nav-item">
						<a class="nav-link" href="./patient/evaluate.html">
							<span data-feather="home"></span>
							Avaliar Paciente
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('searchuser.view')}}">
							<span data-feather="home"></span>
							Buscar Usuario
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('searchpatient.view')}}">
							<span data-feather="home"></span>
							Buscar Paciente
						</a>
					</li>
				</ul>
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Editando Estudante</h1>
		</div>

		<p class="text-right">
			<button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#modal-include">Incluir a um Projeto</button>
			<a href="{{ route('student.delete', $student->id) }}">
				<button type="button" class="btn btn-danger">
					Excluir Estudante
				</button>
			</a>
		</p>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a href="#a" class="nav-link" data-toggle="tab">Dados</a>
			</li>
		</ul>

		<div class="tab-content" id="tabs">
		</br>

			<!-- ---------------------------------------------->
			<div class="tab-pane" id="a">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							@if(session()->has('message-data'))
								<div class="alert alert-success">
									{{ session()->get('message-data') }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif
							<h5 class="h5">Dados</h5>
							<form method="POST" action="{{ route('student.edit.post') }}">
								@csrf
								<input type="hidden" name="id_student" value="{{$student->id}}">
								<div class="form-group">
									<label>Nome</label>
									<input type="text" name="name" value="{{$student->name}}" class="form-control">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" name="email" value="{{$student->email}}" class="form-control">
								</div>
								<div class="text-right">
									<button type="submit" class="btn btn-primary">Atualizar Dados</button>
								</div>
							</form>
							<hr>
							@if(session()->has('message-password'))
								<div class="alert alert-success">
									{{ session()->get('message-password') }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif
							<form method="POST" action="{{ route('student.edit.password') }}">
								@csrf
								<input type="hidden" name="id_student" value="{{$student->id}}">
								<h5>Trocar Senha</h5>
								<div class="form-group">
									<label>Nova Senha</label>
									<input type="text" name="password" class="form-control">
								</div>
								<div class="form-group">
									<label>Confirmar Nova Senha</label>
									<input type="text" name="confirm_password" class="form-control">
								</div>
								<div class="text-right">
									<button type="submit" class="btn btn-primary">Atualizar Senha</button>
								</div>
							</form>
							</br>
						</div>
						<div class="col-md-6">
							<h5 class="h5">Projetos que participa</h5>
							<ul class="list-group">
								@foreach($student_groups as $group)
									<li class="list-group-item">
										{{ $group->name }}
										@if($group->level != NULL) 
											@if($group->level == 0)
												(Leitor)
											@elseif($group->level == 0)
												(Monitor)
											@else
												(Editor)
											@endif
										@else
											(Dono)
										@endif
										<a href="{{ route('group.delete.participant', [$group->id, $student->id]) }}">
											<i class="fa fa-times"></i>
                            			</a>
									</li>
								@endforeach
							</ul>
							
						</div>
					</div>
				</div>
			</div>
			<!-- ---------------------------------------------->

			<!-- ---------------------------------------------->
			<div class="tab-pane" id="b">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<h5 class="h5">Permissoes</h5>
							<table class="table">
								<tbody>
									<tr>
									<td>Criar,Visualizar,Editar Formulario</td>
									<td><input type="checkbox"></td>
									</tr>
									<tr>
									<td>Criar,Visualizar,Editar Paciente</td>
									<td><input type="checkbox"></td>
									</tr>
									<tr>
									<td>Criar,Visualizar,Editar Aluno</td>
									<td><input type="checkbox"></td>
									</tr>
									<tr>
									<td>Abrir & Fechar Questionario</td>
									<td><input type="checkbox"></td>
									</tr>
									<tr>
									<td>Gerar Relatorios</td>
									<td><input type="checkbox"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- ---------------------------------------------->
		

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
			<form method="POST" action="{{ route('group.add.user') }}">
				@csrf
				<input type="hidden" name="id_user" value="{{ $student->id }}">
				<div class="form-group">
					<label>Selecione um grupo de interesse</label>
					<select name="id_group" class="form-control">
						@foreach($groups as $group)
							<option value="{{$group->id}}">
								{{$group->name}}
							</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label>Atribuir papel</label>
					<select name='level' class="form-control">
						<option value='0'>Leitor</option>
						<option value='1'>Monitor</option>
						<option value='2'>Editor</option>
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

