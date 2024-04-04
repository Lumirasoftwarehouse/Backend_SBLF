<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\BenefitProgram;
use App\Models\Opportunity;
use App\Models\Berita;

class AboutController extends Controller
{
    public function dataLandingPage()
    {
        $dataAbout = About::get();
        $dataVisi = Visi::get();
        $dataMisi = Misi::get();
        $dataBenefits = BenefitProgram::get();
        $dataOpportunity = Opportunity::get();
        $dataBerita = Berita::get();

        return response()->json([
            'about' => $dataAbout,
            'visi' => $dataVisi,
            'misi' => $dataMisi,
            'benefit' => $dataBenefits,
            'opportunity' => $dataOpportunity,
            'berita' => $dataBerita,
        ]);
    }

    public function getAbout()
    {
        $dataAbout = About::get();
        return response()->json(['message' => 'success', 'data' => $dataAbout], 200);
    }

    public function createAbout(Request $request)
    {
        $validatedData = $request->validate([
            'about' => 'required|string'
        ]);

        $dataAbout = About::first();
        if ($dataAbout) {
            $dataAbout->about = $validatedData['about'];
            $dataAbout->save();
            return response()->json(['message' => 'success'], 201);
        }

        About::create([
            'about' => $validatedData['about']
        ]);

        return response()->json(['message' => 'success'], 201);
    }
    
    public function updateAbout(Request $request, $id)
    {
        $validatedData = $request->validate([
            'about' => 'required|string'
        ]);
        
        $dataAbout = About::find($id);
        if ($dataAbout) {
            $dataAbout->update(['about' => $validatedData['about']]);
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'About not found'], 404);
    }
    
    public function deleteAbout($id)
    {
        $dataAbout = About::find($id);
        if ($dataAbout) {
            $dataAbout->delete();
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'About not found'], 404);
    }
}
