<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Business;
use App\Models\UserBio;
use App\Models\BusinessBio;
use Illuminate\Support\Str;
use Validator;
use DB;
use Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createUser(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => ['required'], 
            'email' => ['required', 'unique:users', 'email'],
            'family_size' => ['required', 'integer'],
            'address' => ['required'],
            'dob' => ['required'], 
            'bvn' => ['required', 'integer'], 
            'tin' => ['required', 'integer'], 
            'nin' => ['required'], 
            'loan_amount' => ['required', 'integer'], 
            'monthly_income' => ['required', 'integer'], 
            'expense' => ['required', 'integer'], 
            'loan_purpose' => ['required'],
            'medical_link' => ['required'],
            'financial_link' => ['required'],
            'gender' => ['required'],
            'employment_status' => ['required'],
        ]);

        try {
            
            if($validator->passes()){
                $getGender = DB::table('genders')->where('sex', $request->gender)->first();
                $getEmploymentStatus = DB::table('employments')->where('status', $request->employment_status)->first();
                //save user details
                $user = new User;
                $user->name = $request->name;
                $user->email= $request->email;
                $user->address= $request->address;
                $user->family_size = $request->family_size;
                $user->financial_path = "ndwwdwd";
                $user->medical_path = "medical_path";
                $user->gender_id = $getGender->id;
                $user->employment_id = $getEmploymentStatus->id;
                $user->token = Str::random(6);
                $user->save();
                //other user details
                $userBio = new UserBio;
                $userBio->dob = $request->dob;
                $userBio->bvn = $request->bvn;
                $userBio->tin = $request->tin;
                $userBio->nin = $request->nin;
                $userBio->loan_amount = $request->loan_amount;
                $userBio->monthly_income = $request->monthly_income;
                $userBio->expense = $request->expense;
                $userBio->loan_purpose = $request->loan_purpose;
                $userBio->user_id = $user->id;
                $userBio->save();
    
                return response()->json([
                    'message' => "you have successfully create your credit rating",
                    'data' => [
                        'token' => $user->token,
                    ]
                ], 201);
            }else{
                return response()->json([
                    'message' => $validator->errors(),
                ], 500);
            }

        } catch (Exception $ex) {
            return response()->json([
                'message' => 'something went wrong',
                'error' =>[
                    'value' => $ex->getMessage(),
                ]
            ], 500);
        }
        
    }

    public function getUser(Request $request){
        try {
            
            $user = User::where('token', $request->token)->with('userbios')->first();
            if(!empty($user)){
                return response()->json([
                    'message' => 'user found!',
                    'data'=>[
                        'user' => $user,
                    ]
                ], 200);
            }else{
                return response()->json([
                    'message' => 'user not found!',
                ], 400);
            }
            
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'something went wrong!',
            ], 400);
        }
        
    }

    public function updateUser(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'], 
            'email' => ['required', 'email', 'unique:businesses'],
            'family_size' => ['required', 'integer'],
            'address' => ['required'],
            'dob' => ['required'], 
            'bvn' => ['required', 'integer'], 
            'tin' => ['required', 'integer'], 
            'nin' => ['required'], 
            'loan_amount' => ['required', 'integer'], 
            'monthly_income' => ['required', 'integer'], 
            'expense' => ['required', 'integer'], 
            'loan_purpose' => ['required'],
            'medical_link' => ['required'],
            'financial_link' => ['required'],
            'gender' => ['required'],
            'employment_status' => ['required'],
        ]);

        try {
            
            if($validator->passes()){

                $getGender = DB::table('genders')->where('sex', $request->gender)->first();
                $getEmploymentStatus = DB::table('employments')->where('status', $request->employment_status)->first();
                //save user details
                $user = User::where('token', $request->token)->first();
                if (!empty($user)) {
                    $user->name = $request->name;

                    // check email
                    $userChecker = User::where('email', $request->email)->first();
                    if (!empty($userChecker)) {
                        // check if it belongs to user
                        $userChecker = User::where('email', $request->email)->where('token', $request->token)->first();

                        if(!empty($userChecker)){
                            $user->email = $user->email;
                        }else{
                            return response()->json([
                                'message' => "email has been used by another user",
                            ], 400);
                        }
                    }else{
                        $user->email = $request->email;
                    }

                    $user->address= $request->address;
                    $user->family_size = $request->family_size;
                    $user->financial_path = $request->financial_link;
                    $user->medical_path = $request->medical_link;
                    $user->gender_id = $getGender->id;
                    $user->employment_id = $getEmploymentStatus->id;
                    $user->token = $request->token;
                    $user->save();
                    //other user details
                    $userBio = UserBio::where('user_id', $user->id)->first();
                    $userBio->dob = $request->dob;
                    $userBio->bvn = $request->bvn;
                    $userBio->tin = $request->tin;
                    $userBio->nin = $request->nin;
                    $userBio->loan_amount = $request->loan_amount;
                    $userBio->monthly_income = $request->monthly_income;
                    $userBio->expense = $request->expense;
                    $userBio->loan_purpose = $request->loan_purpose;
                    $userBio->user_id = $user->id;
                    $userBio->save();
        
                    return response()->json([
                        'message' => "you have successfully updated your credit rating",
                        'data' => [
                            'token' => $user->token,
                        ]
                    ], 201);
                }else{
                    return response()->json([
                        'message' => "user does not exist",         
                    ], 401);
                }
                
            }else{
                return response()->json([
                    'message' => $validator->errors(),
                ], 500);
            }

        } catch (Exception $ex) {
            return response()->json([
                'message' => 'something went wrong',
                'error' =>[
                    'value' => $ex->getMessage(),
                ]
            ], 500);
        }

    }

    public function createBusiness(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => ['required'], 
            'email' => ['required', 'unique:businesses', 'email'],
            'date_corp' => ['required', 'integer'],
            'certificate_path' => ['required'],
            'incorp_path' => ['required'], 
            'cac_no' => ['required', 'integer'], 
            'tin_no' => ['required', 'integer'],
            'loan_amount' => ['required', 'integer'], 
            'revenue' => ['required', 'integer'],
            'capital' => ['required', 'integer'],  
            'current_debt' => ['required', 'integer'], 
            'prev_debt' => ['required', 'integer'],
            'loan_amount' => ['required', 'integer'],
            'loan_purpose' => ['required'],
        ]);

        try {
            
            if($validator->passes()){
                //save user details
                $business = new Business;
                $business->name = $request->name;
                $business->email= $request->email;
                $business->address= $request->address;
                $business->date_corp = $request->date_corp;
                $business->certificate_path = "ndwwdwd";
                $business->incorp_path = "medical_path";
                $business->token = Str::random(6);
                $business->save();
                //other user details
                $businessBio = new BusinessBio;
                $businessBio->cac_no = $request->cac_no;
                $businessBio->tin_no = $request->tin_no;
                $businessBio->loan_amount = $request->loan_amount;
                $businessBio->revenue = $request->revenue;
                $businessBio->loan_amount = $request->loan_amount;
                $businessBio->capital = $request->capital;
                $businessBio->current_debt = $request->current_debt;
                $businessBio->prev_debt = $request->prev_debt;
                $businessBio->loan_purpose = $request->loan_purpose;
                $businessBio->business_id = $business->id;
                $businessBio->save();
    
                return response()->json([
                    'message' => "you have successfully create your credit rating",
                    'data' => [
                        'token' => $business->token,
                    ]
                ], 201);
            }else{
                return response()->json([
                    'message' => $validator->errors(),
                ], 500);
            }

        } catch (Exception $ex) {
            return response()->json([
                'message' => 'something went wrong',
                'error' =>[
                    'value' => $ex->getMessage(),
                ]
            ], 500);
        }
        
    }

    public function getBusiness(Request $request){
        try {
            
            $business = Business::where('token', $request->token)->with('businessbios')->first();
            if(!empty($business)){
                return response()->json([
                    'message' => 'business found!',
                    'data'=>[
                        'user' => $business,
                    ]
                ], 200);
            }else{
                return response()->json([
                    'message' => 'business not found!',
                ], 400);
            }
            
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'something went wrong!',
            ], 400);
        }
        
    }

    public function updateBusiness(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'], 
            'email' => ['required','email', 'unique:users'],
            'date_corp' => ['required', 'integer'],
            'certificate_path' => ['required'],
            'incorp_path' => ['required'], 
            'cac_no' => ['required', 'integer'], 
            'tin_no' => ['required', 'integer'],
            'loan_amount' => ['required', 'integer'], 
            'revenue' => ['required', 'integer'],
            'capital' => ['required', 'integer'],  
            'current_debt' => ['required', 'integer'], 
            'prev_debt' => ['required', 'integer'],
            'loan_amount' => ['required', 'integer'],
            'loan_purpose' => ['required'],
        ]);

        try {
            
            if($validator->passes()){
                //save user details
                $business = Business::where('token', $request->token)->first();

                if(!empty($business)){
                    $business->name = $request->name;
                    
                    // check email
                    $businessChecker = Business::where('email', $request->email)->first();
                    if (!empty($businessChecker)) {
                        // check if it belongs to user
                        $businessChecker = Business::where('email', $request->email)->where('token', $request->token)->first();

                        if(!empty($businessChecker)){
                            $business->email = $business->email;
                        }else{
                            return response()->json([
                                'message' => "email has been used by another user",
                            ], 400);
                        }
                    }else{
                        $business->email = $request->email;
                    }

                    $business->address= $request->address;
                    $business->date_corp = $request->date_corp;
                    $business->certificate_path = "ndwwdwd";
                    $business->incorp_path = "medical_path";
                    $business->token = $request->token;
                    $business->save();
                    //other user details
                    $businessBio = BusinessBio::where('business_id', $business->id)->first();
                    $businessBio->cac_no = $request->cac_no;
                    $businessBio->tin_no = $request->tin_no;
                    $businessBio->loan_amount = $request->loan_amount;
                    $businessBio->revenue = $request->revenue;
                    $businessBio->loan_amount = $request->loan_amount;
                    $businessBio->capital = $request->capital;
                    $businessBio->current_debt = $request->current_debt;
                    $businessBio->prev_debt = $request->prev_debt;
                    $businessBio->loan_purpose = $request->loan_purpose;
                    $businessBio->business_id = $business->id;
                    $businessBio->save();
        
                    return response()->json([
                        'message' => "you have successfully updated your credit rating!",
                    ], 201);

                }else{
                    return response()->json([
                        'message' => "user does not exist!",
                    ], 401);
                }
                
            }else{
                return response()->json([
                    'message' => $validator->errors(),
                ], 500);
            }

        } catch (Exception $ex) {
            return response()->json([
                'message' => 'something went wrong',
                'error' =>[
                    'value' => $ex->getMessage(),
                ]
            ], 500);
        }

    }

}
