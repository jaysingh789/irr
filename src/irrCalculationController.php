<?php

namespace codetimer\irr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class irrCalculationController extends Controller
{

    public function getIRR($cashFlows, $dates)
    {


        $guess = 0.1; // Initial guess for the IRR
        $epsilon = 0.0001; // Tolerance for convergence

        // Calculate the time interval for each cash flow
        $firstDate = strtotime(min($dates));

        $timeIntervals = array_map(function ($date) use ($firstDate) {
            $timeDiff = strtotime($date) - $firstDate;
            return $timeDiff / (365 * 24 * 60 * 60); // Convert to years
        }, $dates);

        // Define the function to calculate the NPV
        $npv = function ($rate) use ($cashFlows, $timeIntervals) {
            $npv = 0;
            $n = count($cashFlows);


            for ($i = 0; $i < $n; $i++) {
                $npv += $cashFlows[$i] / pow(1 + $rate, $timeIntervals[$i]);
            }

            return $npv;
        };

        // Newton-Raphson method to solve for IRR
        $irr = $guess;

        do {
            $npvValue = $npv($irr);

            $derivative = ($npv($irr + $epsilon) - $npvValue) / $epsilon;

            $irr = $irr - $npvValue / $derivative;
        } while (abs($npvValue) > $epsilon);

        return $irr;
    }
}
