<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

class MerchantBankAccount extends Model
{
    //
    public function Merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant');
    }
    public function BankBranch(){
        return $this->belongsTo('App\Model\Bank\BankBranch');
    }
}
