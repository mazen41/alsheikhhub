<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatslideTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'catslide_id'];

  public function catslide(){
    return $this->belongsTo(Catslide::class);
  }
}
