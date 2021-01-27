@extends('layouts.app')

@section('content')
<div class="container" style="margin-left: 20%;">
    @if (session('deleted'))
    <div class="mt-2 alert alert-success">
        {{ session('deleted') }}
    </div>
    @elseif (session('failed'))
    <div class="mt-2 alert alert-danger">
        {{ session('failed') }}
    </div>
    @elseif (session('failedAdmin'))
    <div class="mt-2 alert alert-danger">
        {{ session('failedAdmin') }}
    </div>
    @elseif (session('updated'))
    <div class="mt-2 alert alert-success">
        {{ session('updated') }}
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
            <form action=" {{ route('admin.index') }}" method="get" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Zoek naar gebruikers"> <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span style="color: red;" class="fas fa-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <table class="mt-5 table table-hover">
            <thead>
                <tr>
                    <th scope="col">Naam</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>@if ($user->user_role_id === 1)
                    Administrator
                    @elseif ($user->user_role_id === 2)
                    Gebruiker
                    @endif
                </td>
                <td> <a href="{{ route('admin.update', $user->id)}}" class="btn" data-toggle="modal" data-target="#aanpassen{{ $user->id }}">
                        <i class="fas fa-edit small-edit-icon"></i>
                    </a>
                    <div class="modal fade" id="aanpassen{{ $user->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Gebruiker Aanpassen</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="{{ route('admin.update', $user->id) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <div id="custom-search-input">
                                            <select class="form-control" name="role_id">
                                                <option name="user_role_id" value="1" {{ $user->user_role_id === 1 ? 'selected' : ''}}>Administrator</option>
                                                <option name="user_role_id" value="2" {{ $user->user_role_id === 2 ? 'selected' : ''}}>Gebruiker</option>
                                            </select>
                                        </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Aanpassen">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Sluiten</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="btn" data-toggle="modal" data-target="#verwijderen{{ $user->id }}">
                        <i class="fas fa-trash small-trash-icon"></i>
                    </a>
                    <div class="modal fade" id="verwijderen{{ $user->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Gebruiker verwijderen</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <p>
                                        Weet je zeker dat je deze gebruiker wilt verwijderen?
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <form action="{{ route('admin.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" class="btn btn-danger" value="Verwijderen">
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Sluiten</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tbody>
            @endforeach
        </table>
        {{ $users->links( "pagination::bootstrap-4") }}
    </div>
</div>
@endsection