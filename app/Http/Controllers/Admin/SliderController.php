<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('display_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate(['image_path' => 'required']);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($data);
        return redirect()->route('admin.sliders')->with('success', 'Slider created!');
    }

    public function destroy($id)
    {
        Slider::findOrFail($id)->delete();
        return redirect()->route('admin.sliders')->with('success', 'Slider deleted!');
    }
}