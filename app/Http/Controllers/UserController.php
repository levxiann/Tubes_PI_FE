<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$user->data->pk."/");
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
            $user = json_decode($response);
            return view('tour.userprofile', compact('user'));
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

        return view('tour.useraddadmin');
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

        if($user->data->level != 'SA')
        {
            return redirect('/dash');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|min:3|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'required|min:3|max:16|confirmed',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/");
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
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => $request->password,
            'level' => 'A',
            'status' => false
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 201)
        {
            return redirect('/user')->with('success', 'Admin berhasil ditambah!');
        }
        else
        {
            return redirect('/user')->with('error', 'Gagal menambah admin! Pastikan menggunakan username, email, dan no. telp. yang unik!');
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
    public function edit()
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$user->data->pk."/");
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
            $user = json_decode($response);
            return view('tour.userprofileedit', compact('user'));
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
    public function update(Request $request)
    {
        $user = Session::get('user');

        if(!$user)
        {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|min:3|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'max:16|confirmed',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$user->data->pk."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set PATCH method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        if($request->password)
        {
            $data = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'password' => $request->password,
            );
        }
        else
        {
            $data = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
            );
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            $user->data = json_decode($response);

            Session::put('user', $user);

            return redirect('/user/profile')->with('success', 'User profile berhasil diedit!');
        }
        else
        {
            return redirect('/user/profile')->with('error', 'Gagal mengedit user profile! Pastikan menggunakan username, email, dan no. telp. yang unik!');
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$id."/");
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
            return redirect('/user')->with('success', 'User berhasil dihapus!');
        }
        else
        {
            return redirect('/user')->with('error', 'Gagal menghapus user!');
        }
    }

    public function list()
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/");
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
            $users = json_decode($response);
            return view('tour.userlist', compact('users'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    public function edit_sa($id)
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$id."/");
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
            $user = json_decode($response);
            return view('tour.usereditadmin', compact('user'));
        }
        else
        {
            return redirect('/dash');
        }
    }

    public function update_sa(Request $request, $id)
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

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|min:3|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'max:16|confirmed',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set PATCH method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        if($request->password)
        {
            $data = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'password' => $request->password,
            );
        }
        else
        {
            $data = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
            );
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/user')->with('success', 'User berhasil diedit!');
        }
        else
        {
            return redirect('/user')->with('error', 'Gagal mengedit user! Pastikan menggunakan username, email, dan no. telp. yang unik!');
        }
    }

    public function list_admin()
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
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/shoppos/get/".$shop->shop->pk."/");
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

            $users = json_decode($response);

            $shop = $shop->shop->pk;

            // return a view if successful
            return view('tour.userlistadmin', compact('users', 'shop'));
        } else {
            // return an error message if not successful
            return redirect('/dash');
        }
    }

    public function create_em($id)
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

        return view('tour.useraddemployee', compact('shop'));
    }

    public function store_em(Request $request)
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

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|min:3|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'required|min:3|max:16|confirmed',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/");
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
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => $request->password,
            'level' => 'E',
            'status' => false
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 201)
        {
            $emp = json_decode($response);

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
                'user_id_input' => $emp->data->pk,
                'shop' => $request->shop
            );

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

            // execute the request and get the response
            $response = curl_exec($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // close the cURL resource
            curl_close($ch);

            return redirect('/user/admin')->with('success', 'Karyawan berhasil ditambah!');
        }
        else
        {
            return redirect('/user/admin')->with('error', 'Gagal menambah karyawan! Pastikan menggunakan username, email, dan no. telp. yang unik!');
        }
    }

    public function edit_em($id)
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$id."/");
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
            $user = json_decode($response);
            return view('tour.usereditemployee', compact('user'));
        }
        else
        {
            return redirect('/dash');
        }
    }

    public function update_em(Request $request, $id)
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

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|min:3|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'max:16|confirmed',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$id."/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // set PATCH method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
            'Authorization: Token '.$user->token
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        if($request->password)
        {
            $data = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'password' => $request->password,
            );
        }
        else
        {
            $data = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
            );
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        if($status == 200)
        {
            return redirect('/user/admin')->with('success', 'Karyawan berhasil diedit!');
        }
        else
        {
            return redirect('/user/admin')->with('error', 'Gagal mengedit karyawan! Pastikan menggunakan username, email, dan no. telp. yang unik!');
        }
    }

    public function destroy_em($id)
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
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/".$id."/");
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
            return redirect('/user/admin')->with('success', 'Karyawan berhasil dihapus!');
        }
        else
        {
            return redirect('/user/admin')->with('error', 'Gagal menghapus karyawan!');
        }
    }

}
