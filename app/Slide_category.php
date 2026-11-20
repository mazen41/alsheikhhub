<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Slide_category extends Model
{
  public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? App::getLocale() : $lang;
      $slide_category_translation = $this->hasMany(Slide_categoryTranslation::class)->where('lang', $lang)->first();
      return $slide_category_translation != null ? $slide_category_translation->$field : $this->$field;
  }

  public function slide_categoryTranslation(){
    return $this->hasMany(Slide_categoryTranslation::class);
  }

}
