<?php

namespace App\Http\Controllers;
use App\Category;
use App\Profile;

use Debugbar;

use Illuminate\Http\Request;

class WelcomController extends Controller
{




    /*  htis will make these controllers available only to auth users

    public function __construct()
    {
        $this->middleware('auth');
    } */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $profiles =Profile::all();
        $ordered =[];
        foreach($categories as $category){
            if(!isset($category->parent_id)){
                $ordered[$category->id]=$category->toArray();
            }
            else
            if(isset($category->parent_id)){
                array_push($ordered[$category->parent_id],$category->toArray());
            }
        }


        foreach($profiles as $profile){
            $profile->categoria = $profile->category;
            $profile['image']=json_decode($profile['image']);
            $profile['category_id'] = $profile->category->id;
            $profile['category_icon'] = $profile->category->icon;
            $profile['category_title'] = $profile->category->title; 
            
        }


        
      //  $profiles = collect($newProfiles); 


        return view('welcome', ['categories' => $ordered,'profiles'=>$profiles->toJson()]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


     function fixImages(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
