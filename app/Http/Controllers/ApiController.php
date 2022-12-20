<?php

namespace App\Http\Controllers;

use App\Models\ApiHolder;
use App\Models\Opportunity;
use App\Models\Organization;
use App\Models\SaleRep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;


class ApiController extends Controller
{
    //
    protected $apikey;
    public function __construct()
    {
        $this->apikey = '';
    }
    public function api(Request $request){
        $id = $request->id;
        $status = $request->status;
        $apiholder = ApiHolder::find($id);
        if(null == $apiholder){
            abort(403, 'We could not locate records for this API');
        }
        
        $this->apikey = $apiholder->api_key;
        $test = $this->closeio('me');
        if(isset($test['error'])){
            return redirect(URL::previous())->with([
                'error' => 'Api key is invalid. Close couldn`t connect',
            ]);
        }
        return $this->initial();
    }
    protected function closeio($url){
        return Http::withBasicAuth($this->apikey, '')->acceptJson()->get('https://api.close.com/api/v1/'.$url);
    }

    protected function initial(){
        $data = $this->closeio('me');
        $data = $this->closeio('user/'.$data['id']);
        foreach($data['organizations'] as $organization){
            $item = $this->closeio('organization/'.$organization);
            Organization::create([
                'currency' => $item['currency'],'currency_symbol' => $item['currency_symbol'],'name' => $item['name'],'system_id' => $item['id'],'leads_email' => $item['leads_email'],'date_created' => $item['date_created'],'created_by' => $item['created_by'], 'apikey' => $this->apikey,
            ]);
            sleep(1);
            $this->opportunity($item['id']);
        }
        return true;

    }

    private function opportunity($orgId){
        $url = 'opportunity/?organization_id='.$orgId.'&value_period=one_time&status_label=won';
        $data = $this->closeio($url);
        $this->fillopportunity($data);
        if($data['has_more']){
            //return $data['total_results'];
            for ($i=100; $i < $data['total_results']; $i+100) { 
                $data = $this->closeio($url.'&_skip='.$i);
                //return $data['data'];
                //
                $this->fillopportunity($data);
                sleep(1);
            }
        }
        return $this->salesrep();
        //return Opportunity::all();
    }
    private function fillopportunity($data){

        foreach ($data['data'] as $item) {
            if(Opportunity::where('system_id', $item['id'])->count()>0){}else{
            Opportunity::create([
                'system_id' => $item['id'],
                'organization_system_id' => $item['organization_id'],
                'lead_system_id' => $item['lead_id'],
                'status_system_id' => $item['status_id'],
                'user_system_id' => $item['user_id'],
                'value' => substr($item['value'], 0, strlen($item['value'])-2),
                'period' => $item['value_period'],
                'value_formatted' => $item['value_formatted'],
                'currency' => $item['value_currency'],
                'expected_value' => $item['expected_value'],
                'annualized_value' => $item['annualized_value'],
                'annualized_expected_value' => $item['annualized_expected_value'],
                'date_won' => $item['date_won'],
                'date_lost' => $item['date_lost'],
                'confidence' => $item['confidence'],
                'note' => $item['note'],
                'date_created' => $item['date_created'],
                'date_updated' => $item['date_updated'],
                'updated_by_name' => $item['updated_by_name'],
                'contact_name' => $item['contact_name'],
                'status_label' => $item['status_label'],
                'status_type' => $item['status_type'],
                'status_display_name' => $item['status_display_name'],
                'lead_name' => $item['lead_name'],
            ]);}
        }

        return true;
    }
    
    protected function salesrep(){
        foreach (Opportunity::all() as $opportunity) {
            if (SaleRep::where('system_id', $opportunity['user_system_id'])->count() > 0) {}else{
                $item = $this->closeio('user/'.$opportunity['user_system_id']);
                SaleRep::create([
                    'date_created' => $item['date_created'],
                    'first_name' => $item['first_name'],
                    'second_name' => $item['last_name'],
                    'system_id' => $item['id'],
                    'email' => $item['email'],
                    'image' => $item['image'],
                    'phone' => '',
                    'date_updated' => $item['date_updated'],
                    'organization_system_id' => (isset($item['organizations'][0])) ? $item['organizations'][0] : $opportunity->organization_system_id,
                ]);
                sleep(1);
            }
        }
        return true;
    }

    public function newapi(Request $request){
        $this->validate($request, [
            'name' => ['required'],
            'apikey' => ['required'],
        ]);
        
        $this->apikey = $request->apikey;
        $test = $this->closeio('me');
        dd($test);
        if(isset($test['error'])){
            return view('setup.api')->with([
                'error' => 'Api key is invalid. Close couldn`t connect',
            ]);
        }else{
            ApiHolder::create([
                'name' => $request->name,
                'api_key' => $request->apikey,
            ]);

            $this->initial();

            return response()->json([
                'success' => 'Organization data added successfully',
            ]);
        }

    }
    public function refresh($system_id){
        $organization = Organization::where(['system_id' => $system_id])->first();
        if(is_null($organization)){return response()->json(['error' => 'That organization cannot be found. ']);}
        $this->apikey = $organization->apikey;
        $this->opportunity($system_id);
        return response()->json(['success' => 'System information updated']);
    }
}
