@extends('user.base')

@section('search')

    <form class="search" action="" method="get">
        @csrf
        <input type="text" name="name" placeholder="Vous rechercher un mets ?">
        <button class="search-btn" type="submit">Rechercher</button>
    </form>
@endsection

@section('contenu')

        <div class="main-highlight">
            <div class="main-header">
                <h2 class="main-title">Statistiques du site</h2>
                <div class="main-arrow">
                    <i class="back fas fa-chevron-left"></i>
                    <i class="next fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="highlight-wrapper">
                    <div class="highlight-card">
                        <i class="fa-solid fa-user"></i>
                        <div class="highlight-desc">
                            <h4>Nombre d'utilisateur</h4>
                            <p>{{App\Models\User::count()}}</p>
                        </div>
                        <a href="{{route('indexuser')}}" style="text-decoration: none;"><i class="fa-solid fa-circle-info" style="display:block;font-size: 2rem"></i></a>
                    </div>
                    
                    <div class="highlight-card">
                        <i class="fa-solid fa-calendar-day"></i>
                        <div class="highlight-desc">
                            <h4>Nombre de mets proposé aujourhui</h4>
                            <p>{{App\Models\Food::count()}}</p>
                        </div>
                        <a href="{{route('indexfood')}}" style="text-decoration: none;"><i class="fa-solid fa-circle-info" style="display:block;font-size: 2rem"></i></a>
                        
                    </div>
                    
                    <div class="highlight-card">
                        <i class="fa-solid fa-store"></i>
                        <div class="highlight-desc">
                            <h4>Nombre de commande</h4>
                            <p>{{App\Models\OrderItem::count()}}</p>
                        </div>
                        <a href="{{route('order')}}" style="text-decoration: none;"><i class="fa-solid fa-circle-info" style="display:block;font-size: 2rem"></i></a>
                        
                    </div>
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
                            <a href="{{route('indexfood')}}"><i class="fa-solid fa-utensils"></i></a>
                        </div>
                        <p>Tous</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('admincat','Burger')}}"><i class="fa-solid fa-burger"></i></a>
                        </div>
                        <p>Burger</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('admincat','Breakfast')}}"><i class="fa-solid fa-pizza-slice"></i></a>
                        </div>
                        <p>Breakfast</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('admincat','Glace')}}"><i class="fa-solid fa-ice-cream"></i></a>
                        </div>
                        <p>Glaces</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('admincat','Dejeuner')}}"><i class="fa-solid fa-mug-hot"></i></a>
                        </div>
                        <p>Dejeuner</p>
                    </div>
                </div>
            </div>
            <hr class="divider">

            <a href="{{route('createfood')}}" class="btn">Ajouter un mets</a>

            <div class="main-detail">
                <h2 class="main-title">Menus Proposés</h2>
                <div class="detail-wrapper">
                    <div class="table_section">
                        <table>
                            <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Categorie</th>
                                    <th>Prix (fcfa)</th>
                                    <th>Temps de cuisson</th>
                                    <th>Recommandée</th>
                                    <th>Publiée</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($foods as $food)
                               <tr>
                                    <td style="display: flex; align-items:center; flex-wrap:wrap;justify-content:center"><img src="/storage/{{$food->picture}}" alt=""><span>{{$food->name}}</span></td>
                                    <td>{{$food->type}}</td>
                                    <td>{{$food->price}} fcfa</td>
                                    <td>{{$food->cookTime}}</td>
                                    <td> @if ($food->is_recommanded)
                                            <a href="{{route('recommandedfood',$food)}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">oui</a>
                                        @else
                                            <a href="{{route('recommandedfood',$food)}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">non</a>
                                        @endif
                                    </td>
                                    <td>@if (!$food->is_blocked)
                                            <a href="{{route('blockedfood',$food)}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">oui</a>
                                        @else
                                            <a href="{{route('blockedfood',$food)}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">non</a>
                                        @endif
                                    </td>
                                    <td> <a class="btn" href="{{route('editfood',$food)}}">Editer</a></td>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$foods->links("user.pagination")}}
            </div>
        </div>
   

@endsection