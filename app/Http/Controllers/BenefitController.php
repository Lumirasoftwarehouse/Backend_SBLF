<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BenefitProgram;

class BenefitController extends Controller
{
    public function getBenefits()
    {
        $dataBenefits = BenefitProgram::get();
        return response()->json(['message' => 'success', 'data' => $dataBenefits], 200);
    }

    public function createBenefit(Request $request)
    {
        $validatedData = $request->validate([
            'benefit' => 'required|string'
        ]);

        BenefitProgram::create([
            'benefit' => $validatedData['benefit']
        ]);

        return response()->json(['message' => 'success'], 201);
    }
    
    public function updateBenefit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'benefit' => 'required|string'
        ]);
        
        $dataBenefit = BenefitProgram::find($id);
        if ($dataBenefit) {
            $dataBenefit->update(['benefit' => $validatedData['benefit']]);
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'Benefit not found'], 404);
    }
    
    public function deleteBenefit($id)
    {
        $dataBenefit = BenefitProgram::find($id);
        if ($dataBenefit) {
            $dataBenefit->delete();
            return response()->json(['message' => 'success'], 200);
        }
        
        return response()->json(['message' => 'Benefit not found'], 404);
    }
}
