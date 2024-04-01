<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrientationValue;
use Illuminate\Support\Facades\Storage;

class OrientationValueController extends Controller
{
    public function listOrientationValue()
    {
        $dataOrientation = OrientationValue::get();

        return response()->json(['message' => 'success', 'data' => $dataOrientation], 200);
    }

    public function createOrientationValue(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required'
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/orientationValue', $images->hashName());

        $orientationValue = new OrientationValue([
            'image' => $images->hashName(),
            'judul' => $validateData['judul'],
        ]);
        
        $orientationValue->save();

        return response()->json(['message' => 'success'], 201);
    }

    public function updateOrientationValue(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required',
            'judul' => 'required'
        ]);

        $dataOrientation = OrientationValue::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($dataOrientation->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/orientationValue', $images->hashName());
            $dataOrientation->image = $images->hashName();
        }

        $dataOrientation->judul = $validateData['judul'];
        $dataOrientation->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function deleteOrientationValue($id)
    {
        $dataOrientation = OrientationValue::findOrFail($id);
        if ($dataOrientation) {
            $dataOrientation->delete();
            return response()->json(['message' => 'success'], 200);
        }
        return response()->json(['message' => 'failed'], 400);
    }
}
