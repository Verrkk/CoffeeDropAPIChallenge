<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashCalculation;

class CashcalcController extends Controller
{
    public function calculateCash(Request $request)
    {
        $ristretto = $request->input('Ristretto', 0);
        $espresso = $request->input('Espresso', 0);
        $lungo = $request->input('Lungo', 0);
        $numberOfPods = $ristretto + $espresso + $lungo;

        $cashCalculation = new CashCalculation();
        $cashCalculation->ristretto = $ristretto;
        $cashCalculation->espresso = $espresso;
        $cashCalculation->lungo = $lungo;
        $cashCalculation->number_of_pods = $numberOfPods;
        $cashCalculation->amount = $this->calculateAmount($ristretto, $espresso, $lungo);
        $cashCalculation->save();

        return response()->json(['message' => 'Cashback calculated successfully']);
    }

    public function calculateAmount($ristretto, $espresso, $lungo)
    {
        $totalCash = 0;

        $totalCash += $this->calculatePodCash($ristretto, 2, 3, 5,);
        $totalCash += $this->calculatePodCash($espresso, 4, 6, 9,);
        $totalCash += $this->calculatePodCash($lungo, 5, 10, 15,);

        return $totalCash / 100;
    }

    private function calculatePodCash($quantity, $cap50, $cap50500, $cap501)
    {
        $cashback = 0;

        if ($quantity > 0) {
            if ($quantity <= 50){
                $cashback = $quantity * $cap50;
            } elseif ($quantity <= 500) {
                $cashback = (50 * $cap50) + (($quantity - 50) * $cap50500);
            } else {
                $cashback = (50 * $cap50) + (450 * $cap50500) + (($quantity - 500) * $cap501);
            }
        }

        return $cashback;
    }
}
