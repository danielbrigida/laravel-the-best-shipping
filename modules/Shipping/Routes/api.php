<?php

// Route: api/shipping-options
Route::prefix('shipping-options')->group(function(){

    Route::post('/', [
        'as' => 'shipping_options.store',
        'uses' => 'ShippingOptionsController@store'
    ]);

    Route::put('/{id}', [
        'as' => 'shipping_options.update',
        'uses' => 'ShippingOptionsController@update'
    ]);

    Route::get('/{id}', [
        'as' => 'shipping_options.show',
        'uses' => 'ShippingOptionsController@show'
    ]);

    Route::get('/', [
        'as' => 'shipping_options.index',
        'uses' => 'ShippingOptionsController@index'
    ]);

    Route::delete('/{id}', [
        'as' => 'shipping_options.destroy',
        'uses' => 'ShippingOptionsController@destroy'
    ]);
});

// Route: api/best-shipping-options
Route::prefix('best-shipping-options')->group(function(){
    Route::get('/', [
        'as' => 'shipping_options.index',
        'uses' => 'BestShippingOptionsController@index'
    ]);
});
