<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Confirmation;
use App\Models\Wedding;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function index(Wedding $wedding)
    {
        $confirmation = $wedding->confirmation()->orderBy('id', 'desc')->get();
        return ResponseFormatter::success(
            $confirmation,
            'success get confirmation data'
        );
    }

    public function create (Request $request, Wedding $wedding)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'status' => 'required|string',
        ]);

        
        $confirmation = $wedding->confirmation()->create($request->all());
        return ResponseFormatter::success(
            $confirmation,
            'success confirmation'
        );
    }

    public function destroy (Confirmation $confirmation)
    {
        $confirmation->delete();
        return ResponseFormatter::success(
            null,
            'delete confirmation data success'
        );
    }
}
