<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
     public $status;
     public $massage;
     public $resource;

     public function __construct($status, $massage, $resource){
        parent::__construct($resource);
        $this->massage = $massage;
        $this->status = $status;
       
     }
     public function toArray($request)
     {
         return[
            'succses' => $this->status,
            'massage' => $this->massage,
            'data' => $this->resource,
         ];
     }
        
     
}
