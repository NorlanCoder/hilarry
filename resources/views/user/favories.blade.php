@extends('user.base')

@section('search')

    <form class="search" action="" method="get">
        @csrf
        <input type="text" name="name" placeholder="Vous chercher un mets favorie ? ?">
        <button class="search-btn" type="submit">Rechercher</button>
    </form>
@endsection

@section('contenu')

<section class="main-menus" id="favorie" style="margin-top: 2rem">
   {{--<a href="{{route('indexfood')}}"><i class="fa-solid fa-arrow-left" id="back"></i></a>--}}

    <h3 class="titre" style="padding-bottom: 1rem">Listes de vos favories</h3>
    @if ($favories == null) 
        <p style="text-align: center">La liste des favories est vide </p>
    @else
    <table>
        <thead>
            <tr>
                <th>Food</th>
                <th>Categorie</th>
                <th>Prix (fcfa)</th>
                <th>Temps de cuisson</th>
                <th>Ajouter au panier</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($favories as $food)
           <tr>
                <td style="display: flex; align-items:center; flex-wrap:wrap;justify-content:center"><img src="/storage/{{$food->picture}}" alt=""><span>{{$food->name}}</span></td>
                <td>{{$food->type}}</td>
                <td>{{$food->price}} fcfa</td>
                <td>{{$food->cookTime}}</td>
                <td><a href="{{route('cart.addcart',$food)}}"><i class="fa-solid fa-cart-plus"></i></a></td>
                <td><a class="btn" href="{{route('addfavorie',$food)}}"><i class="fa-solid fa-trash"></i></a></td>
           </tr>
           @endforeach
        </tbody>
    </table>
    @endif
   
  
  
  </section>
    
@endsection