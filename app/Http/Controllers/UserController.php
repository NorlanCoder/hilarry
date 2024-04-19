<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
           if( Auth::user()->status == 'admin'){
            $user->assignRole('admin');
           }
        }
        Validator::make($request->all(), [
            'name' =>['nullable'],
        ])->validated();
        $query = Food::query();
        if($request->input('name') !== null){
                    $query = $query->where('name','like', "%{$request->input('name')}%");
                }
        $cartitems = FacadesCart::instance('cart')->content();
       return view('user.home', [
        'recommandedfood' =>Food::where('is_recommanded', true)->orderBy('created_at', 'desc')->take(10)->get(),
        'foods' => $query->where('is_blocked', false)->orderBy('created_at', 'desc')->paginate(6),
        'cartitems' => $cartitems,
       ]);
    }

    public function indexrecom(string $name)
    {
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
           if( Auth::user()->status == 'admin'){
            $user->assignRole('admin');
           }
        }
        $cartitems = FacadesCart::instance('cart')->content();
       return view('user.home', [
        'recommandedfood' =>Food::where('is_recommanded', true)->orderBy('created_at', 'desc')->take(10)->get(),
        'foods' => Food::where('name','like', "%{$name}%")->where('is_blocked', false)->orderBy('created_at', 'desc')->paginate(6),
        'cartitems' => $cartitems,
       ]);
    }

    public function categorie(String $categorie)
    {
        $cartitems = FacadesCart::instance('cart')->content();
        return view('user.home', [
        'recommandedfood' =>Food::where('is_recommanded', true)->orderBy('created_at', 'desc')->take(10)->get(),
        'foods' => Food::where('type', $categorie)->orderBy('created_at', 'desc')->paginate(6),
        'cartitems' => $cartitems,
       ]);
    }

    public function show(Food $food)
    {
            return view('user.detail', [
                'food'=> $food,         
            ]);
    }

    public function listesFavories(Request $request){
        $cartitems = FacadesCart::instance('cart')->content();
        Validator::make($request->all(), [
            'name' =>['nullable'],
        ])->validated();
        $user = User::find(Auth::user()->id);
        if($request->input('name') !== null){
                    $query = $user->foods()->where('name','like', "%{$request->input('name')}%")->get();
                }else{
                    $query = $user->foods()->get();
                }
            
            return view('user.favories', [
                'favories' => $query,
                'cartitems' => $cartitems,
               ]);
        }     

    public function addfavorie(Food $food){   
            $user = User::find( Auth::user()->id );
            $favorie = $user->foods();
       
         if ($favorie) {
            $exist = $user->foods()->where('food_id', $food->id)->exists();

            if(!$exist){
                $user->foods()->attach($food);
                
            }else{
                $user->foods()->detach($food);
            }
         }else{
            $user->foods()->attach($food);
         }
         return redirect()->back();
        
     }

     public function transaction(Request $request){
        $transaction = $_POST;
        // dd($transaction);
       foreach ($transaction as $key => $value) {
          if ($key === 'transaction-status') {
            $status = $value;
          }
          if ($key === 'transaction-id') {
            $transaction_id = $value;
          }
       }

       if ($status == 'approved') {
        $cartitems = FacadesCart::instance('cart')->content();
        $pay = FacadesCart::instance('cart')->subtotal() +500;

        $orderitems = [];

        DB::beginTransaction();

        foreach ($cartitems as $value) {
            $orderitem = OrderItem::create([
                'user_id' => Auth::user()->id,
                'food_id' => $value->model->id,
                'priceU' => $value->model->price,
                'quantity' => $value->qty,
            ]);
            $orderitems[] = $orderitem->id;
        }

        Order::create([
            'user_id' => Auth::user()->id,
            'shopping' => $orderitems,
            'pay' => $pay,
            'transaction' => [$transaction_id],
        ]);
        
        FacadesCart::instance('cart')->destroy();
        DB::commit();
       } else if($status == 'pending'){
           return back();
       }

        return view('user.transaction',[
            'status' => $status,
            'cartitems' => $cartitems,
        ]);
     }

     public function history(){
        $cartitems = FacadesCart::instance('cart')->content();
        
        return view('user.historique', [
            'orders' =>Order::where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->get(),
            'cartitems' => $cartitems
           ]);
     }

     public function livrer(OrderItem $orderitem){
        
        if (!$orderitem->userconfirmed) {
            $orderitem->update(['userconfirmed' => true]);
        }else{
            $orderitem->update(['userconfirmed' => false]); 
        }

         return redirect()->back();
    }

    public function compte(){
        $cartitems = FacadesCart::instance('cart')->content();
        return view('user.compte',[
            'cartitems' => $cartitems,
        ]);
    }

    public function update(Request $request)
     {
        dd($request->file('profil'));
       Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'min:1'],
            'phone' => ['nullable', 'numeric', 'min:8'],
            'adresse' => ['nullable', 'string', 'min:1'],
            'profil' => ['image'],
        ])->validate();
        $user = User::find( Auth::user()->id);
        
         DB::beginTransaction();

         

             if($request->file('profil')){
                 Storage::disk('public')->delete($user->profil);
                 $img =  $request->profil;
                 $imgPath =  $img->store('food','public');
                 
             } else{
                 $imgPath = $user->profil;
             }
               
            $user->update([
                 'name' =>  $request->name ,
                 'email' => $user->email,
                 'phone' =>  $request->phone ,
                 'adresse' =>  $request->adresse ,
                 'profil' => $imgPath,
             ]);
         DB::commit();    
         return to_route('compte')->with('succès', 'Votre profil a été mise à jour.');
     }

}
