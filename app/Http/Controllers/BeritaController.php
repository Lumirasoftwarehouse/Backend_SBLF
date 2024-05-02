<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function listBerita()
    {
        $data = Berita::get();
        return response()->json(['message' => 'success', 'data' => $data]);
    }

    public function createBerita(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max size 2MB
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/berita', $images->hashName());
        
        $berita = new Berita([
            'image' => $images->hashName(),
            'judul' => $validateData['judul'],
            'deskripsi' => $validateData['deskripsi'],
        ]);
        
        $berita->save();

        return response()->json(['message' => 'Berita created successfully'], 201);
    }

    public function updateBerita(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max size 2MB
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $berita = Berita::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($berita->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/berita', $images->hashName());
            $berita->image = $images->hashName();
        }

        $berita->judul = $validateData['judul'];
        $berita->deskripsi = $validateData['deskripsi'];
        $berita->save();

        return response()->json(['message' => 'Berita updated successfully'], 200);
    }

    public function deleteBerita($id)
    {
        $berita = Berita::findOrFail($id);
        Storage::delete($berita->image);
        $berita->delete();
        return response()->json(['message' => 'Berita deleted successfully'], 200);
    }
}
