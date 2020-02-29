<?php
namespace Modules\Shipping\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingOptions extends Model
{
	use SoftDeletes;

	protected $table = 'shipping_options';

    protected $fillable = [
        'name',
        'type',
        'origin',
        'destination',
        'cost',
        'estimated_days'
    ];

    public function setOriginAttribute($value)
    {
        $this->attributes['origin']  = str_replace("-", "", $value);
    }

    public function setDestinationAttribute($value)
    {
        $this->attributes['destination']  = str_replace("-", "", $value);
    }
}
