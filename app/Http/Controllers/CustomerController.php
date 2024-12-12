<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;    

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

        // Pass the user data to the view
        return view("customers.edit", compact('user'));
    }

    public function update(Request $request, $userID) {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
        ]);
    
        // Find the user and update their details
        $user = Customer::findOrFail($userID);
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);
    
        // Redirect back to the user list with a success message
        return redirect('/users')->with('success', 'User updated successfully!');
    }

    public function delete($userID)
    {
        // Find the user by their ID
        $user = Customer::find($userID);

        if ($user) {
            // If the user exists, delete them
            $user->delete();

            // Redirect back with a success message
            return redirect('/users')->with('success', 'User deleted successfully!');
        } else {
            // If the user does not exist, return an error message
            return redirect('/users')->with('error', 'User not found.')->withInput();
        }
    }

    public function getPurchases($id) { 
        $purchases = Purchase::where('customer_id', $id)->with('car')->get(); 
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
}
