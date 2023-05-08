<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
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

        if($user->data->level != 'A' && $user->data->level != 'E')
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
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/all/".$shop->shop->pk."/");
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

            $products = json_decode($response);

            // return a view if successful
            return view('tour.productlist', compact('shop', 'products'));
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
    public function create($id)
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

        $shop = $id;

        return view('tour.productadd', compact('shop'));
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

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required',
            'description' => 'required|string|min:3|max:255',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/");
        curl_setopt($ch, CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if($request->status == "1")
        {
            $stat = true;
        }
        else
        {
            $stat = false;
        }

        // set the data to send in the request body
        $data = array(
            'name' => $request->name,
            'shop' => $request->shop,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $stat,
            'description' => $request->description
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 201)
        {
            return redirect('/product')->with('success', 'Produk berhasil ditambah!');
        }
        else
        {
            return redirect('/product')->with('error', 'Gagal menambah produk baru !');
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/".$id."/");
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

        if($status == 200)
        {
            $product = json_decode($response);
            return view('tour.productedit', compact('product'));
        }
        else
        {
            return redirect('/dash');
        }
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
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'price' => 'required|integer|min:0',
            'status' => 'required',
            'description' => 'required|string|min:3|max:255',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set PATCH method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if($request->status == "1")
        {
            $stat = true;
        }
        else
        {
            $stat = false;
        }

        // set the data to send in the request body
        $data = array(
            'name' => $request->name,
            'price' => $request->price,
            'status' => $stat,
            'description' => $request->description
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/product')->with('success', 'Produk berhasil diedit!');
        }
        else
        {
            return redirect('/product')->with('error', 'Gagal mengedit produk!');
        }
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

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // set PATCH method
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
            return redirect('/product')->with('success', 'Produk berhasil dihapus!');
        }
        else
        {
            return redirect('/product')->with('error', 'Gagal menghapus produk!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editstock($id)
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

        $product = $id;
        return view('tour.productaddstock', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatestock(Request $request, $id)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        $request->validate([
            'stock' => 'required|integer|min:1',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/stock/".$id."/");
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
            'stock' => (int)$request->stock
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/product')->with('success', 'Stok berhasil ditambah!');
        }
        else
        {
            return redirect('/product')->with('error', 'Gagal menambah stok!');
        }
    }
}
