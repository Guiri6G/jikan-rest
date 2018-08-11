<?php

namespace App\Http\Controllers;

use Jikan\Request\Schedule\ScheduleRequest;
use Jikan\Request\Seasonal\SeasonalRequest;

class ScheduleController extends Controller
{

    private const VALID_DAYS = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'other',
        'unknown'
    ];

    public function main(?string $day = null)
    {
        $schedule = $this->jikan->getSchedule(new ScheduleRequest());

        if (!is_null($day) && !\in_array(strtolower($day), self::VALID_DAYS)) {
            return response()->json([
                'error' => 'Bad Request'
            ])->setStatusCode(400);
        }

        if (!is_null($day)) {
            $schedule = $schedule->{'get' . ucfirst(strtolower($day))}();
        }


        return response($this->serializer->serialize($schedule, 'json'));
    }
}
