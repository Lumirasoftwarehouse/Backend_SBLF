<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Storage;

class OpportunityController extends Controller
{
    public function listOpportunity()
    {
        $data = Opportunity::get();
        return response()->json(['message' => 'success', 'data' => $data]);
    }

    public function createOpportunity(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/images', $images->hashName());
        
        $opportunity = new Opportunity([
            'image' => $images->hashName(),
            'judul' => $validateData['judul'],
            'deskripsi' => $validateData['deskripsi'],
        ]);
        
        $opportunity->save();

        return response()->json(['message' => 'Opportunity created successfully'], 201);
    }

    public function updateOpportunity(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $opportunity = Opportunity::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($opportunity->image);

            // Store new image
            // $imagePath = $request->file('image')->store('public/images');

            $images = $validateData['image'];
            $images->storeAs('public/images', $images->hashName());

            $opportunity->image = $images->hashName();
        }

        $opportunity->judul = $validateData['judul'];
        $opportunity->deskripsi = $validateData['deskripsi'];
        $opportunity->save();

        return response()->json(['message' => 'Opportunity updated successfully'], 200);
    }

    public function deleteOpportunity($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        Storage::delete($opportunity->image);
        $opportunity->delete();
        return response()->json(['message' => 'Opportunity deleted successfully'], 200);
    }
}
