<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Catslide extends Model
{
  public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? App::getLocale() : $lang;
      $Catslide_translation = $this->hasMany(CatslideTranslation::class)->where('lang', $lang)->first();
      return $catslide_translation != null ? $catslide_translation->$field : $this->$field;
  }

  public function catslide_translations(){
    return $this->hasMany(CatslideTranslation::class);
  }

}
