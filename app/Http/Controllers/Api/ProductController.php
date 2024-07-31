<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $objPro = new Product();
        $data = $objPro->loadDataWithPager();
        return response()->json($data);
    }
    private function uploadFile($file){
        $fileName = time().'_'.$file->getClientOriginalName();
        return $file->storeAs('image_product', $fileName, 'public');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->except('image');
        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $data['image'] = $this->uploadFile($request->file('image'));
        }
        $objPro = new Product();
        $res = $objPro->insertDataProduct($data);
        if($res){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['error' => false]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $objPro = new Product();
        $data = $objPro->getDataProductById($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $objPro = new Product();
        $check = $objPro->getDataProductById($id);

        if ($check){
            $imageOld = $check->image;
            $data = $request->except('image');
            if ($request->hasFile('image') && $request->file('image')->isValid()){
                $data['image'] = $this->uploadFile($request->file('image'));
                $flag = true;
            }else{
                $data['image'] = $imageOld;
            }
            $res = $objPro->updateDataProduc($data, $id);
            if($res){
                if($request->hasFile('image') && isset($imageOld) && Storage::disk('public')->exists($imageOld)){
                    Storage::disk('public')->delete($imageOld);
                }
                return response()->json(['success' => true, 'data'=>$res]);
            }else{
                return response()->json(['error' => false, 'data'=>$res]);
            }
        }else{
            return response()->json([],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $objPro = new Product();
        $check = $objPro->getDataProductById($id);
        $imageOld = $check->image;
        if ($check){
            $res = $objPro->deleteDataProduct($id);
            if($res){
//                if(isset($imageOld) && Storage::disk('public')->exists($imageOld)){
//                    Storage::disk('public')->delete($imageOld);
//                }
                return response()->json(['success' => true]);
            }else{
                return response()->json(['error' => false]);
            }
        }else{
            return response()->json([],404);
        }
    }
}
