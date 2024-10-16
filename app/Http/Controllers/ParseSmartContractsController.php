<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParseSmartContractsController extends Controller
{
    public function __invoke(Request $request)
    {
        // get input parameters
        $integrations = $request->input('integrations');

        dd($integrations);
    }
}
