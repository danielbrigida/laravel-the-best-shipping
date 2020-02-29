<?php

namespace Modules\Shipping\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;
use Modules\Shipping\Http\Requests\BestShippingOptionsRequest;
use Modules\Shipping\Services\BestShippingOptionsService;

class BestShippingOptionsController extends CoreController
{
    private $bestShippingOptionsService;

    public function __construct(BestShippingOptionsService $bestShippingOptionsService)
    {
        $this->bestShippingOptionsService = $bestShippingOptionsService;
    }

    public function index(BestShippingOptionsRequest $request)
    {
        try {
            return \DB::transaction(function() use ($request) {
                return $this->bestShippingOptionsService->getBestShippingOptionByCostAndTime($request->all());
            });
        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
