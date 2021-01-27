@extends('layouts.app')

@section('content')
    <div class="container" style="margin-left: 20%">
        @if (session('updated'))
            <div class="mt-2 alert alert-success">
                {{ session('updated') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-2 alert alert-danger">
                {{ $errors->first('deadline') }}
            </div>
        @endif
        @foreach($projects as $project)
            <div class="row"
                 style="padding-top: 4px;   border-bottom: 1px solid gray;">
                <div class="col-3">
                    <h2 style="padding-right: 25px">
                        Backlog
                    </h2>
                </div>
            </div>
            <div class="row"
                 style=" padding-top: 4px;   border-bottom: 2px solid black;">
                <div class="col-2">
                    <button class="btn sprint_buttons">Filter <i class="fas fa-filter"></i></button>
                </div>
                <div class="col-3">
                    <button href="{{ route('project.store')}}" data-toggle="modal" data-target="#addbacklogitem"
                            class="btn sprint_buttons">Backlog item <i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titel</th>
                            <th scope="col">storypoints</th>
                            <th scope="col">user</th>
                            <th scope="col">Type</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($backlogItems as $backlogitem)
                            <tr>
                                <th scope="row">1</th>
                                <td>als {{$backlogitem->role}} wil ik {{$backlogitem->activity}}</td>
                                <td>{{$backlogitem->story_point}}</td>
                                <td>{{$backlogitem->role}}</td>
                                @if($backlogitem->type === 'Feature')
                                    <td><i class="fas fa-clipboard-list" style="color: #00b0e8"></i></td>
                                @elseif($backlogitem->type === 'Epic')
                                    <td><i class="fas fa-crown" style=" color: #ffc107"></i></td>
                                @elseif($backlogitem->type === 'Bug')
                                    <td><i class="fas fa-bug" style="color:red;"></i></td>
                                @endif
                                <td>
                                    <div style="float: right">
                                        <form action="{{route('backlogItem.destroy' , $backlogitem->id) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <div style="float: right;">
                                                <button class="btn" type="submit">
                                                    <i class="fas fa-trash small-trash-icon"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <a href="{{ route('backlogItem.edit', $backlogitem->id) }}"
                                       class="" data-toggle="modal"
                                       data-target="#wijzigenbacklogitem{{ $backlogitem->id }}">
                                        <button class="btn" style="float: right; box-shadow: none"><i
                                                    class="fas fa-edit small-edit-icon"></i></button>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="wijzigenbacklogitem{{$backlogitem->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('backlogItem.update', $backlogitem->id) }}"
                                              method="post">
                                            @csrf
                                            @method('PATCH')<!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">wijzig backlogitem</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <a>Type backlog item:</a>
                                                    <!-- Default inline 1-->
                                                    <div class="custom-control custom-radio custom-control-inline">

                                                        <input type="radio" class="custom-control-input"
                                                               id="FeatureId{{$backlogitem->id}}"
                                                               name="type"
                                                               value="Feature" {{ $backlogitem->type === 'Feature' ? 'checked' : ''}}>
                                                        <label class="custom-control-label"
                                                               for="FeatureId{{$backlogitem->id}}"
                                                               style="color: #00b0e8;">Feature</label>
                                                    </div>


                                                    <!-- Default inline 2-->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" class="custom-control-input"
                                                               id="EpicId{{$backlogitem->id}}"
                                                               name="type"
                                                               value="Epic" {{ $backlogitem->type === 'Epic' ? 'checked' : ''}}>
                                                        <label class="custom-control-label"
                                                               for="EpicId{{$backlogitem->id}}"
                                                               style="color: #ffc107;">Epic</label>
                                                    </div>

                                                    <!-- Default inline 3-->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" class="custom-control-input"
                                                               id="BugId{{$backlogitem->id}}"
                                                               name="type"
                                                               value="Bug" {{ $backlogitem->type === 'Bug' ? 'checked' : ''}}>
                                                        <label class="custom-control-label"
                                                               for="BugId{{$backlogitem->id}}"
                                                               style="color:red;">Bug</label>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        Als<input class="form-control" type="text" name="role"
                                                                  value="{{$backlogitem->role}}" required>
                                                        wil ik <input class="form-control" type="text" name="activity"
                                                                      value="{{$backlogitem->activity}}" required>
                                                        Story points: <input class="form-control" type="number"
                                                                             name="story_point"
                                                                             value="{{$backlogitem->story_point}}"
                                                                             required>
                                                        <a>Groeps leden:</a>
                                                        <select class="form-control" name="user_id">
                                                        @foreach ($projectUsers as $projectUser)
                                                                <option value="{{$projectUser->id}}">{{$projectUser->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success" value="opslaan">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    Sluiten
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="modal fade" id="addbacklogitem">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('backlogItem.store') }}" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Voeg een backlogiten toe</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="card">
                        @csrf

                        <div class="card-header">
                            <a>Type backlog item:</a>
                            <!-- Default inline 1-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="typeOfBacklogItem1"
                                       name="type" value="Feature">
                                <label class="custom-control-label" for="typeOfBacklogItem1"
                                       style="color: #00b0e8;">Feature</label>
                            </div>

                            <!-- Default inline 2-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="typeOfBacklogItem2"
                                       name="type" value="Epic">
                                <label class="custom-control-label" for="typeOfBacklogItem2"
                                       style="color: #ffc107;">Epic</label>
                            </div>

                            <!-- Default inline 3-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="typeOfBacklogItem3"
                                       name="type" value="Bug">
                                <label class="custom-control-label" for="typeOfBacklogItem3"
                                       style="color:red;">Bug</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                Als<input class="form-control" type="text" name="role" required>
                                wil ik<input class="form-control" type="text" name="activity" required>
                                Story points:<input class="form-control" type="number" name="story_point" required>
                                <a>Groeps leden:</a>
                                    <select class="form-control" name="user_id">
                                        <option value=""> </option>
                                    @foreach ($projectUsers as $projectUser)
                                            <option value="{{$projectUser->id}}">{{$projectUser->name}}</option>
                                        @endforeach
                                    </select>
                                <input type="hidden" id="project_id" name="project_id" value="{{$project->id}}">
                            </div>
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

    @endforeach


@endsection
