<?php

namespace App\Http\Controllers\Workflows;

use App\Http\Controllers\Controller;
use App\Models\{User, TestModel};
use Illuminate\Http\Request;

class StepOneController extends Controller
{
    public function __invoke(Request $request, TestModel $testModel, User $user)
    {
        \Log::info($request->attributes->all());

        workflowState($request, 'test2')->set('testModel', $testModel)->set('user', $user);

        return view('workflows.step-one', [
            'testModel' => $testModel,
            'user' => $user,
        ]);
    }
}
