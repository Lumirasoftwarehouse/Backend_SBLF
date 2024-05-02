<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalTrend;
use App\Models\Quote;
use App\Models\Berita;
use App\Models\OrientationValue;
use App\Models\ClientPartner;
use App\Models\About;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\Opportunity;
use App\Models\BenefitProgram;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class GlobalTrendController extends Controller
{
    public function dataProfile()
    {
        $dataAbout = About::get();
        $dataVisi = Visi::get();
        $dataMisi = Misi::get();
        $dataOpportunity = Opportunity::get();
        $dataBenefit = BenefitProgram::get();
        $dataTrend = GlobalTrend::get();
        $dataQuote = Quote::get();
        $dataValue = OrientationValue::get();
        $dataClient = ClientPartner::get();
        $dataService = Service::get();
        $dataBerita = Berita::get();
        
        return response()->json([
            'message' => 'success',
            'dataAbout' => $dataAbout,
            'dataVisi' => $dataVisi,
            'dataMisi' => $dataMisi,
            'dataOpportunity' => $dataOpportunity,
            'dataBenefit' => $dataBenefit,
            'dataTrend' => $dataTrend,
            'dataQuote' => $dataQuote,
            'dataValue' => $dataValue,
            'dataClient' => $dataClient,
            'dataService' => $dataService,
            'dataBerita' => $dataBerita,
        ], 200);
    }

    public function listGlobalTrend()
    {
        $dataTrend = GlobalTrend::get();

        return response()->json(['message' => 'success', 'data' => $dataTrend], 200);
    }

    public function createGlobalTrend(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required'
        ]);

        $images = $validateData['image'];
        $images->storeAs('public/globalTrend', $images->hashName());

        $globalTrend = new GlobalTrend([
            'image' => $images->hashName(),
            'judul' => $validateData['judul'],
        ]);
        
        $globalTrend->save();

        return response()->json(['message' => 'success'], 201);
    }

    public function updateGlobalTrend(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required',
            'judul' => 'required'
        ]);

        $dataTrend = GlobalTrend::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::delete($dataTrend->image);

            // Store new image
            $images = $validateData['image'];
            $images->storeAs('public/globalTrend', $images->hashName());
            $dataTrend->image = $images->hashName();
        }

        $dataTrend->judul = $validateData['judul'];
        $dataTrend->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function deleteGlobalTrend($id)
    {
        $dataTrend = GlobalTrend::findOrFail($id);
        if ($dataTrend) {
            $dataTrend->delete();
            return response()->json(['message' => 'success'], 200);
        }
        return response()->json(['message' => 'failed'], 400);
    }
}
