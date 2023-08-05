<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
        public function SubCategoryStore(Request $request){
            try{

                $rules['subtitle'] = 'required';
                $rules['subdesc'] = 'required';
                $rules['subCategoryId'] = 'required';
                $messages['subtitle.required'] = 'Sub Title required';
                $messages['subdesc.required'] = 'Sub Category Description required';
                $messages['subCategoryId.required'] = 'Sub Category required';
                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                }
                DB::beginTransaction();
                $subcategory = new Subcategory();
                $subcategory->title = $request->get('subtitle');
                $subcategory->description = $request->get('subdesc');
                $subcategory->category_id  = $request->get('subCategoryId');
                $subcategory->created_at = Carbon::now()->format('Y-m-d');
                $subcategory->save();
                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'messages' => "Data saved Successfully"
                ]);
                // Redirect to a page (e.g., index page)
//                return redirect()->back()->with('status', 'Product created successfully!');
            }
            catch(\Exception $e){
                #dd('File: '.$e->getFile().'Line: '.$e->getLine().'Message :'.$e->getMessage());
                DB::rollback();
            }

        }

        public function viewSubCategory(){
            $subCategory = Subcategory::with('products')->get();
            return view('View-SubCategory.sub-category',['subCategories' => $subCategory]);
        }

    public function deleteSubCategory($id){
        Product::where('subcategory_id',$id)->delete();
        Subcategory::find($id)->delete();
        return redirect()->back()->with('status','Sub Category deleted successfully');
    }
}
