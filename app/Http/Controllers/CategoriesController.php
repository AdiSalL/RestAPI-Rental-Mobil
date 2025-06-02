<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Categories::all();

        if($categories->count() == 0) {
            return response()->json([
                'message' => "Belum ada kategori"
            ]);
        }
        
        return response()->json([
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string"
        ]);
        
        $category = new Categories();
        $category->fill($validated);
        $category->save();

        return response()->json([
            "message" => "Berhasil memasukkan kategori",
            "category" => $category->name
        ]);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            "name" => "nullable|string|max:255",
            "description" => "nullable|string"
        ]);
        
        $category = Categories::find($id);
        
        if(!$category) {
            return response()->json([
                "message" => "Kategori dengan ID {$id} Tidak Ditemukan",
            ]);
        }
        if(isset($validated["name"])) {
            $category->name = $validated["name"];
        }

        if(isset($validated["description"])) {
            $category->description = $validated["description"];
        }
        
        $category->save()   ;

        return response()->json([
            "message" => "Berhasil mengupdate kategori",
            "category" => $category
        ]);
    }

    public function delete($id) {
        $category = Categories::find($id);
        if(!$category) {
            return response()->json([
                "message" => "Kategori dengan ID {$id} Tidak Ditemukan",
            ]);
        }

        $category->delete();

        return response()->json([
            "message" => "Berhasil menghapus kategori",
            "category" => $category->name
        ]);
    }
}
