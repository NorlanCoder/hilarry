<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\Cast\String_;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
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
        $cartitems = Cart::instance('cart')->content();
       return view('user.admin', [
        'foods' => $query->orderBy('created_at', 'desc')->paginate(6),
        'cartitems' => $cartitems,
       ]);
    }

    public function categorie(String $categorie)
    {
        $cartitems = Cart::instance('cart')->content();
        return view('user.admin', [
        'foods' => Food::where('type', $categorie)->orderBy('created_at', 'desc')->get(),
        'cartitems' => $cartitems,
       ]);
    }

    public function userblock(Bool $bool)
    {

        if ($bool){
            $query = User::where('is_blocked', true)->orderBy('created_at', 'desc')->get();
        }else{
            $query = User::where('is_blocked', false)->orderBy('created_at', 'desc')->get();

        }
        $cartitems = Cart::instance('cart')->content();
        return view('user.adminuser', [
        'users' => $query,
        'cartitems' => $cartitems,
       ]);
    }

    public function indexuser(Request $request)
    {
        $cartitems = Cart::instance('cart')->content();
        Validator::make($request->all(), [
            'name' =>['nullable'],
        ])->validated();
        $query = User::query();
        if($request->input('name') !== null){
                    $query = $query->where('name','like', "%{$request->input('name')}%");
                }
       return view('user.adminuser', [
        'users' => $query->orderBy('created_at', 'desc')->get(),
        'cartitems' => $cartitems,
       ]);
    }

    public function create()
    {
        $cartitems = Cart::instance('cart')->content();
        $food =  new Food();
        return view('user.addfood', [
            'food'=> $food,
            'cartitems' => $cartitems,   
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        Validator::make($request->all(), [
            'name' =>['required'],
            'type' =>['required'],
            'price' =>['required', 'integer', 'min:1'],
            'description' =>['required'],
            'cookTime' =>['required'],
            'picture' =>['required', 'image'],
        ])->validate();

        
                   $img =  $request->picture;
                   $imgPath =  $img->store('food','public');

      Food::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'cookTime' => $request->cookTime,
            'description' => $request->description,
            'picture' => $imgPath,
        ]);

        
        return to_route('indexfood')->with('succès', 'Le nouvel ajout a bien été sauvegardé.');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        $cartitems = Cart::instance('cart')->content();
        return view('user.addfood', [
            'food'=> $food,
            'cartitems' => $cartitems,
        ]);
    }

     /**Livre
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food)
    {
        Validator::make($request->all(), [
            'name' =>['required'],
            'type' =>['required'],
            'cookTime' => ['required'],
            'price' =>['required', 'integer', 'min:1'],
            'description' =>['required'],
            'picture' =>['image'],
        ])->validate();

        DB::beginTransaction();
            if($request->file('picture')){
                Storage::disk('public')->delete($food->picture);
                $img =  $request->picture;
                $imgPath =  $img->store('food','public');
            } else{
                $imgPath = $food->picture;
            }
      
            $food->update([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'cookTime' => $request->cookTime,
                'description' => $request->description,
                'picture' => $imgPath,
            ]);
            
        DB::commit();    
        return to_route('indexfood')->with('succès', 'Le bien a été mise à jour.');
    }

    public function blockeduser(User $user){
        $currentuser = User::find(Auth::user()->id);
        if ($currentuser->hasPermissionTo('blocked user')) {
            if (!$user->is_blocked) {
                $user->update(['is_blocked' => true]);
            }else{
                $user->update(['is_blocked' => false]);        
            }
        }
         return redirect()->back();
    }

    public function blockedfood(Food $food){
        $currentuser = User::find(Auth::user()->id);
    if($currentuser->hasPermissionTo('share food')){
        if (!$food->is_blocked) {
            $food->update(['is_blocked' => true]);
        }else{
            $food->update(['is_blocked' => false]);
        }
    }
         return redirect()->back();
    }

    public function recommandedfood(Food $food){
        $currentuser = User::find(Auth::user()->id);
        if($currentuser->hasPermissionTo('do recommandation')){
            if (!$food->is_recommanded) {
                $food->update(['is_recommanded' => true]);
               
            }else{
                $food->update(['is_recommanded' => false]);
            }
        }
  return redirect()->back();
    }

    public function livrer(OrderItem $orderitem){
        $currentuser = User::find(Auth::user()->id);
        if($currentuser->hasPermissionTo('valide order')){
            if (!$orderitem->sellerconfirmed) {
                $orderitem->update(['sellerconfirmed' => true]);
               
            }else{
                $orderitem->update(['sellerconfirmed' => false]);
            }
        }
         return redirect()->back();
    }

    public function history(){
        $cartitems = Cart::instance('cart')->content();
        return view('user.order', [
            'orders' =>OrderItem::orderBy('created_at', 'desc')->get(),
            'cartitems' => $cartitems
           ]);
     }

     public function permission(string $permission,User $usercible){
        $user = User::find(Auth::user()->id);

       if ($user->hasRole('admin')) {
            if ($usercible->can($permission)) {
                $usercible->revokePermissionTo($permission);
                $usercible->save();
               

            } else {
                $usercible->givePermissionTo($permission);
                $usercible->save();
                
            } 
       }
        return redirect()->back(); 
     }

     public function role(string $role){
        $user = User::find(Auth::user()->id);
        
        if ($user->hasRole($role)) {
            $user->assignRole('user');
        } else {
            $user->assignRole($role);
        }  
     }

}
