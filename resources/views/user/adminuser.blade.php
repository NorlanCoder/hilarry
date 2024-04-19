@extends('user.base')

@section('search')

    <form class="search" action="" method="get">
        @csrf
        <input type="text" name="name" placeholder="Vous rechercher un utilisataeur ?">
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
                    <h2 class="main-title">Filtrer les <br>Utilisateurs</h2>
                    <div class="main-arrow">
                        <i class="back-menu fas fa-chevron-left"></i>
                        <i class="next-menu fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="filter-wrapper">
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('indexuser')}}"></a><i class="fa-solid fa-user-tie"></i>
                        </div>
                        <p>Tous</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('blocklist',1)}}"><i class="fa-solid fa-user-lock"></i></a>
                        </div>
                        <p>Bloqué</p>
                    </div>
                    <div class="filter-card">
                        <div class="filter-icon">
                            <a href="{{route('blocklist',0)}}"><i class="fa-solid fa-unlock"></i></a>
                        </div>
                        <p>Non bloqué</p>
                    </div>
                </div>
            </div>
            <hr class="divider">

            <div class="main-detail">
                <h2 class="main-title">Les utilisateurs du site</h2>
                <p>Donnez des permissions à vos utilisateurs</p>
                <ul>
                    <li>Le chiffre 1 indique qu'il a la permission de valider les commandes</li>
                    <li>Le chiffre 2 indique qu'il a la permission de bloquer des utilisateurs</li>
                    <li>Le chiffre 3 indique qu'il a la permission de publier les mets</li>
                    <li>Le chiffre 4 indique qu'il a la permission de mettre en recommandation un mets</li>
                </ul>
                <div class="detail-wrapper">
                    <div class="table_section">
                       <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Adresse</th>
                                    <th>Téléphone</th>
                                    <th>Bloqué</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->adresse}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>
                                        @if ($user->is_blocked)
                                            <a href="{{route('blockeduser',$user)}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">oui</a>
                                        @else
                                            <a href="{{route('blockeduser',$user)}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">non</a>
                                        @endif
                                    </td>
                                    <td style="display: flex;flex-wrap:wrap; gap:.5rem">
                                     
                                            @if ($user->can('valide order')) 
                                                <a href="{{route('allow',['valide order',$user])}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">1</a>
                                                 @else 
                                                    <a href="{{route('allow',['valide order',$user])}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">1</a>
                                            @endif
                                        
                                        
                                        
                                            @if ($user->can('blocked user'))
                                                <a href="{{route('allow',['blocked user',$user])}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">2</a>
                                                @else 
                                                    <a href="{{route('allow',['blocked user',$user])}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">2</a>
                                                @endif
                                        

                                        
                                            @if ($user->can('share food')) 
                                                <a href="{{route('allow',['share food',$user])}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">3</a>
                                                 @else 
                                                    <a href="{{route('allow',['share food',$user])}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">3</a>
                                               @endif
                                        

                                            
                                                @if ($user->can('do recommandation')) 
                                                    <a href="{{route('allow',['do recommandation', $user])}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">4</a>
                                                     @else 
                                                        <a href="{{route('allow',['do recommandation', $user])}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">4</a>
                                                 @endif   
                                            

                                    </td>
                                </tr>            
                                @endforeach
                            </tbody>
                       </table>      
                    </div>
                </div>
            </div>
        </div>
   

@endsection