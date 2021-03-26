<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\TemplateImage;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TemplateImageController extends Controller
{
    public function get(Request $request, Wedding $wedding)
    {
        $this->validate($request, [
            'type' => 'required|in:slider,gallery'
        ]);

        $template_image = $wedding->template_image()->where('type', $request->type)->get();
        return ResponseFormatter::success(
            $template_image,
            'success get data image'
        );
    }

    public function create(Request $request, Wedding $wedding)
    {
        $this->validate($request, [
            'type' => 'required|in:slider,gallery',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => [
                'required',
                Rule::exists('template_images', 'order')->where(function ($query) use ($request, $wedding) {
                    return $query->where([['wedding_id', $wedding->id], ['type', $request->type]]);
                })
            ]
        ]);

        ($request->type == 'slider') ? $path = 'assets/slider' : $path = 'assets/gallery';
        if($request->file('image')) {
            $image = $request->file('image')->store($path, 'public');
        }
        $template_image = $wedding->template_image()->create([
            'type' => $request->type,
            'image' => $image,
            'order' => $request->order
        ]);

        return ResponseFormatter::success(
            $template_image,
            'success get data image'
        );
    }

    public function destroy(TemplateImage $template_image)
    {
        $template_image->delete();
        Storage::disk('public')->delete($template_image->image);
        return ResponseFormatter::success(null, 'delete image success');
    }
}
