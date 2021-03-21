@inject('quiz_model', 'App\Quiz');
@inject('block_model', 'App\Block');
@inject('patient_model', 'App\Patient');
@inject('group_control', 'App\Http\Controllers\GroupController')

@php
	$groups = $group_control::get_own_and_included_groups(Auth::id());
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
								<a class="nav-link" style="font-size:15px;" href="{{ route('group.view.get', $obj->id) }}">
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
							Listar Questionarios
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

		<div class="tab-content" id="tabs">
		</br>
			<div class="tab-pane" id="a">
				<div class="row" style="margin-bottom:16px;">
					<div class="col-md-12">
						<div class="text-right">
							<button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#modal-create-quiz">Novo Questionário</button>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">
									</th>
									<th scope="col">Nome</th>
									<th scope="col">Ações</th>
								</tr>
							</thead>
							<tbody>
								@foreach($quizzes_group as $quiz)
								<tr>
									<td><input class="delete-quiz" type="checkbox" value="{{$quiz->id}}"></td>
									<td>
										<a href="{{ route('quiz.view.get', $quiz->id) }}">
											{{$quiz->name}} <i class="fa fa-eye"></i>
										</a>
										<ul>
											@if($quiz->block_index != NULL)
												@php
													$indexes_block = explode(',', $quiz->block_index);
												@endphp
												@foreach($indexes_block as $index_block)
													@php
														$block = $block_model::find($index_block);
													@endphp
													<li style="color:#6c757d;"> 
													<a href="{{ route('block.view.get', $block->id) }}">
														{{$block->name}}
													</li>
												@endforeach
											@endif
										</ul>
									</td>
									<td>
										<a href="{{ route('quiz.preview.get', $quiz->id) }}" style="text-decoration: none;">
											<i class="fa fa-search"></i>
										</a>
										<form id="quiz-delete-{{$quiz->id}}" style="display:inline;" method="POST" action="{{ route('quiz.delete.post') }}">
											@csrf
											<input type="hidden" name="id_quiz" value="{{$quiz->id}}"/>
											<input type="hidden" name="id_group" value="{{$group->id}}"/>
											<a href="#" onclick="document.getElementById('quiz-delete-{{$quiz->id}}').submit();">
												<i class="fa fa-times"></i>
											</a>
										</form>

									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button id="select-all" type="button" class="btn btn-secondary">Selecionar Todos Questionários</button>	
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

			<div class="tab-pane" id="c">
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
									<th>Ações</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

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



$(document).ready(function() {
    var table = $('#display-participants-include').DataTable( {
        "ajax": "/group/participants/add/{{$group->id}}",
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
        "ajax": "/group/participants/search/{{$group->id}}",	
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
