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
					<li class="nav-item">
						<a class="nav-link" href="{{route('home')}}">
							Projetos
						</a>
					</li>
				</ul>
				
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">
				{{$block->name}} - Adicionar Questao
				<a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
			</h1>
		</div>

		<div class="row">
			<div class="col-md-3">
				<h6>Tipos de Questoes</h6>
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

	</main>
  </div>
</div>


</body>
</html>
