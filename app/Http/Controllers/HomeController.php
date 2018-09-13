<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipping;
use App\Port;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\AddShippingRequest;
use App\Http\Requests\EstimateShippingRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    public function shippings_json(Request $request) {
        $user = $request->user();
        $all_shippings = ($user->hasRole('manager') ? Shipping::all() : Shipping::where('user_id', $user->id)->get());
        
        $shippings = array();
        foreach($all_shippings as $shipping) {
            $temp = array();
            $temp['id'] = $shipping->id;
            $temp['src'] = $shipping->src_name();
            $temp['dst'] = $shipping->dst_name();
            $temp['data'] = $shipping->created_at->format('d M Y - H:i:s');
            $temp['status'] = $shipping->status;
            array_push($shippings, $temp);
        }
        return $shippings;
    }

    public function view(Request $request, Shipping $shipping) {
        $user_id  = $request->user()->id;
        if ($request->user()->hasRole('user') && $user_id != $shipping->user_id)
            return redirect()->route('home');
        return view('shipping', ['is_manager' => $request->user()->hasRole('manager')]);
    }
    
    public function view_json(Request $request, Shipping $shipping) {
        $user_id  = $request->user()->id;
        if ($request->user()->hasRole('user') && $user_id != $shipping->user_id)
            return redirect()->route('home');
        
        $temp = array();
        $temp['id'] = $shipping->id;
        $temp['src'] = $shipping->src_name();
        $temp['dst'] = $shipping->dst_name();
        $temp['data'] = $shipping->created_at->format('d M Y - H:i:s');
        $temp['status'] = $shipping->status;
        return $temp;
    }
    
    public function update_shipping(StatusUpdateRequest $request, Shipping $shipping) {
        $user_id  = $request->user()->id;
        if ($request->user()->hasRole('user') && $user_id != $shipping->user_id)
            return redirect()->route('home');
        if ($request->status > 4 or $request->status < 0)
            return redirect()->route('home');
        $shipping->status = $request->status;
        $shipping->save();
        return 'OK';
    }
    
    public function ports_json() {
        return Port::get(['id', 'name']);
    }

    public function add(Request $request) {
        return view('addShipping');
    }

    public function estimate(EstimateShippingRequest $request) {
        $dst = $request->dst;
        $src = $request->src;
        $cost = abs($src-$dst)*5;
        $duration = abs($src-$dst)*2;
        return array("cost"=>$cost, "duration"=>$duration);
    }

    public function add_shipping(AddShippingRequest $request) {
        $user_id  = $request->user()->id;
        $shipping = new Shipping;
        $shipping->user_id = $user_id;
        $shipping->departure_port_id = $request->src;
        $shipping->arrival_port_id = $request->dst;
        $shipping->status = 0;
        $shipping->remarks = $request->description;
        $shipping->cost = $cost = abs($request->src-$request->dst)*5;
        $shipping->save();

        return array("id" => $shipping->id);
    }
}
