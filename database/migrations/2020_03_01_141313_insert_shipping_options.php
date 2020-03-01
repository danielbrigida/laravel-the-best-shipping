<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Shipping\Entities\ShippingOptions;

class InsertShippingOptions extends Migration
{
    protected $table = 'shipping_options';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table($this->table)->insert([
            'name' => 'Option 1',
            'type' => 'Delivery',
            'origin' => '01308030',
            'destination' => '08226021',
            'cost' => 10.00,
            'estimated_days' => 5,
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        DB::table($this->table)->insert([
            'name' => 'Option 2',
            'type' => 'Custom',
            'origin' => '01308030',
            'destination' => '08226021',
            'cost' => 10.00,
            'estimated_days' => 3,
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        DB::table($this->table)->insert([
            'name' => 'Option 3',
            'type' => 'Pickup',
            'origin' => '01308030',
            'destination' => '08226021',
            'cost' => 10.00,
            'estimated_days' => 3,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ShippingOptions::query()->truncate();
    }
}
