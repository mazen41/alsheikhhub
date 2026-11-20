<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Catslide;
use App\CatslideTranslation;
use App\Product;
use App\Category;
use App\SubSubCategory;
use DB;
use Illuminate\Support\Str;

class CatslideController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $sort_search = null;

    $categories = Category::where('parent_id', 0)
      ->where('digital', 0)
      ->with('childrenCategories')
      ->get();

    $catslides = Catslide::orderBy('name', 'asc');
    if ($request->has('search')) {
      $sort_search = $request->search;
      $catslides = $catslides->where('name', 'like', '%' . $sort_search . '%');
    }


    $catslides = $catslides->paginate(15);
    return view('backend.product.catslides.index', compact('catslides', 'categories', 'sort_search'));
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
    return view('backend.product.catslides.create', compact('catslides', 'categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $catslide = new Catslide;
    $catslide->name = $request->name;
    $catslide->category_id       = $request->category_id;
    $catslide->url                = $request->url;
    $catslide->meta_title        = $request->meta_title;
    $catslide->meta_description  = $request->meta_description;
    if ($request->slug != null) {
      $catslide->slug = str_replace(' ', '-', $request->slug);
    } else {
      $catslide->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
    }

    $catslide->logo = $request->logo;
    $catslide->save();

    $catslide_translation = CatslideTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'catslide_id' => $catslide->id]);
    $catslide_translation->name = $request->name;
    $catslide_translation->save();

    flash(translate('Catslide has been inserted successfully'))->success();
    return redirect()->route('catslides.index');
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
  public function edit(Request $request, $id)
  {
    $categories = Category::where('parent_id', 0)
      ->where('digital', 0)
      ->with('childrenCategories')
      ->get();



    $lang   = $request->lang;
    $catslide  = Catslide::findOrFail($id);
    return view('backend.product.catslides.edit', compact('catslide', 'lang', 'categories'));
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
    $catslide = Catslide::findOrFail($id);
    if ($request->lang == env("DEFAULT_LANGUAGE")) {
      $catslide->name = $request->name;
    }
    $catslide->category_id = $request->category_id;
    $catslide->url          = $request->url;
    $catslide->meta_title = $request->meta_title;
    $catslide->meta_description = $request->meta_description;
    if ($request->slug != null) {
      $catslide->slug = strtolower($request->slug);
    } else {
      $catslide->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
    }
    $catslide->logo = $request->logo;
    $catslide->save();

    $catslide_translation = CatslideTranslation::firstOrNew(['lang' => $request->lang, 'catslide_id' => $catslide->id]);
    $catslide_translation->name = $request->name;
    $catslide_translation->save();

    flash(translate('Catslide has been updated successfully'))->success();
    return back();
    // return view('backend.product.catslides.index');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $catslide = Catslide::findOrFail($id);
    Product::where('category_id', $catslide->id)->delete();
    foreach ($catslide->catslide_translations as $key => $catslide_translation) {
      $catslide_translation->delete();
    }
    Catslide::destroy($id);

    flash(translate('Catslide has been deleted successfully'))->success();
    return redirect()->route('catslides.index');
  }
}
