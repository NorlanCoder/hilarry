@extends('user.base')

@section('search')

    <form class="search" action="" method="get">
        @csrf
        <input type="text" name="name" placeholder="Qu'est-ce que vous voulez manger ?">
        <button class="search-btn" type="submit">Rechercher</button>
    </form>
@endsection

@section('contenu')

        <div class="main-highlight">
            <div class="main-header">
                <h2 class="main-title">Recommandations</h2>
                <div class="main-arrow">
                    <i class="back fas fa-chevron-left"></i>
                    <i class="next fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="highlight-wrapper">
                @foreach ($recommandedfood as $item)
                    <div class="highlight-card">
                        <img class="highlight-img" src="/storage/{{$item->picture}}" alt="">
                        <div class="highlight-desc">
                            <h4>{{$item->name}}</h4>
                            <p>{{$item->price}} fcfa</p>
                            <a href="{{route('indexrecom',$item->name)}}"><i style="font-size: 1rem" class="fa-solid fa-circle-info"></i></a>
                        </div>
                        
                    </div>
                @endforeach      
            </div>
        </div>

        <div class="main-menus">
            <div class="main-filter">
                <div>
                    <h2 class="main-title">Menu <br>Categories</h2>
                    <div class="main-arrow">
                        <i class="back-menu fas fa-chevron-left"></i>
                        <i class="next-menu fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="filter-wrapper">
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('homefood')}}"><i class="fa-solid fa-utensils"></i></a>
                        </div>
                        <p>Tous</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('cat','Burger')}}"><i class="fa-solid fa-burger"></i></a>
                        </div>
                        <p>Burger</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('cat','Breakfast')}}"><i class="fa-solid fa-pizza-slice"></i></a>
                        </div>
                        <p>Breakfast</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('cat','Glace')}}"><i class="fa-solid fa-ice-cream"></i></a>
                        </div>
                        <p>Glaces</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('cat','Dejeuner')}}"><i class="fa-solid fa-mug-hot"></i></a>
                        </div>
                        <p>Dejeuner</p>
                    </div>
                </div>
            </div>
            <hr class="divider">

            <div class="main-detail">
                <h2 class="main-title">Passer une commande</h2>
                <div class="detail-wrapper">
                    @foreach ($foods as $item)
                        <div class="detail-card" style="max-width: 500px">
                            <div class="icons">
                                <a href="{{route('addfavorie',$item)}}" class="heart"><i class="fa-solid fa-heart"></i></a>
                                <a href="{{route('cart.addcart',$item)}}" class="cart"><i class="fa fa-shopping-cart"></i></a>
                            </div>
                            <img class="detail-img" src="/storage/{{$item->picture}}" alt="">
                            <div class="detail-desc">
                                <div class="detail-name">
                                    <h4>{{$item->name}}</h4>
                                    <p class="detail-sub">{{$item->description}}</p>
                                    <p class="price">{{$item->price}} fcfa</p>
                                </div>
                                <i class="detail-favorite"></i>
                            </div>
                        </div>
                    @endforeach                
                </div>
                {{$foods->links("user.pagination")}}
            </div>
        </div>
   

@endsection