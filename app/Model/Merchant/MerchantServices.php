<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

class MerchantServices extends Model
{
    protected $fillable =array('*');
    public function merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant' , "merchant_id");
    }
    public function type(){
        return $this->belongsTo('App\Model\Merchant\MerchantType' , "type_id");
    }
}
