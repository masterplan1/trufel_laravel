<?php

namespace App\View\Composers;

use App\Models\Type;
use Illuminate\View\View;

class MetaComposer
{
  public function __construct(){}

  public function compose(View $view): void
  {
    $request = request();
    $url = $request->segment(1);
    $typeId = $request->segment(2);
    
    $title = match($url){
      'filling' => 'Начинки',
      'product' => 'Галерея',
      default => null,
    };
    
    $type = null;
    $typeName = null;
    if($typeId){
      $type = Type::find($typeId);
      if($type){
        $typeName = $type->name;
      }
    }
    $title = $typeName ? $title . ' - ' . $typeName : $title;
    
    $view->with(['title' => $title]);
  }
}