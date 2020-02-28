<?php
namespace Modules\Shipping\Transformers;

use Illuminate\Http\Resources\Json\Resource;
      
class ShippingOptionsResource extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
	        'id' => $this->id,
        	'name' => $this->name,
        	'type'  => $this->type,
            'origin'=> $this->origin,
            'destination'=> $this->destination,
            'cost'=> $this->cost,
            'estimated_days'=> $this->estimated_days,
        ];
    }
}
