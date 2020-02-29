<?php
namespace Modules\Core\Services;

use Carbon\Carbon;

class DateTimeService
{
    public function sumWorkingDays($date, $days = 0)
    {
        $i = 0;
        $date  = Carbon::createFromFormat('Y-m-d', $date);

        while ($i < $days) {
            $date->addDay();

            if($this->checkIfItsWeekend($date)) {
                continue;
            }

            if($this->checkIfItsAHoliday($date)) {
                continue;
            }

            $i ++;
        }

        return $date->format('Y-m-d');
    }

    private function checkIfItsWeekend($date)
    {
        return $date->dayOfWeek == 0 || $date->dayOfWeek == 6;
    }

    private function checkIfItsAHoliday($date)
    {
        return in_array($date->format('Y-m-d'), static::holidays($date->format('Y')));
    }

    public static function holidays($year) {
        $day = 86400;
        $dates = [];
        $dates['easter'] = easter_date($year);
        $dates['good_friday'] = $dates['easter'] - (2 * $day);

        return [
           $year.'-01-01',
           $year.'-02-02',
           $year.date('-m-d',$dates['good_friday']),
           $year.date('-m-d',$dates['easter']),
           $year.'-04-21',
           $year.'-05-01',
           $year. '-09-20',
           $year.'-10-12',
           $year.'-11-02',
           $year.'-11-15',
           $year.'-12-25',
        ];
    }
}
