<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function listAnggota()
    {
        $dataAnggota = Anggota::get();

        return response()->json(['message' => 'success', 'data' => $dataAnggota], 200);
    }

    public function createAnggota(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/anggota', $images->hashName());

        Anggota::create([
            'image' => $images->hashName(),
            'nama' => $validateData['nama'],
            'deskripsi' => $validateData['deskripsi']
        ]);

        return response()->json(['message' => 'success'], 201);
    }

    public function updateAnggota(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $dataAnggota = Anggota::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($dataAnggota->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/anggota', $images->hashName());
            $dataAnggota->image = $images->hashName();
        }
        $dataAnggota->nama = $validateData['nama'];
        $dataAnggota->deskripsi = $validateData['deskripsi'];
        $dataAnggota->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function deleteAnggota($id)
    {
        $dataAnggota = Anggota::find($id);

        if (!$dataAnggota) {
            return response()->json(['message' => 'no data found'], 400);
        }
        $dataAnggota->delete();
        return response()->json(['message' => 'success'], 200);
    }
}
