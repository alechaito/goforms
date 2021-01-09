@inject('qest_control', 'App\Http\Controllers\QuestionController')

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
						<a class="nav-link" href="../index.html">
							<span data-feather="home"></span>
							Inicio
						</a>
					</li>
				</ul>
			</div>
		</nav>

	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">
				Questao
				<a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
			</h1>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h6 class="h6"> 
							Questao	- {{$question->category}}
						</h6>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
							{{ $question->question }}
							</div>
							<div class="col-md-4">
								@if($question->type == 1)
									<input type="text" class="form-control" placeholder="Escreva sua resposta...">
									(somente letras permitidas)
								@elseif($question->type == 2)
									@php
										$choices = $qest_control->question_choices($question->id);
										
									@endphp
									Selecione uma alternativa:
									<ul style="list-style-type:none;">
										@foreach($choices as $choice)
											@if($choice != "")
												<li><input type="radio"> {{$choice}}</li>
											@endif
										@endforeach
									</ul>
								@elseif($question->type == 3)
									<input type="text" class="form-control" placeholder="Escreva sua resposta...">
									(somente numeros permitidos)
								@elseif($question->type == 4)
									Selecione uma alternativa:
									<ul style="list-style-type:none;">
										<li><input type="radio"> Sim</li>
										<li><input type="radio"> Nao</li>
									</ul>
								@endif

							</div>
						</div> <!--FIM ROW-->
					</div> <!--FIM CARD BODY-->
				</div> <!--FIM CARD-->
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

</body>
</html>
