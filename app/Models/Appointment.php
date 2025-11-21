<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['patient_name','clinic_location','clinician_id','appointment_date','status','notes'];
    public function clinician()
    {
        return $this->belongsTo(User::class, 'clinician_id');
    }

    public function scopeForUser($query, User $user)
    {
        return isAdmin() ? $query : $query->where('clinician_id', $user->id);
    }

    public function scopeUpcoming($q)
    {
        return $q->whereBetween('appointment_date', [now(), now()->addDays(7)]);
    }
}
