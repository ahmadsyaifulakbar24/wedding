<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Wedding;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WeddingController extends Controller
{
    // public function get all data
    public function index()
    {
        $wedding = Wedding::orderBy('id', 'desc')->paginate(15);
        return ResponseFormatter::success(
            $wedding,
            'success get wedding data'
        );
    }

    // create wedding order
    public function create(Request $request)
    {
        // validation input
        $this->validate($request, [
            'order_name' => 'required|string',
            'package' => 'required|in:bronze,silver,gold',
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

                // cek slug name and create slug 
                $slug = Str::slug($request->groom_short_name.'_'.$request->bride_short_name, '-');
                $original_slug = Str::slug($request->groom_short_name.'_'.$request->bride_short_name, '-');
                $counter = 0;
                while(Wedding::where('slug', $slug)->count() > 0) {
                    $counter++;
                    $slug = $original_slug.'-'.$counter;
                }
                
                 // insert wedding order data
                $wedding_input = $request->all();
                $wedding_input['slug'] = $slug;
                $wedding_input['active'] = false;
                $wedding = Wedding::create($wedding_input);

                // insert template setting data
                $wedding->template_setting()->create([
                    'theme' => $request->theme,
                    'category_id' => $request->category_id,
                ]);

                // insert image slider and image gallery
                foreach($request->image_slider as $key => $image_slider) {
                    $image_slider = $image_slider->store('assets/slider', 'public');
                    $wedding->template_image()->create([
                        'type' => 'slider',
                        'image' => $image_slider,
                        'order' => $key + 1,
                    ]);
                }
    
                foreach($request->image_gallery as $key => $image_gallery) {
                    $image_gallery = $image_gallery->store('assets/gallery', 'public');
                    $wedding->template_image()->create([
                        'type' => 'gallery',
                        'image' => $image_gallery,
                        'order' => $key + 1,
                    ]);
                }

                // response success
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

    // show wedding
    public function show(Wedding $wedding)
    {
        return ResponseFormatter::success(
            $wedding,
            'success get data'
        );
    }

    // update data wedding
    public function update(Request $request, Wedding $wedding)
    {
        $this->validate($request, [
            'order_name' => 'required|string',
            'package' => 'required|in:bronze,silver,gold',
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
        ]);
        try {
            $result = DB::transaction(function () use ($request, $wedding) {
                // update wedding data
                $wedding_input = $request->all();
                $wedding->update($wedding_input);
        
                // update template setting data
                $wedding->template_setting()->update([
                    'theme' => $request->theme,
                    'category_id' => $request->category_id,
                ]);
        
                return ResponseFormatter::success(
                    Wedding::with('template_setting')->find($wedding->id),
                    'success get data wedding'
                );
            });
            return $result;
        } catch (Exception $e) {
            return ResponseFormatter::error(
                'null',
                $e->getMessage(),
                500
            );
        }
    }

    // update wedding for active
    public function active(Request $request, Wedding $wedding)
    {
        $this->validate($request, [
            'active' => 'required|boolean'
        ]);
        $wedding->update([ 'active' => $request->active ]);
        return ResponseFormatter::success( $wedding, 'wedding status active' );
    }

    // delete wedding
    public function destroy(Wedding $wedding)
    {
        $wedding->delete();
        return ResponseFormatter::success(null, 'success delete data');
    }
}
