@extends('user.base')

@section('search')
    <div></div>
@endsection

@section('contenu')

<div class="main-menus" style="margin-top: 2rem">
    <section class="compteuser">
        <div class="row">
            <div class="profil-image">
                @if (Auth::user()->profil == null)
                <i class="fa-solid fa-circle-user"></i>
                @else
                <img src="/storage/{{Auth::user()->profil}}" alt="">
                @endif
                
            </div>
            <div class="content">
                <div class="flexbox">
                    <div class="box">
                        <i class="fa-solid fa-user"></i>
                        <h3>{{Auth::user()->name}}</h3>
                    </div>
                    <div class="box">
                        <i class="fa-solid fa-envelope"></i>
                        <h3>{{Auth::user()->email}}</h3>
                    </div>
                </div>
                <div class="flexbox">
                    <div class="box">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <h3>{{Auth::user()->phone}}</h3>
                    </div>
                    <div class="box">
                        <i class="fa-solid fa-location-dot"></i>
                        <h3>{{Auth::user()->adresse}}</h3>
                    </div>
                </div>
                
            </div> 
        </div>
    </section>

    <section class="edituser">
        <h3 style="color: #0e6253; font-size:1.5rem">Editer votre compte</h3>
        <form method="post" action="{{ route('userupdate') }}">
            @csrf
            @method('put')
            <div class="flexbox">
                <div class="field">
                    <label for="name">Nom & Prénom</label>
                    <input type="text" name="name" id="name" value="{{Auth::user()->name}}" >
                </div>
                <div class="field">
                    <label for="phone">Telephone</label>
                    <input type="number" name="phone" id="phone" value="{{Auth::user()->phone}}">
                </div>
            </div>
            <div class="flexbox">
                <div class="field">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" value="{{Auth::user()->adresse}}">
                </div>
                <div class="field">
                    <label for="profil">Ajouter une photo de profil</label>
                    <input type="file" name="profil" id="profil" value="">
                </div>
            </div>
            <input type="submit" class="btn" value="Editer son profil">
        </form>     
    </section>
</div>   
@endsection