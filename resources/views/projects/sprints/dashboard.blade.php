@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 20%;">
    @if (session('date'))
    <div class="mt-2 alert alert-success">
        {{ session('date') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="mt-2 alert alert-danger">
        {{ $errors->first('start_date') }}
    </div>
    @endif
    <button class="btn btn-primary btn-sm" style="float: right" data-toggle="modal" data-target="#addSprint">+ nieuwe sprint</button>
    <h3 style="padding-bottom: 20px"> Sprints dashboard </h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col" style="width: 25%;">Naam</th>
                <th scope="col" style="width: 50%">Beschrijving</th>
                <th scope="col" style="width: 20%">Datums</th>
                <th scope="col" style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($sprints as $sprint)
            <tr>
                <td><a href="{{route('sprints.show', [request()->route('project'), $sprint->id])}}" method="post">
                        {{$sprint->name}}
                    </a></td>
                <td>{{$sprint->description}}</td>
                <td>{{$sprint->start_date->format('M d Y')}} - {{$sprint->end_date->format('M d Y')}}</td>
                <td><form action="{{route('sprint.destroy' , $sprint->id) }}"
                          method="post">
                        @csrf
                        @method('DELETE')
                        <div style="float: right;">
                            <button class="btn" type="submit">
                                <i class="fas fa-trash small-trash-icon"></i>
                            </button>
                        </div>
                    </form></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="addSprint">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action=" {{ route('sprint.store') }} " method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Maak een sprint aan voor het project</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="card">
                        @csrf

                        <div class="card-header">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Beschrijving</label>
                                    <input type="text" class="form-control" name="description">
                                </div>
                                <div class="form-group">
                                    <label>Start datum</label>
                                    <input type="date" class="form-control" name="start_date">
                                </div>
                                <div class="form-group">
                                    <label">Eind datum</label">
                                    <input type="date" class="form-control" name="end_date">
                                </div>
                                <input type="hidden" name="project_id" value="{{ request()->route('project') }}">
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
</div>
@endsection