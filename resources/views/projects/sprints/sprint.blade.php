@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 20%; background: white; box-shadow: 50px 50px 50px 50px white;">
        @if (session('addBacklog'))
            <div class="mt-2 alert alert-success">
                {{ session('addBacklog') }}
            </div>
        @endif
        <div class="row" style=" margin-bottom: 20px">
            @foreach($sprint as $sprint)
                <div class="col-6">
                    <h2 style="float: left;">{{$sprint->name}}</h2>
                </div>
                <div class="col-6">
                    <h4 style="float: right;"><i class="fas fa-calendar-alt"
                                                 style="padding-right: 5px"></i>{{$sprint->start_date->format('M d Y')}}
                        - {{$sprint->end_date->format('M d Y')}}</h4>
                </div>
                <div class="col-12">
                    <div>
                        @if($backlogitems->isEmpty())
                        @else
                            <h5 style="float: left">
                                <button class="btn sprint_buttons" href="" data-toggle="modal"
                                        data-target="#updateBacklogItem">
                                    voeg bestaande backlog items toe: <i class="fas fa-plus"></i>
                                </button>
                            </h5>
                        @endif
                        <button href="{{ route('project.store')}}" data-toggle="modal" data-target="#addbacklogitem"
                                class="btn sprint_buttons">Nieuwe backlog item <i class="fas fa-plus"></i></button>

                        <a class="btn sprint_buttons" style="float: right"
                           href="{{route('retrospectives.index', [request()->route('project'), $sprint->id])}}"
                           method="post">
                            <h5>Retrospective <i style="color: #00b0e8" class="fas fa-arrow-right"></i></h5>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row" style="background: white; padding-top: 4px;border-bottom: 1px solid gray; color: #00b0e8;">

        </div>
        <div class="row"
             style="background: white; padding-top: 4px; padding-left: 0;  border-bottom: 2px solid gray; color: grey;">
            <div class="col-3">
                <a style="padding-right: 25px;" class="font-weight-bold">
                    To Do( 20 )
                </a>
            </div>
            <div class="col-3">
                <a style="padding-right: 25px" class="font-weight-bold">
                    Doing( 20 )
                </a>
            </div>
            <div class="col-3">
                <a style="padding-right: 25px" class="font-weight-bold">
                    Review( 20 )
                </a>
            </div>
            <div class="col-3">
                <a style="padding-right: 25px" class="font-weight-bold">
                    Done( 20 )

                </a>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-3 " style="border-left: 1px dotted gray; border-right: 1px dotted gray;">
                @foreach($to_do_backlogitems as $sprint_backlogitem)
                    @if($sprint_backlogitem->type === 'Bug')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid red; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: red; float: right;" class="fas fa-bug"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Feature')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #00b0e8; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #00b0e8; float: right;" class="fas fa-clipboard-list"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Epic')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #ffc107; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #ffc107; float: right;" class="fas fa-crown"></i></p>
                            </div>
                        </a>
                    @endif
                    <div class="modal fade" id="wijzigenbacklogitem{{$sprint_backlogitem->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('backlogItem.update', $sprint_backlogitem->id) }}"
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
                                                       id="FeatureId{{$sprint_backlogitem->id}}"
                                                       name="type"
                                                       value="Feature" {{ $sprint_backlogitem->type === 'Feature' ? 'checked' : ''}}>
                                                <label class="custom-control-label"
                                                       for="FeatureId{{$sprint_backlogitem->id}}"
                                                       style="color: #00b0e8;">Feature</label>
                                            </div>


                                            <!-- Default inline 2-->
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input"
                                                       id="EpicId{{$sprint_backlogitem->id}}"
                                                       name="type"
                                                       value="Epic" {{ $sprint_backlogitem->type === 'Epic' ? 'checked' : ''}}>
                                                <label class="custom-control-label"
                                                       for="EpicId{{$sprint_backlogitem->id}}"
                                                       style="color: #ffc107;">Epic</label>
                                            </div>

                                            <!-- Default inline 3-->
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input"
                                                       id="BugId{{$sprint_backlogitem->id}}"
                                                       name="type"
                                                       value="Bug" {{ $sprint_backlogitem->type === 'Bug' ? 'checked' : ''}}>
                                                <label class="custom-control-label"
                                                       for="BugId{{$sprint_backlogitem->id}}"
                                                       style="color:red;">Bug</label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <label for="sel1">Verander de status (select one):</label>
                                                <select name="status" class="form-control">
                                                    <option value="{{$sprint_backlogitem->status}}">Selecteer een status</option>
                                                    <option value="0">To do</option>
                                                    <option value="1">Doing</option>
                                                    <option value="2">Review</option>
                                                    <option value="3">Done</option>
                                                </select>

                                                Als<input class="form-control" type="text" name="role"
                                                          value="{{$sprint_backlogitem->role}}" required>
                                                wil ik <input class="form-control" type="text" name="activity"
                                                              value="{{$sprint_backlogitem->activity}}" required>
                                                Story points: <input class="form-control" type="number"
                                                                     name="story_point"
                                                                     value="{{$sprint_backlogitem->story_point}}"
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
            </div>
            <div class="col-3 " style="border-left: 1px dotted gray; border-right: 1px dotted gray;">
                @foreach($doing_backlogitems as $sprint_backlogitem)
                    @if($sprint_backlogitem->type === 'Bug')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid red; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: red; float: right;" class="fas fa-bug"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Feature')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #00b0e8; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #00b0e8; float: right;" class="fas fa-clipboard-list"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Epic')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #ffc107; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #ffc107; float: right;" class="fas fa-crown"></i></p>
                            </div>
                        </a>
                    @endif
                        <div class="modal fade" id="wijzigenbacklogitem{{$sprint_backlogitem->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('backlogItem.update', $sprint_backlogitem->id) }}"
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
                                                           id="FeatureId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Feature" {{ $sprint_backlogitem->type === 'Feature' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="FeatureId{{$sprint_backlogitem->id}}"
                                                           style="color: #00b0e8;">Feature</label>
                                                </div>


                                                <!-- Default inline 2-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input"
                                                           id="EpicId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Epic" {{ $sprint_backlogitem->type === 'Epic' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="EpicId{{$sprint_backlogitem->id}}"
                                                           style="color: #ffc107;">Epic</label>
                                                </div>

                                                <!-- Default inline 3-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input"
                                                           id="BugId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Bug" {{ $sprint_backlogitem->type === 'Bug' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="BugId{{$sprint_backlogitem->id}}"
                                                           style="color:red;">Bug</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <label for="sel1">Verander de status (select one):</label>
                                                    <select name="status" class="form-control">
                                                        <option value="{{$sprint_backlogitem->status}}">Selecteer een status</option>
                                                        <option value="0">To do</option>
                                                        <option value="1">Doing</option>
                                                        <option value="2">Review</option>
                                                        <option value="3">Done</option>
                                                    </select>

                                                    Als<input class="form-control" type="text" name="role"
                                                              value="{{$sprint_backlogitem->role}}" required>
                                                    wil ik <input class="form-control" type="text" name="activity"
                                                                  value="{{$sprint_backlogitem->activity}}" required>
                                                    Story points: <input class="form-control" type="number"
                                                                         name="story_point"
                                                                         value="{{$sprint_backlogitem->story_point}}"
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
            </div>
            <div class="col-3 " style="border-left: 1px dotted gray; border-right: 1px dotted gray;">
                @foreach($review_backlogitems as $sprint_backlogitem)
                    @if($sprint_backlogitem->type === 'Bug')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid red; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: red; float: right;" class="fas fa-bug"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Feature')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #00b0e8; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #00b0e8; float: right;" class="fas fa-clipboard-list"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Epic')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #ffc107; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #ffc107; float: right;" class="fas fa-crown"></i></p>
                            </div>
                        </a>
                    @endif
                        <div class="modal fade" id="wijzigenbacklogitem{{$sprint_backlogitem->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('backlogItem.update', $sprint_backlogitem->id) }}"
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
                                                           id="FeatureId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Feature" {{ $sprint_backlogitem->type === 'Feature' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="FeatureId{{$sprint_backlogitem->id}}"
                                                           style="color: #00b0e8;">Feature</label>
                                                </div>


                                                <!-- Default inline 2-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input"
                                                           id="EpicId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Epic" {{ $sprint_backlogitem->type === 'Epic' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="EpicId{{$sprint_backlogitem->id}}"
                                                           style="color: #ffc107;">Epic</label>
                                                </div>

                                                <!-- Default inline 3-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input"
                                                           id="BugId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Bug" {{ $sprint_backlogitem->type === 'Bug' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="BugId{{$sprint_backlogitem->id}}"
                                                           style="color:red;">Bug</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <label for="sel1">Verander de status (select one):</label>
                                                    <select name="status" class="form-control">
                                                        <option value="{{$sprint_backlogitem->status}}">Selecteer een status</option>
                                                        <option value="0">To do</option>
                                                        <option value="1">Doing</option>
                                                        <option value="2">Review</option>
                                                        <option value="3">Done</option>
                                                    </select>

                                                    Als<input class="form-control" type="text" name="role"
                                                              value="{{$sprint_backlogitem->role}}" required>
                                                    wil ik <input class="form-control" type="text" name="activity"
                                                                  value="{{$sprint_backlogitem->activity}}" required>
                                                    Story points: <input class="form-control" type="number"
                                                                         name="story_point"
                                                                         value="{{$sprint_backlogitem->story_point}}"
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
            </div>
            <div class="col-3 " style="border-left: 1px dotted gray; border-right: 1px dotted gray;">
                @foreach($done_backlogitems as $sprint_backlogitem)
                    @if($sprint_backlogitem->type === 'Bug')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid red; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: red; float: right;" class="fas fa-bug"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Feature')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #00b0e8; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #00b0e8; float: right;" class="fas fa-clipboard-list"></i></p>
                            </div>
                        </a>
                    @elseif($sprint_backlogitem->type === 'Epic')
                        <a href="{{ route('backlogItem.edit', $sprint_backlogitem->id) }}"
                           class="" data-toggle="modal"
                           data-target="#wijzigenbacklogitem{{ $sprint_backlogitem->id }}">
                            <div class="rounded sprint-card"
                                 style="background: white; padding: 3px; border: 1px solid gray; border-left: 3px solid #ffc107; margin-top: 10px">
                                <i style="float: right; padding: 2px" class="fas fa-ellipsis-v"></i>
                                <a class="sprint_backlogItem_cards" style="color: #9d0006;">
                                    als {{$sprint_backlogitem->role}} wil ik
                                    {{$sprint_backlogitem->activity}}</a>
                                <p style="padding-top: 30px; margin-bottom: 0"><i style="color: green;"
                                                                                  class="fas fa-user"></i>
                                    {{$sprint_backlogitem->users->name}}
                                    <i style="color: #ffc107; float: right;" class="fas fa-crown"></i></p>
                            </div>
                        </a>
                    @endif
                        <div class="modal fade" id="wijzigenbacklogitem{{$sprint_backlogitem->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('backlogItem.update', $sprint_backlogitem->id) }}"
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
                                                           id="FeatureId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Feature" {{ $sprint_backlogitem->type === 'Feature' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="FeatureId{{$sprint_backlogitem->id}}"
                                                           style="color: #00b0e8;">Feature</label>
                                                </div>


                                                <!-- Default inline 2-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input"
                                                           id="EpicId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Epic" {{ $sprint_backlogitem->type === 'Epic' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="EpicId{{$sprint_backlogitem->id}}"
                                                           style="color: #ffc107;">Epic</label>
                                                </div>

                                                <!-- Default inline 3-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input"
                                                           id="BugId{{$sprint_backlogitem->id}}"
                                                           name="type"
                                                           value="Bug" {{ $sprint_backlogitem->type === 'Bug' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="BugId{{$sprint_backlogitem->id}}"
                                                           style="color:red;">Bug</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <label for="sel1">Verander de status (select one):</label>
                                                    <select name="status" class="form-control">
                                                        <option value="{{$sprint_backlogitem->status}}">Selecteer een status</option>
                                                        <option value="0">To do</option>
                                                        <option value="1">Doing</option>
                                                        <option value="2">Review</option>
                                                        <option value="3">Done</option>
                                                    </select>

                                                    Als<input class="form-control" type="text" name="role"
                                                              value="{{$sprint_backlogitem->role}}" required>
                                                    wil ik <input class="form-control" type="text" name="activity"
                                                                  value="{{$sprint_backlogitem->activity}}" required>
                                                    Story points: <input class="form-control" type="number"
                                                                         name="story_point"
                                                                         value="{{$sprint_backlogitem->story_point}}"
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
            </div>
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
                                <input type="radio" class="custom-control-input" id="typeOfBacklogItem1" name="type"
                                       value="Feature">
                                <label class="custom-control-label" for="typeOfBacklogItem1" style="color: #00b0e8;">Feature</label>
                            </div>

                            <!-- Default inline 2-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="typeOfBacklogItem2" name="type"
                                       value="Epic">
                                <label class="custom-control-label" for="typeOfBacklogItem2" style="color: #ffc107;">Epic</label>
                            </div>

                            <!-- Default inline 3-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="typeOfBacklogItem3" name="type"
                                       value="Bug">
                                <label class="custom-control-label" for="typeOfBacklogItem3"
                                       style="color:red;">Bug</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                Als<input class="form-control" type="text" name="role" required>
                                wil ik <input class="form-control" type="text" name="activity" required>
                                Story points: <input class="form-control" type="number" name="story_point" required><br>
                                <a>Groeps leden:</a>
                                <select class="form-control" name="user_id">
                                    <option value=""></option>
                                    @foreach ($projectUsers as $projectUser)
                                        <option value="{{$projectUser->id}}">{{$projectUser->name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="project_id" name="project_id" value="{{$project_id}}">
                                <input type="hidden" id="sprint_id" name="sprint_id" value="{{$sprint->id}}">
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

    <div class="modal fade" id="updateBacklogItem">
        <div class="modal-dialog">
            <div class="modal-content">
                @foreach($backlogitems as $backlogitem)
                    <form action="{{ route('sprint.update', $backlogitem->id) }}" method="post">
                    @endforeach
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Voeg een backlogitem toe aan sprint</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="card">
                            @csrf
                            @method('PATCH')
                            <div class="card-header">
                                <a>Alle backlogitems in project:</a>
                                <div class="card-body">
                                    <div id="custom-search-input">
                                        <select class="form-control" name="id">
                                            @foreach($backlogitems as $backlogitem)
                                                <option name="sprint_id" value="{{request()->route('sprint')}}">
                                                    als {{$backlogitem->role}} wil
                                                    ik {{$backlogitem->activity}}</option>
                                            @endforeach
                                        </select>
                                    </div>
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

@endsection