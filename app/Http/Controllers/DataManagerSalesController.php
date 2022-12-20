<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Organization;
use App\Models\SaleRep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DataManagerSalesController extends Controller
{
    //
    public function index($system_id){
        return view('sales.index')->with([
            'organization' => Auth::user()->organization,
            'opportunities' => Opportunity::where(['organization_system_id'=> $system_id, 'user_system_id' => Auth::user()->salesrep->system_id])->paginate(10),
            'salesrep' => Auth::user()->salesrep,
        ]);
    }
    public function view($system_id){
        $salesrep = SaleRep::where([
            'system_id' => Auth::user()->salesrep_system_id,
            'organization_system_id' => $system_id,
        ])->first();
        if($salesrep){
            return view('pages.repview')->with([
                'organization' => Organization::where('system_id', $system_id)->first(),
                'salesrep' => $salesrep,
                'opportunities' => Opportunity::where([
                    'user_system_id' => $salesrep->system_id,
                    'organization_system_id' => $system_id,
                ])->orderBy('date_won', 'desc')->paginate(10),
            ]);
        }
        abort(404, 'Representative not found');
    }
}
