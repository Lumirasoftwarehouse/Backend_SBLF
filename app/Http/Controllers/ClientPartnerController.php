<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientPartner;
use Illuminate\Support\Facades\Storage;

class ClientPartnerController extends Controller
{
    public function listClientPartner()
    {
        $dataClient = ClientPartner::get();

        return response()->json(['message' => 'success', 'data' => $dataClient], 200);
    }

    public function createClientPartner(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/clientPartner', $images->hashName());

        $clientPartner = new ClientPartner([
            'image' => $images->hashName(),
        ]);
        
        $clientPartner->save();

        return response()->json(['message' => 'success'], 201);
    }

    public function updateClientPartner(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required',
        ]);

        $dataClient = ClientPartner::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($dataClient->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/clientPartner', $images->hashName());
            $dataClient->image = $images->hashName();
        }
        $dataClient->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function deleteClientPartner($id)
    {
        $dataClient = ClientPartner::findOrFail($id);
        if ($dataClient) {
            $dataClient->delete();
            return response()->json(['message' => 'success'], 200);
        }
        return response()->json(['message' => 'failed'], 400);
    }
}
