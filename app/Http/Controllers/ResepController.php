<?php

namespace App\Http\Controllers;
use App\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;


class ResepController extends Controller
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

    public function show(Request $request)
    {
        $respon = DB::table('resep')
                      ->join('category','resep.category_id','=','category.id')
                      ->join('users','resep.author_id','=','users.id')
                      ->select('resep.*','nama_category','name')
                      ->get();
        if($respon){
            return response()->json([
                'status' => true,
                'message' => 'Success Read Data',
                'data' => $respon
            ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Bad request',
                    'data' => ''
                ],500);
        }               
    }

    public function save(Request $request)
    {
        $response = null;
        $user = (object) ['gambar' => ''];

        if($request->hasFile('gambar')){
            // ambil nama asli file
            $original_filename = $request->file('gambar')->getClientOriginalName();
            // regex .extensifile
            $original_file_arr = explode('.',$original_filename);
            // ambil extensi file dan taro dibagian akhir
            $file_ext = end($original_file_arr);
            // path folder image yang akan di upload
            $destination_path = './upload/user/';
            // ganti nama file menjadi
            $image = 'U-'.time().'.'.$file_ext;

            if($request->file('gambar')->move($destination_path,$image)){
                $user->image = './upload/user/'.$image;
                $data = [
                    'nama_resep' => $request->input('nama_resep'),
                    'gambar' => 'public/upload/user/'.$image,
                    'category_id' => $request->input('category_id'),
                    'deskripsi' => $request->input('deskripsi'),
                    'author_id' => $request->input('author_id')
                ];
                $respon = Resep::create($data);
                if($respon){
                    return $this->responseRequestSuccess($data);
                }else{
                    return $this->responseRequestError('Cannot upload file');
                }
            }else{
                return $this->responseRequestError('Cannot upload file');
            }
        }else{
            return $this->responseRequestError('File not found');
        }
    }

    protected function responseRequestSuccess($id = null,$data)
    {
        if($id){
            return response()->json([
                'status' => true,
                'message' => 'resep success Updated!',
                'data' => $data
            ], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }else{
            return response()->json([
                'status' => true,
                'message' => 'resep success created!',
                'data' => $data
            ], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }
    }

    protected function responseRequestError($id = null, $message = 'Bad request', $statusCode = 200)
    {
       if($id){
        return response()->json([
            'status' => false,
            'message' => 'resep error updated!',
            'data' => ''
        ], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
       }else{
        return response()->json([
            'status' => false,
            'message' => 'resep error created!',
            'data' => ''
        ], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
       }
    }
    
    public function details($id)
    {
        $respon = Resep::find($id);
        if($respon){
            return response()->json([
                'status' => true,
                'message' => 'Details Resep!',
                'data' => $respon
            ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Resep Not Found',
                    'data' => ''
                ],404);
        } 
    }

    public function destroy($id)
    {
        $respon = Resep::destroy($id);
        if($respon){
            return response()->json([
                'status' => true,
                'message' => 'Deleted Resep Id '.$id
            ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Id Resep Not Found'
                ],404);
        }
    }

    public function update(Request $request)
    {
        $response = null;
        $user = (object) ['gambar' => ''];

        if($request->hasFile('gambar')){
            // ambil nama asli file
            $original_filename = $request->file('gambar')->getClientOriginalName();
            // regex .extensifile
            $original_file_arr = explode('.',$original_filename);
            // ambil extensi file dan taro dibagian akhir
            $file_ext = end($original_file_arr);
            // path folder image yang akan di upload
            $destination_path = './upload/user/';
            // ganti nama file menjadi
            $image = 'U-'.time().'.'.$file_ext;

            if($request->file('gambar')->move($destination_path,$image)){
                $user->image = './upload/user/'.$image;
                $data = [
                    'nama_resep' => $request->input('nama_resep'),
                    'gambar' => 'public/upload/user/'.$image,
                    'category_id' => $request->input('category_id'),
                    'deskripsi' => $request->input('deskripsi'),
                    'author_id' => $request->input('author_id')
                ];
                $respon = Resep::where('id',$request->id )->update($data);
                $id = $request->id;
                if($respon){
                    return $this->responseRequestSuccess($id,$data);
                }else{
                    return $this->responseRequestError($id,'Cannot upload file');
                }
            }else{
                return $this->responseRequestError($id,'Cannot upload file');
            }
        }else{
            return $this->responseRequestError($id,'File not found');
        }
    }
    
}
