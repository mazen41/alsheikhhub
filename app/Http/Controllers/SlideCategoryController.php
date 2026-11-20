<?php

namespace App\Http\Controllers;

use Illuminate\http\Request;
use App\slide_category;
use App\Slide_categoryTranslation;
use App\Category;
use App\SubSubCategory;
use DB;
use Illuminate\Support\Str;

class SlideCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    { 
      $sort_search =null;

      $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

     
        $slide_categories = Slide_category::orderBy('name', 'asc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $slide_categories = $slide_categories->where('name', 'like', '%'.$sort_search.'%');
        }

        
        $slide_categories = $slide_categories->paginate(15);      
        return view('backend.marketing.slide_categories.index', compact('slide_categories', 'categories', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
          return view('backend.marketing.slide_categories.index', compact('slide_categories','categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slide_category = new Slide_category;
        $slide_category->name = $request->name;
        $slide_category->category_id       = $request->category_id;
        $slide_category->meta_title        = $request->meta_title;
        $slide_category->meta_description  = $request->meta_description;
        if ($request->slug!= null) {
            $slide_category->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $slide_category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $slide_category->image = $request->image;
        $slide_category->save();

        $slide_category_translation = Slide_categoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'slide_categories_id' => $slide_category->id]);
        $slide_category_translation->name = $request->name;
        $slide_category_translation->save();

        flash(translate('Slide Categories has been inserted successfully'))->success();
        return redirect()->route('slide_categories.index');

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
