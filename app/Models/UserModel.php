<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
use Cmgmyr\Messenger\Traits\Messagable;

class UserModel extends CartalystUser
{
    // use Messagable;
	protected $fillable = [
		'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'profile_image',
        'is_active',
        'via_social',
        'country',
        'city',
        'state',
        'phone',
        'street_address',
        'gender',
        'rut_number',
        'bank_acc_no',
        'bank_name',
        'bank_acc_type',
        'bank_acc_email',
    ];

    public function traveller_profile()
    {
    	return $this->hasOne('App\Models\TravellerProfileModel','user_id','id');
    }

    public function owner_profile()
    {
    	return $this->hasOne('App\Models\OwnerProfileModel','user_id','id');	
    }

    public function favourite_properties()
    {
        return $this->belongsToMany('App\Models\PropertyModel','favourite_properties','user_id','property_id');
    }

    public function user_addresses()
    {
        return $this->hasOne('App\Models\UserAddressesModel','user_id','id');    
    }


}
