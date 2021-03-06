<?php

namespace App\Http\Controllers\Admin;

use PDOException;
use App\Models\Admin\Dish;
use Illuminate\Support\Str;
use League\Flysystem\Filesystem;
use App\Http\Requests\DishRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\DishResource;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Providers\GoogleDriveServiceProvider;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::latest()->paginate(10);
        return DishResource::collection($dishes);
    }


    public function show_dish($id)
    {
        $selected_dish = Dish::find($id);
        return new DishResource($selected_dish);
    }


    public function store(DishRequest $request)
    {
        $image_file = $request->file('image');
        $image_name = Str::random(25) . '.' . $image_file->getClientOriginalExtension();
        $image = Storage::disk("google")->putFileAs("", $image_file, $image_name);

        $image_id = Storage::disk("google")->getMetadata($image)["path"];
        $image_url = Storage::disk('google')->url($image);

        $form_data = array(
            'name'          =>  $request->name,
            'category'      =>  $request->category,
            'sub_category'  =>  $request->sub_category,
            'image_url'     =>  $image_url,
            'image_id'      =>  $image_id,
            'image_name'    =>  $image_name,
            'description'   =>  $request->description,
            'price'         =>  $request->price,
            'is_available'  =>  $request->is_available,
        );

        try {
            Dish::create($form_data);
        }
        catch (QueryException $e) {
            Storage::disk('google')->delete($image_id);
            return $e;
        }
        catch (PDOException $e) {
            Storage::disk('google')->delete($image_id);
            return $e;
        }
        return response(['success' => 'Dish has been created successfully']);

    }


    public function update(DishRequest $request, $id)
    {
        $updated_dish        = Dish::find($id);
        $current_image_name  = $updated_dish->image_name;
        $current_image_url   = $updated_dish->image_url;
        $current_image_id    = $updated_dish->image_id;
        $new_image           = $request->file('image');
        $new_image_name      = $new_image->getClientOriginalName();

        if ($current_image_name != $new_image_name){
            Storage::disk('google')->delete($updated_dish->image_id);
            $image_name = Str::random(25) . '.' . $new_image->getClientOriginalExtension();
            $image = Storage::disk("google")->putFileAs("", $new_image, $image_name);

            $current_image_name      = Str::random(25) . '.' . $new_image->getClientOriginalExtension();
            $current_image_url       = Storage::disk('google')->url($image);
            $current_image_id        = Storage::disk("google")->getMetadata($image)["path"];
        }

        $form_data = array(
            'name'          =>  $request->name,
            'category'      =>  $request->category,
            'sub_category'  =>  $request->sub_category,
            'image_url'     =>  $current_image_url,
            'image_id'      =>  $current_image_id,
            'image_name'    =>  $current_image_name,
            'description'   =>  $request->description,
            'price'         =>  $request->price,
            'is_available'  =>  $request->is_available,
        );



        try {
            $updated_dish->update($form_data);
        }
        catch (QueryException $e) {
            Storage::disk('google')->delete($current_image_id);
            return $e;
        }
        catch (PDOException $e) {
            Storage::disk('google')->delete($current_image_id);
            return $e;
        }

        return 'The details of the selected dish has been updated successfully!';
    }


    public function destroy($id)
    {
        $deleted_dish = Dish::find($id);
        Storage::disk('google')->delete($deleted_dish->image_id);
        $deleted_dish->delete();
        return "The selected dish has been deleted!";
    }

    public function test(DishRequest $request) {

        // New deployment

        if($image = $request->image){
            $imageName  = Str::after($image->store('images','public'), '/');
        }

        $form_data = [
            'name'          =>  $request->name,
            'category'      =>  $request->category,
            'sub_category'  =>  $request->sub_category,
            'image_url'     =>  'test',
            'image_id'      =>  'nbfjf',
            'image_name'    =>  $imageName,
            'description'   =>  $request->description,
            'price'         =>  $request->price,
            'is_available'  =>  $request->is_available,
        ];

        Dish::create($form_data);

        return response(['success' => 'Dish has created ssuccesfly']);
    }

}
