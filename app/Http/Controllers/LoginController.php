<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Session::get('user');

        if($user)
        {
            return redirect('/dash');
        }

        return view('tour.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/login/");
        curl_setopt($ch, CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        $data = array(
            'username' => $request->username,
            'password' => $request->password
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        // check the status code
        if ($status == 200) {
            $user = json_decode($response);

            Session::put('user', $user);
            // return a view if successful
            return redirect('dash');
        } else {
            // return an error message if not successful
            return redirect('/')->with('error', 'Username/Password Invalid');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register()
    {
        $user = Session::get('user');

        if($user)
        {
            return redirect('/dash');
        }

        return view('tour.register');
    }

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|min:3|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'required|min:8|max:16|confirmed',
        ]);

        // create a new cURL resource
        $ch = curl_init();

        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/create/");
        curl_setopt($ch, CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

        // set the headers
        $headers = array(
            'Content-Type: application/json', // specify the content type as JSON
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // set the data to send in the request body
        $data = array(
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => $request->password,
            'level' => 'C',
            'status' => false
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // encode the data as JSON

        // execute the request and get the response
        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close the cURL resource
        curl_close($ch);

        // check the status code
        if ($status == 201) {
            $user = json_decode($response);

            Session::put('user', $user);
            // return a view if successful
            return redirect('/dash');
        } else {
            // return an error message if not successful
            return redirect('/register')->with('error', 'Please use unique username, email, and phone number!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function logout()
    {

        $token = Session::get('user');

        if($token)
        {
            $token = $token->token;
        }

        if($token)
        {
            // create a new cURL resource
            $ch = curl_init();

            // set the URL and other options
            curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/tourdest/user/logout/");
            curl_setopt($ch, CURLOPT_POST, true); // set POST method
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response as a string

            // set the headers
            $headers = array(
                'Content-Type: application/json', // specify the content type as JSON
                'Authorization: Token '. $token
            );

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // execute the request and get the response
            $response = curl_exec($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // close the cURL resource
            curl_close($ch);

            if($status == 200)
            {
                Session::flush();

                return redirect('/');
            }
            else
            {
                return redirect('/dash');
            }
        }
        else
        {
            return redirect('/dash');
        }
    }

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
        //
    }
}
