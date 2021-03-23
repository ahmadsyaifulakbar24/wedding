<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\TemplateSetting;
use App\Models\Wedding;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WeddingController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'order_name' => 'required|string',
            'theme' => 'required|string',
            'category_id' => [
                'required',
                Rule::exists('params', 'id')->where( function ($query) {
                    return $query->where('category_param', 'category_template');
                })
            ],
            'order_name' => 'required|string',
            'order_email' => 'required|string',
            'order_phone_number' => 'required|numeric',

            'groom_full_name' => 'required|string',
            'groom_short_name' => 'required|string',
            'groom_child_order' => 'required|numeric',
            'groom_father_name' => 'required|string',
            'groom_mother_name' => 'required|string',
            'groom_instagram' => 'required|url',

            'bride_full_name' => 'required|string',
            'bride_short_name' => 'required|string',
            'bride_child_order' => 'required|numeric',
            'bride_father_name' => 'required|string',
            'bride_mother_name' => 'required|string',
            'bride_instagram' => 'required|url',

            'reception_date' => 'required|date',
            'reception_address' => 'required|string',

            'contract_date' => 'required|date',
            'contract_address' => 'required|string',
            'location' => 'required|url',

            'image_slider' => 'required|array',
            'image_slider.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'image_gallery' => 'required|array',
            'image_gallery.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $result = DB::transaction(function () use ($request) {
                $wedding = Wedding::create($request->all());
                $template_setting = $wedding->template_setting()->create([
                    'theme' => $request->theme,
                    'category_id' => $request->category_id,
                ]);

                foreach($request->image_slider as $key => $image_slider) {
                    $image_slider = $image_slider->store('assets/slider', 'public');
                    $template_setting->template_image()->create([
                        'type' => 'slider',
                        'image' => $image_slider,
                        'order' => $key + 1,
                    ]);
                }
    
                foreach($request->image_gallery as $key => $image_gallery) {
                    $image_gallery = $image_gallery->store('assets/gallery', 'public');
                    $template_setting->template_image()->create([
                        'type' => 'gallery',
                        'image' => $image_gallery,
                        'order' => $key + 1,
                    ]);
                }
                return ResponseFormatter::success(
                    Wedding::with(['template_setting'])->find($wedding->id),
                    'your message has been successfully sent'
                );
            });
            return $result;
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                $e->getMessage(),
                422
            );
        }
    }
}
