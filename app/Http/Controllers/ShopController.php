<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
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
            return view('tour.shoplist', compact('shops'));
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/A/false/");
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
            $admins = json_decode($response);
            return view('tour.shopadd', compact('admins'));
        }
        else
        {
            return redirect('/dash');
        }
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
            'location' => 'required|min:3|max:255',
            'status' => 'required',
            'admin' => 'required',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/");
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
            'location' => $request->location,
            'status' => $stat,
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 201)
        {
            $shop = json_decode($response);
            // create a new cURL resource
            $ch = curl_init();

            // set the URL and other options
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/");
            curl_setopt($ch, CURLOPT_POST, true); // set POST method
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

            // set the headers
            $headers = array(
                'Content-Type: application/json', // specify the content type as JSON
                'Authorization: Token '.$user->token
            );

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // set the data to send in the request body
            $data = array(
                'user_id_input' => $request->admin,
                'shop' => $shop->pk,
            );

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

            // execute the request and get the response
            $response = curl_exec($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // close the cURL resource
            curl_close($ch);

            if($status == 201)
            {
                return redirect('/shop')->with('success', 'Toko berhasil ditambah!');
            }
            else
            {
                return redirect('/shop')->with('error', 'Gagal menambah toko baru!');
            }

        }
        else
        {
            return redirect('/shop')->with('error', 'Gagal menambah toko baru !');
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
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/".$id."/");
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
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/product/all/".$shop->pk."/");
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

            if($shop->status == true || Session::get('user')->data->level != 'C')
            {
                $products = json_decode($response);
                // return a view if successful
                return view('tour.shopdetail', compact('shop', 'products'));
            }
            else
            {
                return redirect('/shop');
            }
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
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

        if($user->data->level != 'SA' && $user->data->level != 'A')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/get/".$id."/");
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
            $admin = null;

            foreach(json_decode($response) as $key=>$value)
            {
                if($value->user->level == 'A')
                {
                    $shop = json_decode($response)[$key]->shop;
                    $admin = json_decode($response)[$key]->user;
                    $shoppos = json_decode($response)[$key]->pk;
                    break;
                }
            }

            if(!$admin)
            {
                // create a new cURL resource
                $ch = curl_init();

                // set the URL and other options
                curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/".$id."/");
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

                $shop = json_decode($response);
                $shoppos = null;
                $admin = null;
            }

            if($user->data->level == 'SA')
            {
                // create a new cURL resource
                $ch = curl_init();

                // set the URL and other options
                curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/A/false/");
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
                   
                $admins = json_decode($response);
                return view('tour.shopedit', compact('shop', 'admin', 'admins', 'shoppos'));
            }
            else
            {
                return view('tour.shopeditadmin', compact('shop'));
            }       
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
            'location' => 'required|min:3|max:255',
            'status' => 'required',
            'admin' => 'required',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // set PUT method
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
            'location' => $request->location,
            'status' => $stat,
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            $shop = json_decode($response);

            if($request->shoppos)
            {
                // create a new cURL resource
                $ch = curl_init();

                // set the URL and other options
                curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/".$request->shoppos.'/');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // set PUT method
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

                // set the headers
                $headers = array(
                    'Content-Type: application/json', // specify the content type as JSON
                    'Authorization: Token '.$user->token
                );

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                // set the data to send in the request body
                $data = array(
                    'user_id_input' => $request->admin,
                    'shop' => $shop->pk,
                );

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

                // execute the request and get the response
                $response = curl_exec($ch);

                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                // close the cURL resource
                curl_close($ch);
            }
            else
            {
                // create a new cURL resource
                $ch = curl_init();

                // set the URL and other options
                curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // set POST method
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

                // set the headers
                $headers = array(
                    'Content-Type: application/json', // specify the content type as JSON
                    'Authorization: Token '.$user->token
                );

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                // set the data to send in the request body
                $data = array(
                    'user_id_input' => $request->admin,
                    'shop' => $shop->pk,
                );

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

                // execute the request and get the response
                $response = curl_exec($ch);

                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                // close the cURL resource
                curl_close($ch);
            }
            

            if($status == 200 || $status == 201)
            {
                return redirect('/shop')->with('success', 'Toko berhasil diedit!');
            }
            else
            {
                return redirect('/shop')->with('error', 'Gagal mengedit toko!');
            }

        }
        else
        {
            return redirect('/shop')->with('error', 'Gagal mengedit toko!');
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

        if($user->data->level != 'SA')
        {
            return redirect('/dash');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/get/".$id."/");
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

        foreach(json_decode($response) as $key=>$value)
        {
            // create a new cURL resource
            $ch = curl_init();

            // set the URL and other options
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/".$value->pk."/");
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

            // create a new cURL resource
            $ch = curl_init();

            // set the URL and other options
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$value->user->pk."/");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set DELETE method
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

            // set the headers
            $headers = array(
                'Content-Type: application/json', // specify the content type as JSON
                'Authorization: Token '.$user->token
            );

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // set the data to send in the request body
            $data = array(
                'status' => false
            );

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

            // execute the request and get the response
            $response = curl_exec($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // close the cURL resource
            curl_close($ch);
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/".$id."/");
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
            return redirect('/shop')->with('success', 'Toko berhasil dihapus!');
        }
        else
        {
            return redirect('/shop')->with('error', 'Gagal menghapus toko!');
        }
    }

    public function shop_admin()
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

            // return a view if successful
            return view('tour.shopdetailadmin', compact('shop'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    public function update_admin(Request $request, $id)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'location' => 'required|min:3|max:255',
            'status' => 'required',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shop/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // set PUT method
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
            'location' => $request->location,
            'status' => $stat,
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/shops/detail')->with('success', 'Toko berhasil diedit!');

        }
        else
        {
            return redirect('/shops/detail')->with('error', 'Gagal mengedit toko!');
        }
    }
}
