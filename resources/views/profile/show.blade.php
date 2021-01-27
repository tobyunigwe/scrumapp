@extends('layouts.app')


@section('content')
<div class="container" style="margin-left: 20%;">
    <div class="row" style="box-shadow: 2px 2px 8px 2px lightgray; padding: 30px">
        <div class="col-4">
            <img src="../img/profile_picture.jpg" class="rounded-circle" alt="Profile picture" width="200px" height="200px" style="border: lightgray 2px solid">
        </div>
        <div class="col-8">
            <h2> {{ Auth::user()->name }} {{ Auth::user()->name }} </h2>
            <h4 style="color: dodgerblue"> {{ Auth::user()->email }} </h4>

            <div class="upload-drop-zone" id="drop-zone" ondrop="drop(event)" ondragover="dragover(event)">
                <div class="text-center" style="border: lightgray 2px dashed; margin-top: 50px; padding: 10px; color: gray">
                    <p>Sleep uw profielfoto hier of klik op de knop hier onder</p>
                    <input type="file">

                </div>
            </div>
        </div>
        <div class="col-12" style="margin-top: 20px">
            <h2>Account</h2>
            <hr>
        </div>

        <div class="col-4">
            <h4 style="margin-top: 10px">Naam:</h4>
            <h4 style="margin-top: 20px">Email:</h4>
            <h4 style="margin-top: 20px">Hobbies:</h4>
            <h4 style="margin-top: 20px">Scrum begindatum:</h4>
        </div>
        <div class="col-8">
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{  Auth::user()->name }}">
            <input style="margin-top: 10px" type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ Auth::user()->email }}">
            <input style="margin-top: 10px" type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ $profile->hobby }}">
            <input style="margin-top: 10px" onfocus="(this.type='date')" type="text" class="form-control" id="exampleFormControlInput1" placeholder="{{ $profile->scrumExperienceSince->format('M d Y')}}">

        </div>
    </div>
</div>
@endsection