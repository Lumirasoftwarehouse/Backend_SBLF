<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function listRegister()
    {
        $result = Register::all();
        return response()->json(['message' => 'success', 'data' => $result]);
    }

    public function insertRegister(Request $request)
    {
        $validateData = $request->validate([
            'fullname' => 'required', 
            'email' => 'required|email|unique:registers', // pastikan email unik
            'num_phone' => 'required', 
            'company' => 'required'
        ]);

        $register = new Register();
        $register->fullname = $validateData['fullname'];
        $register->email = $validateData['email'];
        $register->num_phone = $validateData['num_phone'];
        $register->company = $validateData['company'];
        $register->save();

        return response()->json(['message' => 'success'], 201);
    }

    public function updateRegister(Request $request, $id)
    {
        $validateData = $request->validate([
            'fullname' => 'required', 
            'email' => 'required|email|unique:registers,email,' . $id, // pastikan email unik kecuali untuk dirinya sendiri
            'num_phone' => 'required', 
            'company' => 'required'
        ]);

        $register = Register::find($id);
        if (!$register) {
            return response()->json(['message' => 'Register not found'], 404);
        }

        $register->fullname = $validateData['fullname'];
        $register->email = $validateData['email'];
        $register->num_phone = $validateData['num_phone'];
        $register->company = $validateData['company'];
        $register->save();

        return response()->json(['message' => 'success']);
    }
    
    public function deleteRegister($id)
    {
        $register = Register::find($id);
        if (!$register) {
            return response()->json(['message' => 'Register not found'], 404);
        }
        
        $register->delete();
        return response()->json(['message' => 'success']);
    }
}
