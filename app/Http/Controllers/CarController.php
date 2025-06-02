<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    //
    public function index() {
        $cars = Car::with('category')->get();
        
        return response()->json([   
            "cars" => $cars
        ]);
    }

    public function store(Request $request) {   
        $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|integer',
                'color' => 'required|string',
                'status' => 'required|string|in:available,unavailable',
                'seat' => 'required|integer',
                'cc' => 'required|integer',
                'top_speed' => 'required|integer',
                'description' => 'nullable|string',
                'location' => 'required|string',
                'image_url' => 'nullable|url',
                'category_id' => 'required|exists:categories,id',
            ]);

        $car = Car::create($validated);

        return response()->json([
            'message' => 'Mobil berhasil ditambahkan',
            'data' => $car->load('category')
        ], 200);
    }

    public function detail($id) {
        $car = Car::with('category')->findOrFail($id);
        return response()->json($car);
    }


    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'color' => 'required|string',
            'status' => 'required|string|in:available,unavailable',
            'seat' => 'required|integer',
            'cc' => 'required|integer',
            'top_speed' => 'required|integer',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
        ]);

        $car = Car::with('category')->findOrFail($id);
        $car->update($validated);
        return response()->json([
        'message' => 'Mobil berhasil dihapus',
        'data' => $car->load('category')
    ], 201);
    
    }

    public function destroy($id) {
        $car = Car::with('category')->findOrFail($id);
        $car->delete();
        return response()->json([
            "message" => "Mobil dengan $id berhasil dihapus"
        ]);
    }
}
