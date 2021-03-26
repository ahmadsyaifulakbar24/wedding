<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\GreetingCard;
use App\Models\Wedding;
use Illuminate\Http\Request;

class GreetCardController extends Controller
{
    public function index(Wedding $wedding)
    {
        $greeting_card = $wedding->greeting_card()->orderBy('id','desc')->get();
        return ResponseFormatter::success($greeting_card, 'success get data');
    }
    
    public function create(Request $request, Wedding $wedding)
    {
        $this->validate($request, [
            'name' =>  'required|string',
            'comment' => 'required|string',
        ]);

        $greeting_card = $wedding->greeting_card()->create($request->all());
        return ResponseFormatter::success(
            $greeting_card,
            'success send message'
        );
    }

    public function destroy(GreetingCard $greeting_card)
    {
        $greeting_card->delete();
        return ResponseFormatter::success(null, 'success delete greeting_card');
    }
}
