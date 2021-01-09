
@php
	if($question->type == 2) {
		$choice = DB::table('multiple_choices')->where('id_question', $question->id)->first();
	}
	$categories = DB::table('categories')->where('id_user', Auth::id())->orderByRaw('name ASC')->get();
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
				Editando Questao
				<a href="{{ route('storequestion.view') }}" class="btn btn-secondary">Voltar</a>
			</h1>
		</div>

		<div class="tab-pane" id="a">
			<div class="row">
				<div class="col-md-6">
					<form method="POST" action="{{ route('storequestion.edit.post') }}">
						@csrf
						<div class="form-group">
							<label>Questao</label>
							<textarea class="form-control" name="question" rows="4" cols="50">{{$question->question}}</textarea>
							<input type="hidden" name="id_question" value="{{$question->id}}"/>
						</div>
						<div class="form-group">
							<label>Categoria</label>
							<select name="id_category" class="form-control">
								@foreach($categories as $category)
									@if($category->id == $question->id_category)
										<option value="{{$category->id}}" selected>
											{{$category->name}}
										</option>
									@else
										<option value="{{$category->id}}">
											{{$category->name}}
										</option>
									@endif
								@endforeach
							</select>
						</div>
						@if($question->type == 2)	
							<div class="form-group">
								<label>Escolhas</label>
								<input type="text" class="form-control" name="choices" value="{{$choice->choices}}">
								<label>Digite as opcoes separadas por virgula, ex. "op1,op2,op3"</labels>
							</div>
						@endif
						<div class="form-group text-left">
							<button type="submit" class="btn btn-primary">Atualizar</button>
						</div>
					</form>
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

</body>
</html>
