<?php

namespace App\Http\Controllers;

use App\Models\Step;

class StepController extends Controller
{
    public function update(Step $step)
    {
        $step->completed = ! $step->completed;
        $step->save();

        return back();
    }
}
