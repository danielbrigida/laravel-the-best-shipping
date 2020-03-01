<?php
namespace Modules\Shipping\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Core\Services\DateTimeService;

class BestShippingOptionsResource extends Resource
{
    private $bestOptions;
    private $bestOptionsFormatted;

    public function __construct($bestOptions)
    {
        $this->bestOptions = $bestOptions;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $dateTimeService = resolve(DateTimeService::class);

        $i = 0;
        $this->bestOptionsFormatted = [];

        foreach($this->bestOptions as $option){
            $i ++;

            $estimatedDate = $dateTimeService->sumWorkingDays( date('Y-m-d') , $option['estimated_days']);

            $this->bestOptionsFormatted[$i]['name'] = $option['name'];
            $this->bestOptionsFormatted[$i]['type'] = $option['type'];
            $this->bestOptionsFormatted[$i]['cost'] = (float) number_format($option['cost'],2);
            $this->bestOptionsFormatted[$i]['estimated_date'] = $estimatedDate." 00:00:00";
        }

        return $this->bestOptionsFormatted;
    }
}
