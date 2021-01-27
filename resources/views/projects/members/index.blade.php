@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 20%;">
    @if (session('notLoggedUser'))
    <div class="mt-2 alert alert-success">
        {{ session('notLoggedUser') }}
    </div>

    @elseif (session('created'))
    <div class="mt-2 alert alert-success">
        {{ session('created') }}
    </div>

    @elseif (session('loggedUser'))
    <div class="mt-2 alert alert-danger">
        {{ session('loggedUser') }}
    </div>
    @elseif (session('alreadyExists'))
    <div class="mt-2 alert alert-danger">
        {{ session('alreadyExists') }}
    </div>

    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            @if ($userproject->pivot->role_id === 1)
            <button type="button" class="mb-4 btn-sm btn btn-primary btn-md" style="float: right" data-toggle="modal" data-target="#addUser">
                <i class="fas fa-user-plus"></i> Leden uitnodigen
            </button>
            @endif
        </div>
        <table class="mt-2 table table-hover">
            <thead>
                <tr>
                    <th scope="col">Naam</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Rol</th>
                    @if ($userproject->pivot->role_id === 1)
                    <th scope="col">Actie</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($userProjects as $user)
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>@if ($user->pivot->role_id === 1)
                    Administrator
                    @elseif ($user->pivot->role_id === 2)
                    Gebruiker
                    @endif
                </td>
                @if ($userproject->pivot->role_id === 1)
                <td><a href="{{route('members.destroy', $user->id)}}" class="btn" data-toggle="modal" data-target="#verwijderen{{ $user->id }}">
                        <i class="fas fa-trash small-trash-icon"></i>
                    </a>
                    <div class="modal fade" id="verwijderen{{ $user->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Gebruiker verwijderen uit project</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <p>
                                        Weet je zeker dat je deze gebruiker wilt verwijderen uit het project?
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <form action="{{ route('members.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" class="btn btn-danger" value="Verwijderen">
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Sluiten</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="addUser">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('member.store', $project->id) }}" method="post">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Voeg een gebruiker toe aan project</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="card">
                                        @csrf

                                        <div class="card-header">
                                            <a>Gebruikers:</a>
                                            <div class="card-body">
                                                <div id="custom-search-input">
                                                    <select class="form-control" name="id">
                                                        @foreach ($allUsers as $allUser)
                                                        <option value="{{$allUser->id}}">{{$allUser->name}}</option>
                                                        @endforeach
                                                    </select>
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
                    @endif
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection