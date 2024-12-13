<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;    
use App\Models\Purchases;
use Carbon\Carbon;
use App\Models\Car;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    public function create(){
        return view('customers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
        ]);

        Customer::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);

        return redirect('/users')->with('success', 'User created successfully!');
    }

    public function edit($userID){
        $user = Customer::findOrFail($userID);
        return view("customers.edit", compact('user'));
    }

    public function update(Request $request, $userID) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
        ]);
        $user = Customer::findOrFail($userID);
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);
        return redirect('/users')->with('success', 'User updated successfully!');
    }

    public function delete($userID){
        $user = Customer::find($userID);
        if ($user) {
            $user->delete();
            return redirect('/users')->with('success', 'User deleted successfully!');
        } else {
            return redirect('/users')->with('error', 'User not found.')->withInput();
        }
    }

    public function getPurchases($id) { 
        $purchases = Purchases::where('customer_id', $id)->with('car')->get(); 
        $purchasedData = $purchases->map(function($purchase) {
            return [
                'id' => $purchase->car->id,
                'model' => $purchase->car->model,
                'make' => $purchase->car->brand,
                'price' => $purchase->car->price,
                'year' => $purchase->car->year,
                'purchase_date' => $purchase->purchase_date
            ];
        });
        return response()->json($purchasedData); 
    }

    public function buyCar($userID){
        $cars = Car::whereNotIn('id', function($query){
            $query->select('car_id')->from('purchases');
        })->get();
        $buyerID = $userID;
        return view('customers.buyCar', compact('cars', 'buyerID'));
    }

    public function buyCarStore($uid, $cid){
        $purchase = Purchases::create([
            'customer_id' => $uid,
            'car_id' => $cid,
            'purchase_date' => Carbon::now(),
        ]);
        if ($purchase) {
            return redirect('/users')->with('success', "User ($uid) successfully bought car ($cid)");
        }
        return back()->with('error', "Failed to process the purchase.");
    }

    public function ownerCarEdit($id) { 
        $cars = Car::select('cars.*', 'purchases.purchase_date')
            ->join('purchases', 'cars.id', '=', 'purchases.car_id')
            ->where('purchases.customer_id', $id)
            ->get();
        return view('customers.ownerCarEdit', ['purchases' => $cars, 'ownerID' => $id]); 
    } 

    public function ownerCarDelete($id, $cid) {
        $purchase = Purchases::where('customer_id', $id)->where('car_id', $cid)->first(); 
        if ($purchase) { 
            $purchase->delete(); 
        } 
        return redirect('/users')->with('success', 'Car ownership deleted successfully'); 
    }

}
