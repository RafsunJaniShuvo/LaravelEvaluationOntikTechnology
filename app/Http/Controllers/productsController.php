<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class productsController extends Controller
{
    public function productsStore(Request $request){
        try{
            $rules['productsTitle'] = 'required';
            $rules['productsDesc'] = 'required';
            $rules['products'] = 'required';
            $rules['price'] = 'required';
            $rules['thumbnail'] = 'required';
            $messages['productsTitle.required'] = 'Products Title required';
            $messages['productsDesc.required'] = 'Products Description required';
            $messages['products.required'] = 'Products required';
            $messages['price.required'] = 'Price required';
            $messages['thumbnail.required'] = 'Thumbnail required';
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            DB::beginTransaction();
            $subcategory = new Product();
            $subcategory->title = $request->get('productsTitle');
            $subcategory->description = $request->get('productsDesc');
            $subcategory->subcategory_id  = $request->get('products');
            $subcategory->price  = $request->get('price');
            if ($request->hasFile('thumbnail')) {
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $fullPath = "uploads/thumbnail/" . $yearMonth.'images/';
                $correspondent_photo_name = $this->uploadFile($fullPath,$request->thumbnail);
                $subcategory->thumbnail = (!empty($correspondent_photo_name)) ? $fullPath . $correspondent_photo_name : null;
            }
            $subcategory->created_at = Carbon::now()->format('Y-m-d');
            $subcategory->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'messages' => "Data saved Successfully"
            ]);
//                return redirect()->back()->with('status', 'Product created successfully!');
        }
        catch(\Exception $e){
            #dd('File: '.$e->getFile().'Line: '.$e->getLine().'Message :'.$e->getMessage());
            DB::rollback();
        }

    }


    public function uploadFile($fullPath, $file){
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $fileName = trim(uniqid(config('app.name') . '-', true) . '.' .$file->extension());
        $file->move($fullPath, $fileName);
        return $fileName;
    }

    public function getsubCategoryUsingAjax(){
        $subcategory = Subcategory::get()->pluck('title','id');
        return response()->json($subcategory);
    }
    public function viewProducts(){
        $product = Product::with('subcategory')->get();
        return view('View-Products.products',['products' => $product]);
    }


}
