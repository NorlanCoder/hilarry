@extends('user.base')

@section('search')
    <div></div>
@endsection

@section('contenu')

        <div class="main-menus" style="margin-top: 2rem">
            <div class="main-detail">
                <h2 class="main-title" style="color:#0e6253;">Historiques de vos commandes</h2>
                @foreach ($orders as $item)
                    <p style="margin: 0rem 1rem; margin-top:2rem; color:#0e6253; font-weight:bold">{{ $item->created_at->format('d F Y \à H\hi') }} </p>
                    <hr class="divider">
                    <div class="detail-wrapper">
                            <div class="table_section" >
                                <table >
                                    <thead>
                                        <tr>
                                            <th>Food</th>
                                            <th>Categorie</th>
                                            <th>Quantité</th>
                                            <th>Prix unitaire (fcfa)</th>
                                            <th>Total</th>
                                            <th>Confirmer la livraison</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($item->shopping as $orderitem)
                                    @php
                                            $order = App\Models\OrderItem::find($orderitem);
                                        
                                            $food = App\Models\Food::find($order->food_id);
                                        @endphp
                                    <tr>
                                            <td style="display: flex; align-items:center; flex-wrap:wrap;justify-content:center"><img src="/storage/{{$food->picture}}" alt=""><span>{{$food->name}}</span></td>
                                            <td>{{$food->type}}</td>
                                            <td>{{$order->quantity}}</td>
                                            <td>{{$order->priceU}} fcfa</td>
                                            <td>{{$order->priceU * $order->quantity}} fcfa</td>
                                            <td>@if ($order->userconfirmed)
                                                    <a href="{{route('livrer',$order)}}" style="background: #d9f2ee; padding:5px; border-radius: 3px; color:#555; text-decoration:none;">oui</a>
                                                @else
                                                    <a href="{{route('livrer',$order)}}" style="background: #f8d7da; padding:3px; border-radius: 3px; color:#555; text-decoration:none;">non</a>
                                                @endif
                                            </td>
                                    </tr>
                                    @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                        
                        
                    </div>
                    @endforeach   
            </div>
        </div>
   

@endsection