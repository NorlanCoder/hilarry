@extends('user.base')

@section('search')
    <div></div>
@endsection

@section('contenu')

<section class="contact" id="contact">
   {{--<a href="{{route('indexfood')}}"><i class="fa-solid fa-arrow-left" id="back"></i></a>--}}

    <h3 class="titre" style="margin-top: 3rem">{{  $food->exists ? 'Editer un mets' : 'Ajouter un mets ' }}</h3>
  
  <form action={{route($food->exists ? 'updatefood' : 'storefood', $food )}} method="post" enctype="multipart/form-data">

    @csrf
    @method($food->exists ? 'put' : 'post')
  
    <div class="inputBox">
        
            <div class="input">
                <label for="name">Nom du mets</label>
                <input type="text" name="name" id="name" value="{{ old('name',$food->name) }}">
                @error('name')
                <p style="color: red;">{{$message}}</p>   
                @enderror
            </div>
        
        <div class="input">
            <label for="cookTime">Temps de cuisson (min)</label>
            <input type="text"auteur name="cookTime" id="cookTime" value="{{old('cookTime',$food->cookTime)}}">
            @error('cookTime')
            <p style="color: red;">{{$message}}</p>   
            @enderror
        </div>
    </div>
    <div class="inputBox">
        <div class="input">
            <label for="price">Prix (fcfa)</label>
            <input type="number" name="price" id="price" value="{{ old('price',$food->price) }}">
            @error('price')
            <p style="color: red;">{{$message}}</p>   
            @enderror
        </div>
        <div class="input">
            <label for="picture">Image du mets</label>
            <input type="file" name="picture" id="picture" style="background-color: #fff;">
            @error('picture')
            <p style="color: red;">{{$message}}</p>   
            @enderror
        </div>
    </div>
    <div class="inputBox">
        <div class="input">
            <label for="type">Categorie du mets</label>
            <select name="type" id="type" >
                <option value="Burger" {{ $food->type=='Burger'? 'selected' : '' }}>Burger</option>
                <option value="Breakfast"  {{ $food->type=='Breakfast'? 'selected' : '' }}>Breakfast</option>
                <option value="Glace" {{ $food->type=='Glace'? 'selected' : '' }}>Glace</option>
                <option value="Dejeuner"  {{ $food->type=='Dejeuner'? 'selected' : '' }}>Dejeuner</option>   
            </select>
        </div>
    </div>
    
    <div class="inputBox" id="area">
        <div class="input">
            <label for="description">Descrption du mets</label>
            <textarea name="description" id="description" cols="30" rows="10">{{$food->description}}</textarea>
            @error('description')
            <p style="color: red;">{{$message}}</p>   
            @enderror
        </div>
    </div>
  
    <input type="submit" value="{{!$food->exists ? "Créer" : "Editer"}}" class="btn">
      
  </form>
  </section>
    
@endsection