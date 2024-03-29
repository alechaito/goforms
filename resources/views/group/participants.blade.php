@inject('quiz_model', 'App\Quiz');
@inject('block_model', 'App\Block');
@inject('patient_model', 'App\Patient');
@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$groups = $group_control::groups_user(Auth::id());

	var_dump($group->id);
	
	//$users_group = $group_control->select_users_group($group->id);
	//$patients_group = $group_control->select_patients_group($group->id);
	$quizzes_group = $group_control->quizzes($group->id);

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
						@foreach($groups as $obj)
							<li class="nav-item">
								<a class="nav-link" style="font-size:15px;" href="{{ route('group.preview.view', [$obj->id, 'quizzes']) }}">
									{{$obj->name}}
								</a>
							</li>
						@endforeach
					</div>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<a data-toggle="collapse" href="#collapse-quizzes" aria-expanded="false" aria-controls="collapse-quizzes">
							<span> <i class="fa fa-arrow-right"></i> {{$group->name}}</span>
						</a>
					</h6>
					
					<div class="collapse" id="collapse-quizzes">
						@foreach($quizzes_group as $quiz)
							<li class="nav-item">
								<a class="nav-link" href="{{route('home')}}">
									{{$quiz->name}}
								</a>
							</li>
						@endforeach
					</div>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span> <i class="fa fa-plus"></i> Outros</span>
					</h6>

					<li class="nav-item">
						<a class="nav-link" href="#a" onclick="activaTab('a')">
							Listar Questionários
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#c" onclick="activaTab('c')">
							Participantes
						</a>
					</li>

				</ul>
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2"> {{$group->name}}
		</div>

		<div class="row">
			<div class="col-md-12">
				<form>
					<p class="text-right">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-user">
							Adicionar Participante
						</button>
					</p>
					
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table id="display-participants" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th width="50%">Nome</th>
							<th width="40%">Papel</th>
							<th>Ações</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>



		<!-- Modal Display Users to Include -->
		<div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Incluir Usuário</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<table id="display-participants-include" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Nome</th>
										<th>Email</th>
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


		<!-- Modal Create Quiz -->
		<div class="modal fade" id="modal-create-quiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Novo Questionário</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('quiz.create.post') }}">
						@csrf
					<label>Nome</label>
					<div class="form-group">
						<input type="text" name="name" placeholder="questionario exemplo" class="form-control">
					</div>
					<input type="hidden" name="id_group" value="{{$group->id}}">
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
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
		$('.nav-item a[href="#' + tab + '"]').tab('show');
	};
	activaTab('a');
</script>


<script>

function move(data) {
	var id_group = $('.group-value:selected')[0].value;
	if(confirm('Tem certeza que deseja mover os questionarios selecionados e todo seu conteudo para o grupo?')) {
		var checkeds = $('.delete-quiz:checkbox:checked');
		var i;
		for (i = 0; i < checkeds.length; i++) {
			$.get("http://localhost:8000/quiz/move/"+checkeds[i].value+"/"+id_group, function(data, status){
				return true;
			});
		}
		window.location.reload(true);
	}
}

$(function()
{	
	$('#select-all').click(function () {    
		$('input:checkbox').prop('checked', true);    
	 });
	 
	 $('#delete-all').click(function () {
		var checkeds = $('.delete-quiz:checkbox:checked');
		var i;
		for (i = 0; i < checkeds.length; i++) {
			document.getElementById('quiz-delete-'+checkeds[i].value).submit();
		}
 	});
});

$(document).ready(function() {
    var table = $('#display-participants-include').DataTable( {
        "ajax": "/search-participants/add/{{$group->id}}",
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

$(document).ready(function() {
    var table = $('#display-participants').DataTable( {
        "ajax": "/search-participants/{{$group->id}}",	
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
@php
var_dump($group->id);
@endphp
</html>
