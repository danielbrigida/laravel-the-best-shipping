<?php

namespace Modules\Shipping\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;
use Modules\Shipping\Http\Requests\BestShippingOptionsRequest;
use Modules\Shipping\Repositories\BestShippingOptionsRepository;

class BestShippingOptionsController extends CoreController
{
    private $bestShippingOptionsRepository;

    public function __construct(BestShippingOptionsRepository $bestShippingOptionsRepository)
    {
        $this->bestShippingOptionsRepository = $bestShippingOptionsRepository;
    }

    public function index(BestShippingOptionsRequest $request)
    {
        try {
         
            return $this->bestShippingOptionsRepository->getBestShippingOptionByCostAndTime($request->all());

        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
