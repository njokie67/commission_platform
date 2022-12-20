<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleRep extends Model
{
    use HasFactory;
    protected $fillable = ['date_created','organization_system_id', 'first_name','second_name','system_id','email','image','phone','date_updated','commissionpaid',];

    /**
     * Get all of the opportunities for the SaleRep
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'user_system_id', 'system_id');
    }

    /**
     * Get the organization that owns the SaleRep
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'system_id', 'organization_system_id');
    }
}
