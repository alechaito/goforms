@inject('group_model', 'App\Group');
@inject('block_model', 'App\Block');	
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
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">GOForms</a>
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
							<a class="nav-link" style="font-size:15px;" href="{{ route('group.view.get', [$group->id, 'quizzes']) }}">
								{{$group->name}}
							</a>
						</li>
					@endforeach
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Buscar Paciente</h1>
		</div>
			
		<div class="row">
			<div class="col-md-12">
				<table id="display-allpatients" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Idade</th>
							<th>CPF/RG</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

		<!----------------------------------------------------> 

	</main>
	
  </div>
</div>

<script>

	$(document).ready(function() {
		var table = $('#display-allpatients').DataTable( {
			"ajax": "/patient/make/table/edit/",	
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

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

</script>

</body>
</html>
