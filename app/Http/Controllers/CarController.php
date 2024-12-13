<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Purchases;

class CarController extends Controller
{
    public function index(){
        $cars = Car::all();

        return view('cars.index', [
            'cars' => $cars
        ]);
    }

    public function create(){
        return view('cars.create');
    }

    public function store(Request $request)
    {   
        $car = Car::create([
            'model' => $request->model,
            'brand' => $request->make,
            'price' => $request->price,
            'year' => $request->year,
        ]);

        if($car){
            return redirect()->route('cars.list');
        }
    }

    public function edit($carID){
        $car = Car::find($carID);
        return view("cars/edit", [
            'car' => $car
        ]);
    }

    public function update($carID){
        $car = Car::find($carID);
        $car->model = request()->model; 
        $car->brand = request()->make;
        $car->price = request()->price;
        $car->year = request()->year;
        $car->save();

        return redirect()->route('cars.list');
    }

    public function delete($carID){
        $car = Car::find($carID);
        $car->delete();

        return redirect()->route('cars.list');
    }

    public function getPurchases($id){
        $purchases = Purchases::where('car_id', $id)->with('customer')->get();
        $purchasedData = $purchases->map(function($purchase) {
            return [
                'id' => $purchase->id,
                'name' => $purchase->customer->name,
                'phone' => $purchase->customer->phone
            ];
        });
        return response()->json($purchasedData);
    }

}
