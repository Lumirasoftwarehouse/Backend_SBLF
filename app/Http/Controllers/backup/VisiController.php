<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visi;
use App\Models\Misi;

class VisiController extends Controller
{
    public function visiMisi()
    {
        $dataVisi = Visi::get();
        $dataMisi = Misi::get();
        return response()->json(['message' => 'success', 'visi' => $dataVisi, 'misi' => $dataMisi], 200);
    }

    public function getVisi()
    {
        $dataVisi = Visi::get();
        return response()->json(['message' => 'success', 'data' => $dataVisi], 200);
    }

    public function createVisi(Request $request)
    {
        $validatedData = $request->validate([
            'visi' => 'required|string'
        ]);

        $visi = Visi::first();

        if ($visi) {
            $visi->visi = $validatedData['visi'];
            $visi->save();
            return response()->json(['message' => 'success'], 201);
        }

        Visi::create([
            'visi' => $validatedData['visi']
        ]);

        return response()->json(['message' => 'success'], 201);
    }
    
    public function updateVisi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'visi' => 'required|string'
        ]);
        
        $dataVisi = Visi::find($id);
        if ($dataVisi) {
            $dataVisi->update(['visi' => $validatedData['visi']]);
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'Visi not found'], 404);
    }
    
    public function deleteVisi($id)
    {
        $dataVisi = Visi::find($id);
        if ($dataVisi) {
            $dataVisi->delete();
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'Visi not found'], 404);
    }
}
