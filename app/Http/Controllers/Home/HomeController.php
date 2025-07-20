<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Slider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeController extends Controller
{
    public function GetSlider(){    
        $slider = Slider::find(1);
        return view('admin.backend.slider.get_slider', compact('slider'));
    }
    // End Method 


    public function UpdateSlider(Request $request){

        $slider_id = $request->id;
        $slider = Slider::findOrFail($slider_id); 

        if ($request->file('image')) {
           $image = $request->file('image');
           $manager = new ImageManager(new Driver());
           $nameGen = hexdec(uniqid()) . '.'. $image->getClientOriginalExtension();  
           $img = $manager->read($image);
           $img->resize(804,870)->save(public_path('upload/slider/'.$nameGen));
           $imageUrl = 'upload/slider/'.$nameGen;

           if (file_exists(public_path($slider->image))) {
             @unlink(public_path($slider->image));
           }

            Slider::find($slider_id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'image' => $imageUrl,
        ]);

         $notification = array(
            'message' => 'Slider updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

        } else {

            Slider::find($slider_id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link, 
        ]);

         $notification = array(
            'message' => 'Slider updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

        } 
    }
    //End Method 

    public function UpdateSliders(Request $request, $id){
        $slider = Slider::findOrFail($id);
        $slider->update($request->only(['title','description']));

        $notification = array(
            'message' => 'Slider updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }
     //End Method 


}
