@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 20%">
    @if (session('date'))
    <div class="mt-2 alert alert-success">
        {{ session('date') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="mt-2 alert alert-danger">
        {{ $errors->first('deadline') }}
    </div>
    @endif
    <a href="#" data-toggle="model" data-target="addproject" style="padding-right: 25px">
        <i class="fas fa-filter"></i> Filter projecten
    </a>
    <a href="{{ route('project.store')}}" data-toggle="modal" data-target="#addproject">
        <i class="fas fa-plus-square"></i> Maak een project
    </a>
    <hr>
    @if($projects->projects->isEmpty())
    <div style="box-shadow: 2px 2px 8px 2px gray; padding: 50px; height: 210px">
        <h1>U heeft geen projecten</h1>
        <h4>Klik hier om een project aan te maken</h4>
        <img src="img/no_project.png" style="width: 150px; height: 150px; position: relative; left: 650px; bottom: 30px;">

        <button href="{{ route('project.store')}}" data-toggle="modal" data-target="#addproject" class="btn btn-success" style="float: right;"><i class="fas fa-chevron-right"></i>
        </button>
    </div>
    @endif

    <!-- The Modal -->
    <div class="modal fade" id="addproject">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('project.store') }}" method="post">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Voeg een project toe</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="card">
                        @csrf
                        <div class="card-body">
                            Title: <input type="text" class="form-control" name="title" required>
                            Deadline: <input class="form-control" type="date" name="deadline" required>
                            Description: <input class="form-control" type="text" name="description" required><br>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="opslaan">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Sluiten</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($projects->projects as $project)
            <div class="col-md-6 col-sm-12 ">
                <a class="project-card-text" href="{{route('project.dashboard', $project->id)}}" method="post">
                    <div class="card mt-2 project-card">
                        <div class="card-header" style="padding-top: 5px; padding-bottom: 5px">
                            <div class="row" style="">
                                <div class="col-5">
                                    <div>
                                        <i class="fas fa-fingerprint" style="color: green"></i> {{ $project->title}}
                                    </div>
                                </div>
                                <div class="col-7" style=" @if($project->deadlineForHumans < 15) color: red; @endif">
                                    <div class="project-card-deadline">
                                        {{$project->deadlineForHumans }} Dagen tot de deadline

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    {{$project->description}}
                                </div>
                                <div class="col-6">
                                    <div style="float: right">
                                        <h4 style="color: #00b0e8; padding-right: 20px">Leden:</h4>
                                        @foreach ($project->userProjects as $project->name)
                                        <p><i class="fas fa-user" style="color: #0E9A00;"></i>{{ $project->name->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>




@endsection