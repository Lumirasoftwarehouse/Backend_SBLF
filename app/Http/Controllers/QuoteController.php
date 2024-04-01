<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function getQuote()
    {
        $dataQuote = Quote::get();
        return response()->json(['message' => 'success', 'data' => $dataQuote], 200);
    }
    
    public function makeQuote(Request $request)
    {
        $validateData = $request->validate([
            'quote' => 'required'
        ]);
        $dataQuote = Quote::first();
        if ($dataQuote) {
            $dataQuote->quote = $validateData['quote'];
            $dataQuote->save();
            return response()->json(['message' => 'success'], 200);
        }
        $newData = new Quote();
        $newData->quote = $validateData['quote'];
        $newData->save();
        return response()->json(['message' => 'success'], 200);
    }
}
