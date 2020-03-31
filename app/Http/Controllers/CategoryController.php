<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request)
    {
        $data = ['nama_category' => $request->input('nama_category')];
        $respon = Category::create($data);
        if($respon){
            return response()->json([
                'status' => true,
                'message' => 'Data Category Created!',
                'data' => $respon
            ],201);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data Not Created!',
                'data' => ''
            ],404);
        }
    }

    public function destroy($id)
    {
        $respon = Category::destroy($id);
        if($respon){
            return response()->json([
                'status' => true,
                'message' => 'Data Category Deleted!',
                'data' => ''
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data Category Not Found!',
                'data' => ''
            ],404);
        }
    }
}
