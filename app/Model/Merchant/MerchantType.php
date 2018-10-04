<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

class MerchantType extends Model
{
    //
    protected $table = 'merchant_types';

    public function Merchants(){
        return $this->hasMany('App\Model\Merchant\Merchant');
    }
}
