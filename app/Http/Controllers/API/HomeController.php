<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use DB;

class HomeController extends Controller
{
    use ApiTrait;
    /**
     *  @OA\Get(
     *     path="/api/home",
     *     tags={"Home"},
     *     security={{"bearer_token":{}}},  
     *     summary="Home",
     *     operationId="home",
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
    public function home(Request $request)
    {
        try{
            $category = Category::select('id','name','image','description')->get();
            $recommend = Post::latest()->get();
            $data['categoris'] = $category;
            $data['recommendations'] = $recommend;
            return $this->response($data, 'Home!'); 
        }catch(Exception $e){
            return $this->response([], $e->getMessage(), false);
        }
    }
}
