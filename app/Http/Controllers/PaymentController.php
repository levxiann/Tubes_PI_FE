<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'C')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/get/all/".$user->data->pk."/0/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '. $user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        // check the status code
        if ($status == 200) {
            $payments = json_decode($response);

            // return a view if successful
            return view('tour.paymenthistory', compact('payments'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'C')
        {
            return redirect('/dash');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/");
        curl_setopt($ch, CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $totalprice = (int) $request->quantity * (int) $request->price;

        // set the data to send in the request body
        $data = array(
            'user' => $request->user,
            'shop' => $request->shop,
            'product' => $request->product,
            'quantity' => (int) $request->quantity,
            'total_price' => $totalprice
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 201)
        {
            return redirect('/shop/'.$request->shop)->with('success', 'Produk berhasil dibeli!');
        }
        else
        {
            return redirect('/shop/'.$request->shop)->with('error', 'Gagal membeli produk!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'C')
        {
            return redirect('/dash');
        }



        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // set DELETE method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 204)
        {
            return redirect('/payment/history')->with('success', 'Pesanan berhasil dibatalkan!');
        }
        else
        {
            return redirect('/payment/history')->with('error', 'Gagal membatalkan pesanan!');
        }
    }

    public function payment()
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'A' && $user->data->level  != 'E')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/get/user/".$user->data->pk."/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '. $user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        // check the status code
        if ($status == 200) {
            $shop = json_decode($response);

            // create a new cURL resource
            $ch = curl_init();

            // set the URL and other options
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/get/notpaid/0/".$shop->shop->pk."/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

            // set the headers
            $headers = array(
                'Content-Type: application/json', // specify the content type as JSON
                'Authorization: Token '. $user->token
            );

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // execute the request and get the response
            $response = curl_exec($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // close the cURL resource
            curl_close($ch);

            $payments = json_decode($response);

            // return a view if successful
            return view('tour.payment', compact('payments'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    public function approve(Request $request, $id)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'A' && $user->data->level  != 'E')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set PATCH method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        $data = array(
            'status' => 'P',
            'payment_date' => now()
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/payment')->with('success', 'Pembayaran berhasil diterima!');
        }
        else
        {
            return redirect('/payment')->with('error', 'Gagal menerima pembayaran!');
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'A' && $user->data->level  != 'E')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set PATCH method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        $data = array(
            'quantity' => 0,
            'quantity_reject' => (int) $request->quantity,
            'status' => 'R'
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/payment')->with('success', 'Pembayaran berhasil ditolak!');
        }
        else
        {
            return redirect('/payment')->with('error', 'Gagal menolak pembayaran!');
        }
    }

    public function report()
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'A')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/get/user/".$user->data->pk."/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '. $user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        // check the status code
        if ($status == 200) {
            $shop = json_decode($response);

            // create a new cURL resource
            $ch = curl_init();

            // set the URL and other options
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/get/all/0/".$shop->shop->pk."/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

            // set the headers
            $headers = array(
                'Content-Type: application/json', // specify the content type as JSON
                'Authorization: Token '. $user->token
            );

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // execute the request and get the response
            $response = curl_exec($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // close the cURL resource
            curl_close($ch);

            $payments = json_decode($response);

            // return a view if successful
            return view('tour.paymentreport', compact('payments'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    public function report_sa_shop()
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'SA')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '. $user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        // check the status code
        if ($status == 200) {
            $shops = json_decode($response);

            // return a view if successful
            return view('tour.paymentreportshop', compact('shops'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    public function report_sa($id)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        if($user->data->level != 'SA')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/payment/get/all/0/".$id."/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '. $user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        $payments = json_decode($response);

        // return a view if successful
        return view('tour.paymentreport', compact('payments'));
    }
}
