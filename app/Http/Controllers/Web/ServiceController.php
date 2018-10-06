<?php


namespace App\Http\Controllers\Web;


use App\Model\Merchant\Merchant;
use App\Model\Merchant\MerchantServices;
use App\Model\Merchant\MerchantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ServiceController extends Controller{
    public function Index(){
        $services =MerchantServices::with("merchant" , "type")->get();
        return view('services/index', compact('services'));
    }

    public function Create(){
        $merchants = Merchant::all();
        $types = MerchantType::all();
        return view('services/create')->with('merchants',$merchants)->with('types' , $types);
    }
    public function store(Request $request)
    {
        //

        $service = new MerchantServices();
        $service->name = Input::get('name');
        $service->type_id = Input::get('type');
        $service->merchant_id = Input::get('merchant');
        $service->standardFess = Input::get('standardFess');
        $service->sadadFess = Input::get('sadadFess');
        $service->totalFees = doubleval(Input::get('sadadFess')) + doubleval(Input::get('standardFess'));

        $service->save();

        return redirect('services');
    }

    public function edit($id)
    {
        //
        $service= MerchantServices::findOrFail($id);
        //dd($service);
        $types = MerchantType::all();
        $merchants = Merchant::all();
        return view('services/edit')->with('merchants',$merchants)->with('types' , $types)->with('service',$service);
        //return view('services/edit')->with('service',$service)->with('merchants',$merchants)-with('types',$types);
    }

    public function update(Request $request, $id)
    {
        //

        $service= MerchantServices::findOrFail($id);
        $input = $request->all();
        //dd($input);

        //$merchant = new merchant();
        $service->name = $input['name'];
        $service->type_id = $input['type'];
        $service->merchant_id = $input['merchant'];
        $service->standardFess = $input['standardFess'];
        $service->sadadFess = $input['sadadFess'];
        $service->totalFees = doubleval($input['sadadFess']) + doubleval($input['standardFess']);




        //dd($input);
//        $totalFess=doubleval($input["sadadFess"]) + doubleval($input["standardFess"]);
//        unset($input["_token"]);
//        $input["totalFees"] = $totalFess;
        //$service->fill($input)->save();
        $service->save();
        //$service->totalFees = $totalFess;
        //$service->save();
        return redirect('services');
    }

    public function delete($id)
    {
        //
        $service= MerchantServices::findOrFail($id);
        $service->delete();
        return response()->json([
            'error' => 'false'
        ],200);
    }
}
