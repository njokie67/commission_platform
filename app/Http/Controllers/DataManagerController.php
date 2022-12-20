<?php

namespace App\Http\Controllers;

use App\Models\ApiHolder;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Organization;
use App\Models\SaleRep;
use App\Models\User;
use App\Notifications\newSalesrepUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class DataManagerController extends Controller
{
    //
    public function index($system_id){
        return view('home')->with([
            'organization' => Organization::where('system_id', $system_id)->first(),
            'opportunities' => Opportunity::where('organization_system_id', $system_id)->get(),
            'salesreps' => SaleRep::where('organization_system_id', $system_id)->get(),
            "top10salesreps" => SaleRep::where('organization_system_id', $system_id)->orderBy('id', 'desc')->simplePaginate(10),
        ]);
    }
    public function opportunities($system_id){
        return view('pages.opportunity')->with([
            "organization" => Organization::where('system_id', $system_id)->first(),
            'opportunities' => Opportunity::where('organization_system_id', $system_id)->orderBy('date_updated', 'desc')->paginate(10),
            'opportunitiesall' => Opportunity::where('organization_system_id', $system_id)->get(),
        ]);
    }
    public function viewrep($system_id, $id){
        $salesrep = SaleRep::where([
            'id' => $id,
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

    public function postcommission($system_id, Request $request){
        $this->validate($request, [
            'commission' => ['integer', 'min:5', 'required'],
        ]);
        Organization::where('system_id', $system_id)->update([
            'commission' => $request->commission,
        ]);
        return redirect(URL::previous())->with([
            'success' => 'Commission percentage updated',
        ]);
    }

    public function management($system_id){
        return view('pages.management')->with([
            'organization' => Organization::where('system_id', $system_id)->first(),
            'users' => User::where('id', '!=', Auth::user()->id)->where([
                'organization_system_id' => $system_id,
            ])->orderBy('id', 'desc')->paginate(10),
            'salesrep' => SaleRep::where('organization_system_id', $system_id)->orderBy('id', 'desc')->get(),
        ]);
    }

    public function registerusers($system_id, Request $request){
        $this->validate($request, [
            'salesrep' => ['integer', 'required'],
        ]);
        $salesrep = SaleRep::find($request->salesrep);
        if(isset($salesrep)){
            if($salesrep->organization_system_id == $system_id){

            }else{
                return redirect('/dashboard')->with('error','Sale rep is not assigned to your organization');
            }
        }else{
            return redirect('/dashboard')->with('error', 'Sales rep details could not be found');
        }
        if(User::where(['email' => $salesrep->email])->count()>0){
            return redirect(URL::previous())->with(['error' => 'User already exists']);
        }
        $user = User::create([
            'name' => $salesrep->first_name.' '.$salesrep->second_name,
            'email' => $salesrep->email,
            'password' => Hash::make(rand(0,4329053493)),
            'salesrep_system_id' => $salesrep->system_id,
            'organization_system_id' => $salesrep->organization_system_id,
            'image' => $salesrep->image,
        ]);
        $url = URL::temporarySignedRoute('salesrep.registration', now()->addHours(24), ['id' => $user->id]);
        Notification::route('mail', $salesrep->email)->notify(new newSalesrepUser($url));
        return redirect(URL::previous())->with('success', 'Inform the user to check their mail and set their password within 24 hours');
    }



public function addorgurl(){
    return view('setup.api');
}

    public function guide(){
        if (Auth::user()->level == 1) {
            $organization = Organization::orderBy('id', 'desc')->first();
            if(null == $organization){
                return view('setup.api');
            }
            return redirect(URL('organization/'.$organization->system_id.'/dashboard'));
        }else{
            $user = Auth::user();
            $organization = $user->organization;
            return redirect(URL('salesrep/'.$organization->system_id.'/dashboard'));
        }
        //
    }
    public function settings(){
        return view('pages.settings')->with([
            'organization' => Organization::orderBy('id', 'desc')->first(),
            'apiholders' => ApiHolder::orderBy('id', 'desc')->paginate(10),
        ]);
    }
    public function removekey($id){
        $apiholder = ApiHolder::find($id);
        if(is_null($apiholder)){
            return redirect(URL::previous())->with('error', 'Error fetching data');
        }
        foreach(Organization::where(['apikey' => $apiholder->api_key])->get() as $organization){
            Opportunity::where('organization_system_id', $organization->system_id)->delete();
            SaleRep::where('organization_system_id', $organization->system_id)->delete();
            User::where('organization_system_id', $organization->system_id)->delete();
            $organization->delete();
        }
        $apiholder->delete();
        return redirect('/dashboard')->with('success', 'Delete action completely');
    }
}
