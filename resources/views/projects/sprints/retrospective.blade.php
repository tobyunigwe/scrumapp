@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 20%">
        <h3 style="padding-bottom: 20px"> Retrospective </h3>
        <div class="row" style="box-shadow: 5px 5px 5px 5px lightgray">
            <div class="col-4 retrospective_table" style="position: relative">
                <div style="padding-bottom: 60px">
                    <h4 style="text-align: center">Wat ging goed? <i class="far fa-smile"></i></h4>
                    <hr>
                    @foreach($goodRetrospectives as $goodRetrospective)
                    <div class="rounded"
                         style="background: darkgreen; margin: 5px; text-align: left; color: white; padding: 5px ">
                        {{$goodRetrospective->description}}
                    </div>
                        @endforeach

                </div>
                <a href="{{ route('project.store')}}" style=" position: absolute; bottom: 5px; right: 5px;"
                   data-toggle="modal" data-target="#addGoodRetrospective" class="btn sprint_buttons"><i
                            class="fas fa-plus"></i></a>


            </div>
            <div class="col-4 retrospective_table" style="position: relative">
                <div style="padding-bottom: 60px">
                    <h4 style="text-align: center">Wat kan er beter? <i class="far fa-meh"></i></h4>
                    <hr>
                    @foreach($betterRetrospectives as $betterRetrospective)
                        <div class="rounded"
                             style="background: purple; margin: 5px; text-align: left; color: white; padding: 5px">
                            {{$betterRetrospective->description}}
                        </div>
                    @endforeach


                </div>
                <a href="{{ route('project.store')}}" style=" position: absolute; bottom: 5px; right: 5px;"
                   data-toggle="modal" data-target="#addBeterRetrospective" class="btn sprint_buttons">
                    <i class="fas fa-plus"></i></a>

            </div>
            <div class="col-4 retrospective_table" style="position: relative">
                <div style="padding-bottom: 60px">
                    <h4 style="text-align: center">Wat ging niet goed? <i class="far fa-frown"></i></h4>
                    <hr>
                    @foreach($badRetrospectives as $badRetrospective)
                    <div class="rounded"
                         style="background: darkred; margin: 5px; text-align: left; color: white; padding: 5px">
                        <p> {{$badRetrospective->description}}</p>
                    </div>
                        @endforeach
                </div>
                <a href="{{ route('retrospective.store')}}" style=" position: absolute; bottom: 5px; right: 5px;"
                   data-toggle="modal" data-target="#addBadRetrospective" class="btn sprint_buttons"><i
                            class="fas fa-plus">
                    </i>
                </a>
            </div>
        </div>
    </div>
    @foreach($sprints as $sprint)
        <div class="modal fade" id="addGoodRetrospective">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('retrospective.store') }}" method="post">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Wat ging er goed?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="card">
                            @csrf

                            <div class="card-header">
                                <div>
                                    <textarea class="form-control" type="text" name="description" required></textarea>
                                    <input type="hidden" id="sprint_id" name="sprint_id" value="{{$sprint->id}}">
                                    <input type="hidden" id="status" name="status" value="1">
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
        <div class="modal fade" id="addBeterRetrospective">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('retrospective.store') }}" method="post">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Wat kan er beter?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="card">
                            @csrf

                            <div class="card-header">
                                <div>
                                    <textarea class="form-control" type="text" name="description" required></textarea>
                                    <input type="hidden" id="sprint_id" name="sprint_id" value="{{$sprint->id}}">
                                    <input type="hidden" id="status" name="status" value="2">
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
        <div class="modal fade" id="addBadRetrospective">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('retrospective.store') }}" method="post">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Wat ging er niet goed?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="card">
                            @csrf

                            <div class="card-header">
                                <div>
                                    <textarea class="form-control" type="text" name="description" required></textarea>
                                    <input type="hidden" id="sprint_id" name="sprint_id" value="{{$sprint->id}}">
                                    <input type="hidden" id="status" name="status" value="3">
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
