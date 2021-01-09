<!DOCTYPE html>
<html>
	<head>
		<link rel="manifest" href="/manifest.json">

		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="msapplication-starturl" content="/">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="theme-color" content="#e5e5e5">  
		 
		<title>CIF</title>

		<link href="{{ URL::asset('/css/dashboard.css') }}" rel="stylesheet">
		<script src="{{ URL::asset('/js/dashboard.js') }}"></script>

		<!-- Data Table -->
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> 
		<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> 
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>

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
						<a class="nav-link" href="./index.html">
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
					Questionario - {{$quiz->name}}
					<a href="{{ route('group.preview.view', [$quiz->id_group, 'quizzes']) }}" class="btn btn-secondary">Voltar</a>
				</h1>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Navegacao Blocos </h5>
							<p class="card-text">
								<div class="row">
									<div class="col-md-12" style="margin-bottom: 5px;">
										<ul class="nav">

										</ul>
									</div>
								</div>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Paciente Cadastrado - Dados</h5>
							<p class="card-text">
								<div class="row">
									<div class="col-md-12" style="margin-bottom: 5px;">
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-patient">
											Selecionar Paciente
										</button>
										<a class="btn btn-secondary">Novo Paciente</a>
									</div>			
								</div>
							</p>
						</div>
					</div>
				</div>
			</div>
			</br>
			
			</br>
			<div class="row">
				<div class="col-md-12 text-right">
						<a id="send" class="btn btn-primary">
							Finalizar
						</a>
				</div>
			</div>
			
		</main>
	
  	</div>
</div>

<!-- Modal Display Users to Include -->
<div class="modal fade" id="modal-patient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Incluir Usuario</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<table id="display-patients-include" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th width="50%">Nome</th>
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

</body>

<script>

	$(document).ready(function() {
		var table = $('#display-patients-include').DataTable( {
			"ajax": "http://localhost:8000/search-patients",
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




	//checking if have connection and sincronizing
	if(navigator.onLine) {
		console.log("Internet connection...");
		var index = localStorage.getItem("index");
		for(i=0; i < index; i++) {
			var item = localStorage.getItem(i);
			console.log(item);
		}
	}
	
	$('#send').click(function () {   
		let new_obj = { 'id_quiz': 3, 'id_patient': 3, 'data': [] };

		//Getting all inputs type radio
		let input_options = $("input:radio:checked");
		for(i=0; i<input_options.length; i++) {
			var input = input_options[i];
			new_obj.data.push({'id_question':input.id, 'value':input.value});
		}

		//Getting all inputs type numbers
		let input_numbers = document.querySelectorAll('input[type=number]');
		for(i=0; i<input_numbers.length; i++) {
			var input = input_numbers[i];
			new_obj.data.push({'id_question':input.id, 'value':input.value});
		}

		//Getting all inputs type text
		let input_text = $("input:text");
		for(i=0; i<input_text.length; i++) {
			var input = input_text[i];
			new_obj.data.push({'id_question':input.id, 'value':input.value});
		}

		console.log(new_obj.data);
		//maintence index
		var index = localStorage.getItem("index");
		if(index == 0 || index == null) {
			localStorage.setItem("0", JSON.stringify(new_obj));
			localStorage.setItem("index", 1);
		}
		else {
			localStorage.setItem(parseInt(index), JSON.stringify(new_obj));
			localStorage.setItem("index", parseInt(index) + 1);
		}
		console.log(index);
	});

	if('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js', { scope: '/' })
          .then(function(registration) {
                console.log('Service Worker Registered');
          });

        navigator.serviceWorker.ready.then(function(registration) {
           console.log('Service Worker Ready');
        });
	}


</script>

</html>
