<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Merchant\Merchant as Merchant;

use App\Model\Merchant\MerchantType;
use Illuminate\Http\Request;
use App\Model\Merchant\MerchantType as type;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $merchants = Merchant::with('types')->get();
        return view('merchants/index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $type=type::all();
        return view('merchants/create')->with('types',$type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $merchant = new Merchant();
        $merchant->merchant_name = $request->name;
        $merchant->type_id = $request->type;
        $merchant->status = true;
        $merchant->payee_id = 1;
        $merchant->save($request->all());


        return redirect('merchants');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Merchant\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $gg= Merchant::findOrFail($id);
        echo $gg;
//        return
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Merchant\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $merchant= Merchant::findOrFail($id);
        $types = type::all();
        return View('merchants/edit',compact(['merchant','types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Merchant\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $merchant= Merchant::findOrFail($id);
        //$merchant = new merchant();
        $input = $request->all();
        $merchant->fill($input)->save();
        return redirect('merchants');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Merchant\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        //
//        $merchant= Merchant::findOrFail($id);
//        $merchant->delete();
//        return response()->json([
//            'error' => 'false'
//        ],200);
//    }

    public function delete($id)
    {
        //
        $merchant= Merchant::findOrFail($id);
        $merchant->delete();
        return response()->json([
            'error' => 'false'
        ],200);
    }
	
	
	public function test(){

		$items = Merchant::all();		
        	return response()->json($items);
		
	}
}
