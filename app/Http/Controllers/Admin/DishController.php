<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Dish;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::latest()->paginate(10);
        return $dishes;
    }


    public function show_dish($id)
    {
        $selected_dish = Dish::find($id);
        return $selected_dish;
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
                'name'          =>  'required|max:40|min:5',
                'category'      =>  'required|max:20|min:5',
                'sub_category'  =>  'required|max:40|min:5',
                'image'         =>  'required|mimes:jpeg,jpg,bmp,png',
                'description'   =>  'required',
                'price'         =>  'required',
                'is_available'  =>  'required',
            ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()]);
        } else {
            $image_file = $request->file('image');
            $image_ext  = $image_file->getClientOriginalExtension();
            $image_name = Str::random(25) . '.' . $image_ext;
            $image_path = 'images/dishes';

            $form_data = array(
                'name'          =>  $request->name,
                'category'      =>  $request->category,
                'sub_category'  =>  $request->sub_category,
                'image'         =>  $image_name,
                'description'   =>  $request->description,
                'price'         =>  $request->price,
                'is_available'  =>  $request->is_available,
            );

            $new_dish = Dish::create($form_data);

            if ($new_dish) {
                $image_file->storeAs($image_path, $image_name);
                return $new_dish;
            }
        }
    }


    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name'          =>  'required|max:40|min:5',
            'category'      =>  'required|max:20|min:5',
            'sub_category'  =>  'required|max:40|min:5',
            'image'         =>  'required|mimes:jpeg,jpg,bmp,png',
            'description'   =>  'required',
            'price'         =>  'required',
            'is_available'  =>  'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()]);
        }
        else {
            $updated_dish   = Dish::find($id);
            $current_image  = $updated_dish->image;
            $image_file     = $request->file('image');
            $uploaded_image = $image_file->getClientOriginalName();
            $image_path     = 'images/dishes';

            if ($current_image != $uploaded_image){
                Storage::delete($image_path . $current_image);
                $image_ext  = $image_file->getClientOriginalExtension();
                $image_name = Str::random(25) . '.' . $image_ext;
                $image_file->storeAs($image_path, $image_name);
                $current_image = $image_name;
            }

            $form_data = array(
                'name'          =>  $request->name,
                'category'      =>  $request->category,
                'sub_category'  =>  $request->sub_category,
                'image'         =>  $current_image,
                'description'   =>  $request->description,
                'price'         =>  $request->price,
                'is_available'  =>  $request->is_available,
            );

            $updated_dish->update($form_data);
            return 'The details of the selected dish has been updated successfully!';
        }

    }


    public function destroy($id)
    {
        $deleted_dish = Dish::find($id);
        $deleted_dish->delete();
        return "The selected dish has been deleted!";
    }

}
