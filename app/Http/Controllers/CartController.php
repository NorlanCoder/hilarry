<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use \App\Models\Book;
use App\Models\Food;
use \App\Models\OrderItem;
use \App\Models\Order;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){

        $cartitems = FacadesCart::instance('cart')->content();
        
        return view('user.base',[
            'cartitems' => $cartitems,
        ]);     
    }

    public function addcart(Food $food){
        FacadesCart::instance('cart')->add(['id' => $food->id, 'name' => $food->name, 'qty' => 1, 'price' => $food->price ])->associate('\App\Models\Food');  
        return back();
    }

    public function updatecard(Request $request){
        FacadesCart::instance('cart')->update($request->rowId, $request->quantite);
        return back();
    }

    public function removeItem(Request $request){
        $rowId = $request->rowId;
        FacadesCart::instance('cart')->remove($rowId);
        return back();
    }

    public function payementPage(){
        return view('users.payement');
    }

    public function checkout(Request $request){

        dd('caedfg');
        $cartitems = FacadesCart::instance('cart')->content();
        $orderitems = [];

        foreach($cartitems as $cartitem){
            $orderItem = new OrderItem();
            $orderItem->user_id = auth()->id();
            $orderItem->book_id = $cartitem->model->id; 
            $orderItem->quantity = $cartitem->qty;
            $orderItem->priceT = $cartitem->subtotal();
            $orderItem->save();

            $orderitems[]= $orderItem->id;
        }

        $order = new Order();
        $order->user_id = auth()->id(); 
        $order->shopping =  $orderitems;
        $order->pay = FacadesCart::instance('cart')->total();
        $order->save();

        return to_route('homebook')->with('sucess', 'Vos commandes ont bien été prise en compte.');
    }
}

