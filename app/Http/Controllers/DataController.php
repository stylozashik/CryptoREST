<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataController extends Controller
{
    # Component to return user form
    public function index()
    {
        return view('index');
    }
    
    # Component for storing user and data input URL
    public function store_data(Request $request)
    {
        # Grab user requested currency
        $data = request('currency');

        # Set start and end date parameter
        $start_date = date('Y-m-d' , strtotime('-30 days')) ;
        $end_date = date('Y-m-d') ;

        # Get CoinDesk API data with customizable user input and time parameter
        $url = 'https://api.coindesk.com/v1/bpi/historical/close.json?start=' .$start_date .'&end=' . $end_date.'&currency=' . $data ;
        $c_price = 'https://api.coindesk.com/v1/bpi/currentprice/'. $data .'.json' ;

        # Store collected data in global variable like "Session"
        Session::put('currency' , $data);
        Session::put('url',$url);
        Session::put('c_price',$c_price);

        # Redirect to show() function to populate APIs
        return redirect('/getBitcoinInfo');
    }

    # Component to return json response
    public function show_data()
    {
        # Get Session data
        $data = Session::get('currency');
        $url = Session::get('url');
        $c_url = Session::get('c_price');

        # Decode Session data for later use
        $c_price_data = json_decode(file_get_contents($c_url), true);
        $price_data = json_decode(file_get_contents($url), true);
        $price_arr = array_values($price_data['bpi']);

        # Convert collected data in string data type 
        $current_price = strval($c_price_data['bpi'][$data]['rate']);
        $lowest_price = strval(min($price_arr));
        $highest_price = strval(max($price_arr));

        # Create an array of return that will be converted to Json response
        $data_array = array('Current Price'=>$current_price , 'Lowest Price'=>$lowest_price, 'Highest_price'=>$highest_price);

        # Encode data_array to Json format
        $api = json_encode($data_array);

        # Return a Json response with customizable data
        return $api;

    }

}


/***
 * Coded By- 
 * Ashikur Rahaman (Software Engineer)
 * stylozashik@gmail.com
 * Whatsapp : 01820829119
 ***/