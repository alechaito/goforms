@inject('group_model', 'App\Group');
@inject('storequestion_model', 'App\StoreQuestion');

@php
	$groups = $group_model::where('id_user', Auth::id())->get();
	$store_questions = DB::table('store_questions')->where('id_user', Auth::id())->orderByRaw('question ASC')->get();
	$categories = DB::table('categories')->where('id_user', Auth::id())->orderByRaw('name ASC')->get();
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
			<h1 class="h2">
				Categorias
			</h1>
			
		</div>

		<div class="row">
			<div class="col-md-12">
				<p class="text-right">
					<a href="#" data-toggle="modal" data-target="#modal-create-category">
						<button type="submit" class="btn btn-secondary">Nova Categoria</button>
					</a>
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table id="display-storequestion" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th width="90%">Nome</th>
							<th>Acoes</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>


		<!-- Modal Create Category -->
		<div class="modal fade" id="modal-create-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nova Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('storequestion.category.create') }}">
						@csrf
					<div class="form-group">
						<label>Categoria</label>
						<input type="text" name="name" class="form-control">
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
	function activaTab(tab){
		$('.nav-tabs a[href="#' + tab + '"]').tab('show');
	};
	activaTab('a');
</script>

<script>
$(document).ready(function() {
    var table = $('#display-storequestion').DataTable( {
        "ajax": "/search-categories",
		"language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json",
			"search": 'a',
			"searchPlaceholder": "Digite uma palavra chave..."
        },
		"dom": "<'row'<'col-md-9'f><'col-md-3'i>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
    });
});

</script>

</body>
</html>
