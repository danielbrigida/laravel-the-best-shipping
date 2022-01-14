<?php

namespace Modules\Shipping\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;
use Modules\Shipping\Http\Requests\ShippingOptionsRequest;
use Modules\Shipping\Repositories\ShippingOptionsRepository;

class ShippingOptionsController extends CoreController
{
    private $shippingOptionsRepository;

    public function __construct(ShippingOptionsRepository $shippingOptionsRepository)
    {
        $this->shippingOptionsRepository = $shippingOptionsRepository;
    }

    public function index()
    {
        try{
            return $this->shippingOptionsRepository->getAll();
        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return $this->shippingOptionsRepository->find($id);
    }

    public function store(ShippingOptionsRequest $request)
    {
        try{
            $id = $this->shippingOptionsRepository->save($request->all());
          
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
         
        $data = $request->all();
        $data['id'] = $id;
        $id = $this->shippingOptionsRepository->save($data);
       
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
            
            $this->shippingOptionsRepository->delete($id);
          
            return response()->json(['message' => 'Deleted shipping options'], 202);
        }
        catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
