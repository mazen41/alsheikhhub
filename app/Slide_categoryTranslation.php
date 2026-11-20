<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide_categoryTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'slide_categories_id'];

  public function slide_category(){
    return $this->belongsTo(Slide_category::class);
  }
}
