
@inject('group_model', 'App\Group');

@php
	$groups = $group_model::where('id_user', Auth::id())->get();
@endphp

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