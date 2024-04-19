<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>FoodTime</title>
</head>
<body>

    <div class="sidebar">
        <i class="fa-solid fa-circle-xmark" id="close"></i>
        <h1 class="logo">FoodTime</h1>
        <div class="sidebar-menu">
            <a href="{{route('homefood')}}"><i class="fa-solid fa-home"></i> Accueil</a>
            <a href=""><i class="fa-solid fa-wallet"></i> Menus</a>
            <a href="{{route('favories')}}"><i class="fa-solid fa-heart"></i> Mes favories</a>
            <a href="{{route('history')}}"><i class="fa-solid fa-clock-rotate-left"></i> Historiques</a>
            <a href="{{route('compte')}}"><i class="fa-solid fa-user"></i> Mon compte</a>
            <a href=""><i class="fa-solid fa-envelope"></i> Contactez-nous</a>
            @auth
                @php
                    $user = App\Models\User::find(Auth::user()->id)
                @endphp
                @if ($user->can('valide order') || $user->can('share food') || $user->can('blocked user') || $user->can('do recommandation'))
                     <a href="{{route('indexfood')}}"><i class="fa-solid fa-envelope"></i> Administration</a>
                @endif
            @endauth
           
        </div>
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Deconnexion</button>
            </form>
        </div>
    </div>

    <div class="main">
        <div class="main-navbar">
            <i class="fa-solid fa-bars" id="menu-btn"></i>

           @yield('search')
            
            <div class="profile">
                @if (Auth::check())
                    <div style="margin-left: 3rem"> Bonjour, <br>{{Auth::user()->name}}</div>
                @else
                    <a href="{{route('login')}}" style="margin-left: 3rem; padding:.5rem 1rem; border:.1rem solid #0e6253 ; border-radius: 5rem; text-decoration: none; color:#0e6253"> Se connecter</a>
                @endif
                   
                
                
                <div class="cart-nav" id="cart">
                    @if (Cart::instance('cart')->content()->count() > 0)
                    <span>{{Cart::instance('cart')->content()->count()}}</span>
                    @endif
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>

         @yield('contenu')

    </div>


    <div class="dashboard-order">

        <i class="fa-solid fa-xmark" id="close"></i>
        <h3>Vos commandes</h3>
        @if ($cartitems->Count() > 0)
            <div class="order-address">
                <p>Adresse de livraison</p>
                    <input type="text" id="adresse" name="adresse" value="Calavi{{--Auth::auth()->adresse--}}">
            </div>
            <div class="order-time">
                <span> <i class="fas fa-clock"></i> 30min</span>  
                <span><i class="fas fa-map-maker"></i> 2Km</span>
            </div>
            <div class="order-wrapper">
                @foreach ($cartitems as $orderitem)
                    <div class="order-card">
                        <img class="order-image" src="/storage/{{$orderitem->model->picture}}" alt="">
                        <div class="order-detail">
                            <p>{{$orderitem->model->description}}</p>
                            <span class="order-price">{{$orderitem->subtotal()}}fcfa</span> <input type="number" class="quantite" name="quantite" data-rowId="{{$orderitem->rowId}}" value="{{$orderitem->qty}}" onchange="updateQuantity(this)">
                        </div>
                        <i onclick="deleteItem('{{$orderitem->rowId}}')" class="fas fa-trash"></i>  
                    </div>
                @endforeach
            
            </div>
            <hr class="divider">
            <div class="order-total">
                <p>Total <span>{{Cart::instance('cart')->subtotal()}} fcfa</span></p>
                <p>Livraison <span>500 fcfa</span></p>

                <hr class="divider">
                <p>Total <span>{{Cart::instance('cart')->subtotal() + 500}} fcfa</span></p>
            </div>
            
            <form action="{{route('trans')}}" method="POST">
                @csrf
                @method('post')
                <input type="hidden" name="field" value="test">
                <script
                src="https://cdn.fedapay.com/checkout.js?v=1.1.7"
                data-public-key="pk_sandbox_4YqP0wmXdBvAHj5w52MAedjJ"
                data-button-text='Payer'
                data-button-class="checkout"
                data-transaction-amount="{{Cart::instance('cart')->subtotal()  + 500}}"
                data-transaction-description="Description de la transaction"
                data-currency-iso="XOF">
              </script>
               </form> 
              
        @else
            <p style="text-align: center">Votre panier est vide </p>
        @endif

        <form action="{{route('cart.updatecart')}}" method="post" id="updatecart">
            @csrf
            @method('put')
            <input type="hidden" id="rowId" name="rowId">
            <input type="hidden" id="quantite" name="quantite">
          </form>
        
          <form action="{{route('cart.remove')}}" method="post" id="deletecart">
            @csrf
            @method('delete')
            <input type="hidden" id="rowIdD" name="rowId">
          </form>

    </div>

  <script src="{{asset('css/script.js')}}" defer></script>
  <script>
    let close = document.querySelector('.dashboard-order #close'); 
    let panier = document.querySelector('.dashboard-order');
    let panierIcon = document.querySelector('#cart');

    window.scroll = () => {
        panier.classList.remove("active")
    }

    panierIcon.onclick = () => {
        
        panier.classList.add("active")
        console.log(panier.classList)
    }

    close.onclick = () => {
        panier.classList.remove("active")
}

function updateQuantity(qty){
        document.querySelector('#rowId').value = qty.getAttribute('data-rowId');
        document.querySelector('#quantite').value = qty.value;
        document.querySelector('#updatecart').submit();
    }

    function deleteItem(rowId){
        document.querySelector('#rowIdD').value = rowId;
      
        document.querySelector('#deletecart').submit();
    }
  </script>
</body>
</html>