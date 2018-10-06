<?php

namespace App\Http\Controllers\Web;

use App\Model\Transaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\Factory;

class TransactionController extends Controller
{
    //
    public function showAll(){
        $transactions = Transaction::with(["transactionType","user"])->get();

        return view("transactions/all" , compact("transactions"));
    }
}
