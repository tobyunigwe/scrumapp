@extends('layouts.app')


@section('content')
    <div class="container" style="margin-left: 20%;">
        @foreach ($currentUserProjects as $currentUserProject)


            <div class="row">
                <div class="col-12" style="padding-top: 25px;">
                    <div style="box-shadow: 2px 2px 8px 2px lightgray; padding: 20px;">
                        <h2><i style="color: gray" class="fas fa-calendar-alt"></i> 	&nbsp; Nog {{$currentUserProject->deadlineForHumans}} Dagen tot de deadline
                            <a style="float: right" href="{{ route('project.edit', $currentUserProject->id) }}" class=""
                               data-toggle="modal" data-target="#wijzigen{{$currentUserProject->id }}">
                                <i style=" float:right; font-size: 40px" class="fas fa-edit big-edit-icon"></i>
                            </a>
                        </h2>
                    </div>
                </div>

                <div class="col-8" style="padding-top: 25px">
                    <div style="box-shadow: 2px 2px 8px 2px lightgray; padding: 30px;">
                        <h4>Backlogitems info</h4>
                        <hr>
                        <div class="row">
                            <div class="col-3 backlogitemCount">
                                <div class="rounded text-center" style="background: purple; padding: 10px">
                                    <i class="fas fas fa-clipboard-list" style="font-size: 30px"></i>
                                    <h2>{{$backlogItems->count()}}</h2>
                                    <p>Backlog items</p>
                                </div>
                            </div>

                            <div class="col-3 backlogitemCount">
                                <div class="rounded text-center" style="background: dodgerblue; padding: 10px">
                                    <i class="fas fas fa-clipboard-list" style="font-size: 30px"></i>
                                    <h2>{{$backlogItemTypeFeature->count()}}</h2>
                                    <p>Features</p>
                                </div>
                            </div>

                            <div class="col-3 backlogitemCount">
                                <div class="rounded text-center" style="background: red; padding: 10px">
                                    <i class="fas fa-bug" style="font-size: 30px"></i>
                                    <h2>{{$backlogItemTypeBug->count()}}</h2>
                                    <p>Bugs</p>
                                </div>
                            </div>

                            <div class="col-3 backlogitemCount">
                                <div class="rounded text-center" style="background: darkorange; padding: 10px">
                                    <i class="fas fas fa-crown" style="font-size: 30px"></i>
                                    <h2>{{$backlogItemTypeEpic->count()}}</h2>
                                    <p>Epic's</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="padding-top: 25px">
                    <div style="box-shadow: 2px 2px 8px 2px lightgray; padding: 30px;">
                        <h4>Leden info</h4>
                        <hr>
                        @foreach ($usersProjects as $user)
                            <h5>
                                <img src="../../img/profile_picture.jpg" class="rounded-circle" alt="Profile picture"
                                     width="40px" height="40px" style="border: lightgray 2px solid">
                                {{ $user->name }}</h5>
                        @endforeach
                    </div>
                </div>
                <div class="modal fade" id="wijzigen{{$currentUserProject->id}}">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Wijzigen</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form style="padding-bottom: 50px"
                                      action="{{ route('project.update', $currentUserProject->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        eind datum: <input type="date" class="form-control" name="deadline"
                                                           value="{{$currentUserProject->deadline}}" required>
                                        <label for="user-name" class="col-form-label">Naam:</label>
                                        <input type="text" name="title" value="{{ $currentUserProject->title }}"
                                               class="form-control" required>
                                        <label for="user-name" class="col-form-label">Beschrijving:</label>
                                        <textarea type="text" name="description" style="height: 150px;"
                                                  class="form-control"
                                                  required>{{ $currentUserProject->description }}</textarea>
                                    </div>
                                    <input type="submit" style="float: right" class="btn btn-success" value="aanpassen">
                                </form>
                                <a>Geadvanceerde instellingen</a>

                                <p style="margin-top: 5px">
                                    <button class="btn btn-danger" type="button" data-toggle="collapse"
                                            data-target="#collapseExample" aria-expanded="false"
                                            aria-controls="collapseExample">
                                        Verwijder dit project
                                    </button>
                                </p>
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        Weet u zeker dat u het project {{$currentUserProject->title}} wilt verwijderen?
                                        <form action="{{ route('project.destroy' , $currentUserProject->id) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <div style="float: right;">
                                                <input type="submit" class="btn btn-danger" value="Ja">
                                                <button class="btn btn-success" type="button" data-toggle="collapse"
                                                        data-target="#collapseExample" aria-expanded="false"
                                                        aria-controls="collapseExample">
                                                    Nee
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Sluiten</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach
@endsection