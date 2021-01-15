
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
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">GOForms</a>
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
				</ul>
			</div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">
					Editar Meu Usuario
				</h1>
			</div>

			<p class="text-right">
				<button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#modal-include">Incluir a um Grupo</button>
			</p>



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
						<form method="POST" action="{{ route('user.edit.post') }}">
							@csrf
							<div class="form-group">
								<label>Nome</label>
								<input type="text" name="name" value="{{$user->name}}" class="form-control">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" name="email" value="{{$user->email}}" class="form-control">
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
						<form method="POST" action="{{ route('user.edit.password') }}">
							@csrf
							<h5>Trocar Senha</h5>
							<div class="form-group">
								<label>Nova Senha</label>
								<input type="password" name="password" class="form-control">
							</div>
							<div class="form-group">
								<label>Confirmar Nova Senha</label>
								<input type="password" name="confirm_password" class="form-control">
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Atualizar Senha</button>
							</div>
						</form>
						</br>
					</div>
				</div>
			</div>
		</main>
  	</div>
</div>


</body>


</html>

