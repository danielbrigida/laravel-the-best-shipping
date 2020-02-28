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


}
