@extends('user.base')

@section('search')
    <div></div>
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

    <div class="main-detail">
        <h2 class="main-title" style="color:#0e6253;">Les commandes sur le site</h2>
            <div class="detail-wrapper">
                <div class="table_section">
                    <table>
                        <thead>
                            <tr>
                                <th>Date de commande</th>
                                <th>Food</th>
                                <th>Categorie</th>
                                <th>Quantité</th>
                                <th>Prix unitaire (fcfa)</th>
                                <th>Total</th>
                                <th>Confirmer la livraison</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($orders as $order)
                           @php 
                                $food = App\Models\Food::find($order->food_id);
                            @endphp
                           <tr>
                                <td>{{$order->created_at->format('d F Y \à H\hi')}}</td>
                                <td style="display: flex; align-items:center; flex-wrap:wrap;justify-content:center"><img src="/storage/{{$food->picture}}" alt=""><span>{{$food->name}}</span></td>
                                <td>{{$food->type}}</td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->priceU}} fcfa</td>
                                <td>{{$order->priceU * $order->quantity}} fcfa</td>
                                <td>@if ($order->sellerconfirmed)
                                        <a href="{{route('livreur',$order)}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">oui</a>
                                    @else
                                        <a href="{{route('livreur',$order)}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">non</a>
                                    @endif
                                </td>
                           </tr>
                           @endforeach          
                        </tbody>
                    </table>
                </div>        
   </div>
</div>
@endsection