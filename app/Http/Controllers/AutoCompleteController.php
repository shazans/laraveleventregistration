<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class AutoCompleteController extends Controller
{
    //return aims number list
public function autoComplete(Request $request)
{

    $term=$request->aims;
    $data =  \App\tajneed::where('AIMS','LIKE','%'.$term.'%')
    ->take(5)
    ->get(); 
    $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    foreach($data as $row)
     {
       $output .= '
      <li><a href="#">'.$row->AIMS.'</a></li>
      ';
      }
      $output .= '</ul>';
      echo $output;
}

}
