<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingplanRequests extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'hosting_plan_id',
    ];
    public function hosting_plan()
    {
        return $this->belongsTo(HostingPlans::class);
    }
}
