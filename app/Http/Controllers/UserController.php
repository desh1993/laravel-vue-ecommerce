<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     *  returns all users with their orders.
     */
    public function index() 
    {
        //calling the orders() method defined on the User Model
        return response()->json(User::with(['orders'])->get());
    }

    public function login(Request $request)
    {
        $status = 401;
        $response = 'unauthorized';
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) 
        {
            # if authentication is successful , change $status and $response
            $status = 200;
            $response = [
                'user' => Auth::user() , 
                // Creating a token without scopes...
                'token' => Auth::user()->createToken('bigStore')->accessToken
            ];

        }
        return response()->json(['status' => $status , 'response' => $response]);
        // return response()->json($status , $response);
        
    }

    /**
     * Registration
     */
    public function registration(Request $request)
    {
        //Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        // if validation fails
        if ($validator->fails()) 
        {
            # code...
            return response()->json(['err' => $validator->errors()] , 401);
        }

        // Store the neccessary fields into data variable
        $data = $request->only(['name' , 'email' , 'password']);

        // Bcrypt the password
        $data['password'] = bcrypt($data['password']);

        // create data
        $user = User::create($data);

        //assign isadmin to 0
        $user->is_admin = 0;

        //return user obj with access Token
        return response()->json([
            'user' => $user ,
            'token'=> $user->createToken('bigStore')->accessToken
        ]);
        
    } //end of registration

    /**
     * gets the details of a user and returns them
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Get all the orders from that user along with the product
     */
    public function showOrders(User $user)
    {
        return response()->json($user->orders()->with('product')->get());
    }
}
