<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function storeCategory(Request $request){
            try{
                $rules['title'] = 'required';
                $rules['desc'] = 'required';
                $messages['title.required'] = 'Title required';
                $messages['desc.required'] = 'Description required';
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                }
                DB::beginTransaction();
                $category = new Category();
                $category->title = $request->get('title');
                $category->description = $request->get('desc');
                $category->created_at = Carbon::now()->format('Y-m-d');
                $category->save();
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

    public function getCategoryUsingAjax(){
        $category = Category::get()->pluck('title','id');
        return response()->json($category);
    }

    public function viewCategory(){
        $category = Category::with('subcategories')->get();
        return view('View-Category.view_category',['categories' => $category]);
    }


    public function subCategory(Request $request)
    {
//        if($request->ajax()){
//            $query = Category::with('subcategories')->get();
//            dd($query);
//            return Datatables::of($query)->make(true);
//        }
//
//        $query = Category::with('subcategories')->get();
//        return view('View-Category.view_category', ['query' => $query]);

    }

    public function deleteCategory($id){
                Subcategory::where('category_id',$id)->delete();
                $cat = Category::find($id);
                $cat->delete();
                 return redirect()->back()->with('status','Category deleted successfully');
    }

}
