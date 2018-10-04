<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
//    public function users(){
//
//    }
      protected $fillable=["merchant_name","status"];
      public function services(){
          return $this->hasMany('App\Model\Merchant\MerchantServices');
      }
      public function types(){
          return $this->belongsTo('App\Model\Merchant\MerchantType','type_id');
      }
      public function users(){
          return $this->hasMany('App\Model\Merchant\MerchantUser');
      }
}
