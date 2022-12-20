<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;
    protected $fillable = ['system_id','organization_system_id','lead_system_id','status_system_id','user_system_id','value','period','value_formatted','currency','expected_value','annualized_value','annualized_expected_value','date_won','date_lost','confidence','note','sale_rep_id','date_created','date_updated','updated_by_name','contact_name','status_label','status_type','status_display_name','lead_name'];

    public function salesrep()
    {
        return $this->hasOne(SaleRep::class, 'system_id', 'user_system_id');
    }
}
