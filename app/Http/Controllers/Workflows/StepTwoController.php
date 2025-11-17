<?php

namespace App\Http\Controllers\Workflows;

use App\Http\Controllers\Controller;
use App\Models\{User, TestModel};
use Illuminate\Http\Request;

class StepTwoController extends Controller
{
    public function __invoke(Request $request)
    {
        $testModel = workflowState($request, 'test2')->get('testModel');
        $user = workflowState($request, 'test2')->get('user');

        dd($request, $testModel ?? 'no testModel', $user ?? 'no user');
    }
}
