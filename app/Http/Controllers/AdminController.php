<?php

namespace App\Http\Controllers;
use App\Category;
use App\User;

use App\Profile;
use Debugbar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(){

        $users = User::all();
        return view('admin.admin')->withUsers($users) ;
    }
    public function users(){
        $profiles =Profile::all();
        $users = User::all();
        $categories = Category::all();
        return view('admin.users')->withUsers($users)->withProfiles($profiles)->withCategories($categories);
    }

    public function getCategories(){
        $data=[];
        $categories = Category::all();
        foreach($categories as $category){

            $data[$category->id] =$category;
            $data[$category->id]['parentTitle'] = Category::find($category->parent_id)?Category::find($category->parent_id)->title:"";

     }

        return view('admin.categories')->withCategories($categories)->withData($data) ;
    }
    public function editCategory($id){

        $selectedCategory = Category::findOrFail($id);
        $categories = Category::all();

        return view('admin.categories',[ 'selectedCategory'=>$selectedCategory,'categories'=>$categories]) ;
    }

    public function deleteCategory(Request $request){

        $category = Category::find($request->id);
        if($category->icon)
        Storage::disk('public')->delete($category->icon);

        if($category->image)
        Storage::disk('public')->delete($category->image);

         Category::destroy($request->id);
         Debugbar::info('Category deleted');



        return redirect()->route('admin.categories' );
    }

    public function updateCategory(Request $request){
        Debugbar::info($request);
        try {

            $icon = $request->file('icon');
            $image = $request->file('image');


            $category = Category::findOrFail($request->id);


            if(isset($icon) ){

                $fileNameNewIcon=  preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($icon->getClientOriginalName()));
                $filenameIcon = time().$fileNameNewIcon;
                $extensionIcon = $icon->getClientOriginalExtension();
                Storage::disk('public')->put($filenameIcon,  File::get($icon));
                $category->icon = $filenameIcon;
            }

            if(isset($image)){
                $fileNameNewImage=  preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($image->getClientOriginalName()));
                $filenameImage = time().$fileNameNewImage;
                $extensionImage = $image->getClientOriginalExtension();
                Storage::disk('public')->put($filenameImage,  File::get($image));
                $category->image = $filenameImage;
            }
            $category->title = $request->title;
            $category->description = $request->description;
            $category->parent_id = $request->parent_id;

            $category->save();

        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->route('admin.categories' );

    }

    public function newCategory(Request $request){
        Debugbar::info($request);
        try {



            $category = new Category();
            $category->title = $request->title;
            $category->description = $request->description;
            $category->parent_id = $request->parent_id;

            $icon = $request->file('icon');
            $image = $request->file('image');
            if(isset($icon) ){
            $fileNameNewIcon=  preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($icon->getClientOriginalName()));
            $filenameIcon = time().$fileNameNewIcon;
            $extensionIcon = $icon->getClientOriginalExtension();
            Storage::disk('public')->put($filenameIcon,  File::get($icon));
            $category->icon = $filenameIcon;
            }

            if(isset($image) ){

            $fileNameNewImage=  preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($image->getClientOriginalName()));
            $filenameImage = time().$fileNameNewImage;
            $extensionImage = $image->getClientOriginalExtension();
            Storage::disk('public')->put($filenameImage,  File::get($image));
            $category->image = $filenameImage;
            }

            $category->save();


        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->route('admin.categories' );

    }
}
