<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Follower;
use App\Models\Country;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use DB;
use Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SocialPlatform;


/**
* @OA\Info(
*      description="",
*     version="1.0.0",
*      title="Quick Demo",
* )
**/
 
/**
*  @OA\SecurityScheme(
*     securityScheme="bearer_token",
*         type="http",
*         scheme="bearer",
*     ),
**/
class UserController extends Controller
{


    use ApiTrait;

    public function handleGoogle(Request $request)
    {
        try {
            // $user = Socialite::with('google')->stateless()->user();
            // $user = Socialite::with('google')->userFromToken($request->token);
            $user = Socialite::with('google')->stateless()->userFromToken($request->token);
            if(!$user){
                return $this->response([], "Unauthorized user!", false);
            }
            return $this->handleUser($user, "google", $request);
        } catch (Exception $e) {
            return $this->response([], $e->getMessage(), false);
        }
    }

    public function handleFacebook(Request $request)
    {
        try {
            $user = Socialite::with('facebook')->stateless()->userFromToken($request->token);
            if(!$user){
                return $this->response([], "Unauthorized user!", false);
            }
            // return $this->response($user);
            return $this->handleUser($user, "facebook", $request);
        } catch (Exception $e) {
            return $this->response([], $e->getMessage(), false);
        }
    }

    public function handleApple(Request $request)
    {
        try {
            $user = Socialite::with('apple')->stateless()->userFromToken($request->token);
            if(!$user){
                return $this->response([], "Unauthorized user!", false);
            }
            // return $this->response($user);
            return $this->handleUser($user, "apple", $request);
        } catch (Exception $e) {
            return $this->response([], $e->getMessage(), false);
        }
    }

    private function handleUser($ssoUser, $ssoPlatform,$request)
    {
        try{
            $user = User::where('social_id', $request->social_id)->first();
            $checkUser = User::where('social_id', $request->social_id)->first();
            if (!$user) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->avatar = $request->avatar;
                $user->type = $request->type;
                $user->social_type = $ssoPlatform;
                $user->social_id = $request->social_id;
            }
            $user->lat = $request->lat;
            $user->lang = $request->lang;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->firebase_id = $request->firebase_id;
            $user->save();
            if(!$checkUser){
                $user->assignRole([2]);
            }
            $platform = SocialPlatform::where('platform', $ssoPlatform)->where('platform_id', $ssoUser->id)->first();

            if ($platform && $platform->user_id !== $user->id) {
                $platform->delete();
                $platform = false;
            }

            if (!$platform) {
                $platform = new SocialPlatform();
            }

            $platform->user_id = $user->id;
            $platform->platform_id = $ssoUser->id;
            $platform->platform  = $ssoPlatform;
            $platform->avatar =  $ssoUser->avatar;
            $platform->save();

            $user = User::find($user->id);
            /* Common response for login */
            return $this->login($user);
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false,404);
        }
    }

    /**
     *  @OA\Post(
     *     path="/api/register",
     *     tags={"User"},
     *     summary="Create Account",
     *     security={{"bearer_token":{}}},
     *     operationId="create account",
     * 
     *     @OA\Parameter(
     *         name="user_name",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="gender",
     *         required=true,
     *         description="1 - Male | 2 - female", 
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="dob",
     *         required=true,
     *         description="yyyy-mm-dd", 
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ), 
     *      
     *     @OA\Parameter(
     *         name="phone",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_name' => 'required|min:6|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'first_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'gender' => 'required|in:1,2',
            'password' => 'required|min:8',
            'country_id' => 'required|exists:countries,id',
        ]);

        if($validator->fails())
        {
            return $this->response([], $validator->errors()->first(), false);
        }

        try{
            $user = new User;
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->password = bcrypt($request->password);
            $user->country_id = $request->country_id;
            $user->dob = $request->dob;
            $user->phone = $request->phone;
            $user->save();
            return $this->response('','Registered Successully!');
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }

    }
    /**
     *  @OA\Post(
     *     path="/api/login",
     *     tags={"User"},
     *     summary="Login",
     *     security={{"bearer_token":{}}},
     *     operationId="login",
     * 
     *     @OA\Parameter(
     *         name="user_name",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="password",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="device_type",
     *         description="android | ios",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="device_token",
     *         description="device token for push notification",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_name' => 'required|exists:users',
            'password' => 'required',
            'device_type' => 'nullable|in:android,ios'
        ]);

        if($validator->fails())
        {
            return $this->response([], $validator->errors()->first(), false);
        }

        try{
            $user = User::where('user_name',$request->user_name)->first();
            if($user){
                if(Hash::check($request->password,$user->password)){
                    $user->device_type = $request->device_type;
                    $user->device_token = $request->device_token;
                    $user->tokens()->delete();
                    $token = $user->createToken('API')->accessToken;
                    $user['token'] = $token;
                    return $this->response($user,'Login Successully!');
                }else{
                    return $this->response([], 'Enter valid password!', false); 
                }   
            }
            return $this->response([], 'Enter Valid user name', false); 

        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }

    }
    /**
     *  @OA\Get(
     *     path="/api/profile",
     *     tags={"User"},
     *     security={{"bearer_token":{}}},  
     *     summary="Get User Profile",
     *     operationId="profile",
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function me()
    {
        try{
            $user = User::withCount(['following','follower'])->find(Auth::id());
            return $this->response($user, 'Profile!'); 
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }

    }
    /**
     *  @OA\Post(
     *     path="/api/profile/edit",
     *     tags={"User"},
     *     summary="Edit Profile",
     *     security={{"bearer_token":{}}},
     *     operationId="edit-profile",
     * 
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="gender",
     *         required=true,
     *         description="1 - Male | 2 - female", 
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="dob",
     *         required=true,
     *         description="yyyy-mm-dd", 
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ), 
     *      
     *     @OA\Parameter(
     *         name="phone",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="photo",
     *                    description="User Profile photo",
     *                    type="array",
     *                    @OA\Items(type="file", format="binary")
     *                 ),
     *		        ),
     *          ),
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function edit_profile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'first_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'gender' => 'required|in:1,2',
            'country_id' => 'required|exists:countries,id',
            'photo' => 'nullable|image|mimes:svg,jpeg,jpg,gif',
        ]);

        if($validator->fails())
        {
            return $this->response([], $validator->errors()->first(), false);
        }

        try{
            $filename = null;
            if($request->hasFile('photo'))
            {
                $file = $request->file('photo');
                $filename = time().$file->getClientOriginalName();
                $file->move(public_path().'/user/', $filename);  
            }
            $user = User::find(Auth::id());
            if($user){
                $user->email = $request->email;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->gender = $request->gender;
                $user->dob = $request->dob;
                $user->country_id = $request->country_id;
                if($request->hasFile('photo'))
                {
                    $user->photo = $filename;
                }
                $user->save();
                return $this->response($user, 'User updated successfully!');
            }
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }
    }
    /**
     *  @OA\Post(
     *     path="/api/username/check",
     *     tags={"User"},
     *     summary="Username Check available or not register time",
     *     operationId="Username-Check",
     * 
     *     @OA\Parameter(
     *         name="user_name",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function check_username(Request $request){
        $validator = Validator::make($request->all(),[
            'user_name' => 'required|min:6|max:255',
        ]);

        if($validator->fails())
        {
            return $this->response([], $validator->errors()->first(), false);
        }

        $user = User::where('user_name', $request->user_name)->first();
        if($user){
            return $this->response([], 'Already taken this username!', false);
        }
        return $this->response('','Username Available!');
    }
    /**
     *  @OA\Get(
     *     path="/api/logout",
     *     tags={"User"},
     *     security={{"bearer_token":{}}},  
     *     summary="Logout",
     *     security={{"bearer_token":{}}},
     *     operationId="Logout",
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function logout()
    {
        try{
            $user = User::find(Auth::id());
            $user->tokens()->delete();
            return $this->response('','Logout Successfully!');
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }
       
    }
    /**
     *  @OA\Get(
     *     path="/api/countries",
     *     tags={"Country"},
     *     security={{"bearer_token":{}}},  
     *     summary="Get Country List",
     *     security={{"bearer_token":{}}},
     *     operationId="Country",
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function get_countries()
    {
        try{
            $countries = Country::select('id','name','code')->get();
            return $this->response($countries,'Country List');
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }
    }
    /**
     *  @OA\Post(
     *     path="/api/following",
     *     tags={"Followers"},
     *      security={{"bearer_token":{}}},  
     *     summary="following specific user",
     *     operationId="Username-Check",
     * 
     *     @OA\Parameter(
     *         name="follow_to",
     *         required=true,
     *         description="pass user id",
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function following(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'follow_to' => 'required|exists:users,id',
        ]);

        if($validator->fails())
        {
            return $this->response([], $validator->errors()->first(), false);
        }

        try{
            $follow = Follower::where('follow_by',Auth::id())->where('follow_to',$request->follow_to)->first();
            if($follow)
            {
                return $this->response('','Already following!');
            }
            $follow = new Follower;
            $follow->follow_by = Auth::id();
            $follow->follow_to = $request->follow_to;
            $follow->save();
            return $this->response('','Following successfully!');
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }
        
    }
    /**
     *  @OA\Get(
     *     path="/api/following/list",
     *     tags={"Followers"},
     *     security={{"bearer_token":{}}},  
     *     summary="Get following List",
     *     security={{"bearer_token":{}}},
     *     operationId="Following-list",
     *      
     *     @OA\Parameter(
     *         name="search",
     *         description="search by first name, last name, and user_name",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
    public function get_following(Request $request)
    {
        try{
            $query = Follower::query()
                            ->leftJoin('users','followers.follow_to','=','users.id')
                            ->leftJoin('posts','followers.follow_to','=','posts.post_by')
                            ->select('users.id as user_id','users.user_name','users.photo','users.first_name','users.last_name',DB::raw('COUNT(posts.id) as posts'))
                            ->groupBy('followers.follow_to');

            if($request->search != null)
            {
                $query = $query->where('users.first_name','Like','%'.$request->search.'%')
                            ->orWhere('users.last_name','Like','%'.$request->search.'%')
                            ->orWhere('users.user_name','Like','%'.$request->search.'%');
            }
            $query = $query->where('follow_by',Auth::id());

            $followings = $query->paginate(10);
            foreach($followings as $f)
            {
                if($f->photo != null)
                {
                    $f->photo = asset('/user/' . $f->photo);
                }
            }
            return $this->response($followings,'Following users!');
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }
        
    }
    /**
     *  @OA\Get(
     *     path="/api/follower/list",
     *     tags={"Followers"},
     *     security={{"bearer_token":{}}},  
     *     summary="Get following List",
     *     security={{"bearer_token":{}}},
     *     operationId="Follower-list",
     * 
     *     @OA\Parameter(
     *         name="search",
     *         description="search by first name, last name, and user_name",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
   public function get_followers(Request $request)
   {
       try{
           $query = Follower::query()
                           ->leftJoin('users','followers.follow_by','=','users.id')
                           ->leftJoin('posts','followers.follow_by','=','posts.post_by')
                           ->select('users.id as user_id','users.user_name','users.photo','users.first_name','users.last_name', DB::raw('COUNT(posts.id) as posts'))
                           ->groupBy('followers.follow_by');
            if($request->search != null)
            {
                $query = $query->where('users.first_name','Like','%'.$request->search.'%')
                            ->orWhere('users.last_name','Like','%'.$request->search.'%')
                            ->orWhere('users.user_name','Like','%'.$request->search.'%');
            }

            $query = $query->where('follow_to',Auth::id());

            $followings = $query->paginate(10);
           foreach($followings as $f)
           {
               if($f->photo != null)
               {
                   $f->photo = asset('/user/' . $f->photo);
               }
           }
           return $this->response($followings,'Follower users!');
       }catch(Exception $e){
           return $this->response([], $e->getMessage(), false);
       }
       
   }
   /**
     *  @OA\Post(
     *     path="/api/notification/enable",
     *     tags={"Notification"},
     *     security={{"bearer_token":{}}},  
     *     summary="Notification enable disable",
     *     security={{"bearer_token":{}}},
     *     operationId="notification-enable-disable",
     * 
     *     @OA\Parameter(
     *         name="status",
     *         description="1 - enable | 2 - disbale",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
   public function notification_enable(Request $request)
   {
    $validator = Validator::make($request->all(),[
        'status' => 'required|in:1,2',
    ]);

    if($validator->fails())
    {
        return $this->response([], $validator->errors()->first(), false);
    }
       try{
            $user = User::find(Auth::id());
            $user->is_notification = $request->status;
            $user->save();
            if($request->status == 1){
                $msg = 'Notification Enabled successfully!';
            }else{
                $msg = 'Notification Disabled successfully!';
            }
            return $this->response('',$msg);
       }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
       }
   }
   /**
     *  @OA\Post(
     *     path="/api/change/password",
     *     tags={"User"},
     *     summary="Change Password",
     *     security={{"bearer_token":{}}},
     *     operationId="change-password",
     * 
     *     @OA\Parameter(
     *         name="current_password",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="password",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     ),
     * )
    **/
   public function change_password(Request $request)
   {
    $validator = Validator::make($request->all(),[
        'current_password' => 'required',
        'password' => 'required|min:8',
    ]);

    if($validator->fails())
    {
        return $this->response([], $validator->errors()->first(), false);
    }

    try{
        $user = User::find(Auth::id());
        if($user){
            if(Hash::check($request->current_password,$user->password)){
                $user->password =  bcrypt($request->password);
                $user->save();
                return $this->response('','Password changed Successully!');
            }else{
                return $this->response([], 'Not matched current password!', false); 
            }   
        }
        return $this->response([], 'Enter Valid user name', false); 

    }catch(Exception $e){
        return $this->response([], $e->getMessage(), false);
    }
   }
   /**
	 *  @OA\Post(
	 *     path="/api/forgot/password",
	 *     tags={"User"},
	 *     summary="Forgot password",
	 *     operationId="forgot-password",
	 * 
	 *     @OA\Parameter(
	 *         name="email",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string"
	 *         )
	 *     ),    
	 *     @OA\Response(
	 *         response=200,
	 *         description="Success",
	 *         @OA\MediaType(
	 *             mediaType="application/json",
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Unauthorized"
	 *     ),
	 *     @OA\Response(
	 *         response=400,
	 *         description="Invalid request"
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="not found"
	 *     ),
	 * )
	**/
	public function forgot_password(Request $request)
	{
		
		$validator = Validator::make($request->all(),[
			'email' => 'required|email|exists:users,email',
		]);

		if($validator->fails())
		{
			return $this->sendError($validator->messages()->first(),null,200);
		}
		$user = User::where('email',$request->email)->first();
        if(empty($user))
        {
            return $this->sendError('This email not registered'); 
        }

        try{
            $newPass = substr(md5(time()), 0, 10);
            $user->password = bcrypt($newPass);
            $user->save();
            $data = [
                'username' => $user->user_name,
                'password' => $newPass
            ];
            $email = $user->email;
            Mail::send('mail.forgot', $data, function($message) use ($email) {
                $message->to($email, 'test')->subject
                   ('Forgot Password');
            });
            return $this->response('','Email sent succesfully!');

        } catch (Exception $e)
        {
            return $this->response([], $e->getMessage(), false);
        }      
		
    }
    
    

}
