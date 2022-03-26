<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataController extends Controller
{
    public function index()
    {
        return view('index');
    }


    public function store(Request $request)
    {
        $data = request('currency');
        $start_date = date('Y-m-d' , strtotime('-30 days')) ;
        $end_date = date('Y-m-d') ;

        $url = 'https://api.coindesk.com/v1/bpi/historical/close.json?start=' .$start_date .'&end=' . $end_date.'&currency=' . $data ;
        $c_price = 'https://api.coindesk.com/v1/bpi/currentprice/'. $data .'.json' ;

        Session::put('currency' , $data);
        Session::put('url',$url);
        Session::put('c_price',$c_price);

        return redirect('/getBitcoinInfo');
    }


    public function show()
    {
        $data = Session::get('currency');
        $url = Session::get('url');

        $c_url = Session::get('c_price');
        $c_price_data = json_decode(file_get_contents($c_url), true);

        $price_data = json_decode(file_get_contents($url), true);
        $price_arr = array_values($price_data['bpi']);

        $current_price = strval($c_price_data['bpi'][$data]['rate']);
        $lowest_price = strval(min($price_arr));
        $highest_price = strval(max($price_arr));

        $data_array = array('Current Price'=>$current_price , 'Lowest Price'=>$lowest_price, 'Highest_price'=>$highest_price);

        $json = json_encode($data_array);
        dd($json); 

    }

}


/***
 * Coded By- 
 * Ashikur Rahaman (Software Engineer)
 * stylozashik@gmail.com
 * Whatsapp : 01820829119
 ***/