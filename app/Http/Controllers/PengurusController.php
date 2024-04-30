<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengurus;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    public function listPengurus()
    {
        $dataPengurus = Pengurus::get();

        return response()->json(['message' => 'success', 'data' => $dataPengurus], 200);
    }

    public function createPengurus(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/pengurus', $images->hashName());

        Pengurus::create([
            'image' => $images->hashName(),
            'nama' => $validateData['nama'],
            'deskripsi' => $validateData['deskripsi']
        ]);

        return response()->json(['message' => 'success'], 201);
    }

    public function updatePengurus(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $dataPengurus = Pengurus::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($dataPengurus->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/pengurus', $images->hashName());
            $dataPengurus->image = $images->hashName();
        }
        $dataPengurus->nama = $validateData['nama'];
        $dataPengurus->deskripsi = $validateData['deskripsi'];
        $dataPengurus->save();
        
        return response()->json(['message' => 'success'], 200);
    }

    public function deletePengurus($id)
    {
        $dataPengurus = Pengurus::find($id);

        if (!$dataPengurus) {
            return response()->json(['message' => 'no data found'], 400);
        }
        $dataPengurus->delete();
        return response()->json(['message' => 'success'], 200);
    }
}
