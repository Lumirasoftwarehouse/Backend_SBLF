<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Misi;

class MisiController extends Controller
{
    public function getMisi()
    {
        $dataMisi = Misi::get();
        return response()->json(['message' => 'success', 'data' => $dataMisi], 200);
    }

    public function createMisi(Request $request)
    {
        $validatedData = $request->validate([
            'misi' => 'required|string'
        ]);

        Misi::create([
            'misi' => $validatedData['misi']
        ]);

        return response()->json(['message' => 'success'], 201);
    }
    
    public function updateMisi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'misi' => 'required|string'
        ]);
        
        $dataMisi = Misi::find($id);
        if ($dataMisi) {
            $dataMisi->update(['misi' => $validatedData['misi']]);
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'Misi not found'], 404);
    }
    
    public function deleteMisi($id)
    {
        $dataMisi = Misi::find($id);
        if ($dataMisi) {
            $dataMisi->delete();
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'Misi not found'], 404);
    }
}
