<?php

namespace Modules\Shipping\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Shipping\Http\Requests\ShippingOptionsRequest;
use Modules\Shipping\Services\ShippingOptionsService;

class BestShippingOptionsController extends CoreController
{
    private $shippingOptionsService;

    public function __construct(ShippingOptionsService $shippingOptionsService)
    {
        $this->shippingOptionsService = $shippingOptionsService;
    }

    public function index(Request $request)
    {
        try{
            dd($request->all());
            return \DB::transaction(function(){
                return $this->shippingOptionsService->getAll();
            });
        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
