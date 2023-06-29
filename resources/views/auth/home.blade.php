@extends('layouts.app')

@section('content')

<style>
    body{
        background-repeat: no-repeat;
        background-image: url('./img/bg.png');
        background-size: cover;
    }

    .floating {
        animation-name: floating;
        animation-duration: 3s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
        margin-left: 30px;
        margin-top: 5px;
    }

    @keyframes floating {
        0% { transform: translate(0,  0px); }
        50%  { transform: translate(0, 15px); }
        100%   { transform: translate(0, -0px); }
    }
</style>
<div class="row justify-content-center align-items-center mt-5">
    <div class="col-md-6 col-sm-12">
        {{-- <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @else
                    <div class="alert alert-success">
                        You are logged in!
                    </div>
                @endif

            </div>

        </div> --}}

        <div class="card" style="width: 24rem;">
            <img src="{{auth()->user()->profile_photo_path}}" height="300" class="card-img-top" alt="...">
            <div class="card-body">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Nombre: {{auth()->user()->name}}</li>
                <li class="list-group-item">Correo: {{auth()->user()->email}}</li>
                <li class="list-group-item">Telefono: {{auth()->user()->phone_number}}</li>
                <li class="list-group-item">Último inicio de sesión: {{auth()->user()->last_login}}</li>
              </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <img src="{{asset('img/astronauta.png')}}" class="img-fluid floating" alt="">
    </div>
</div>

@endsection
