<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function listService()
    {
        $dataService = Service::get();

        return response()->json(['message' => 'success', 'data' => $dataService], 200);
    }

    public function createService(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'judul' => 'required',
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/service', $images->hashName());

        Service::create([
            'image' => $images->hashName(),
            'judul' => $validateData['judul'],
        ]);

        return response()->json(['message' => 'success'], 201);
    }

    public function updateService(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'judul' => 'required',
        ]);

        $dataService = Service::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($dataService->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/service', $images->hashName());
            $dataService->image = $images->hashName();
        }
        $dataService->judul = $validateData['judul'];
        $dataService->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function deleteService($id)
    {
        $dataService = Service::find($id);

        if (!$dataService) {
            return response()->json(['message' => 'no data found'], 400);
        }
        $dataService->delete();
        return response()->json(['message' => 'success'], 200);
    }
}
