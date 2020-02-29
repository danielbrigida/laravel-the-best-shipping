<?php

namespace Modules\Shipping\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;
use Modules\Shipping\Http\Requests\ShippingOptionsRequest;
use Modules\Shipping\Services\ShippingOptionsService;

class ShippingOptionsController extends CoreController
{
    private $shippingOptionsService;

    public function __construct(ShippingOptionsService $shippingOptionsService)
    {
        $this->shippingOptionsService = $shippingOptionsService;
    }

    public function index()
    {
        try{
            return \DB::transaction(function(){
                return $this->shippingOptionsService->getAll();
            });
        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return $this->shippingOptionsService->find($id);
    }

    public function store(ShippingOptionsRequest $request)
    {
        try{
            $id = \DB::transaction(function() use ($request){
                return $this->shippingOptionsService->save($request->all());
            });

            return response()->json([
                'message'   => 'Registered shipping options',
                'data'      => $this->show($id),
            ],201);
        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function update(ShippingOptionsRequest $request, $id)
    {
        try{
        $id = \DB::transaction(function () use ($request, $id){
            $data = $request->all();
            $data['id'] = $id;
            return $this->shippingOptionsService->save($data);
        });
        return response()->json([
            'message' => 'Saved shipping options',
            'data' => $this->show($id),
        ],200);
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try{
            \DB::transaction(function () use ($id){
                return $this->shippingOptionsService->delete($id);
            });
            return response()->json(['message' => 'Deleted shipping options'], 202);
        }
        catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
