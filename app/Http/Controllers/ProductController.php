<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $sections=Section::all();
        $products=Product::all();
        return view('products.products',compact('sections','products'));
    }
    public function store(Request $request){

        $validatedData = $request->validate([
            'Product_name' => 'required|unique:products|max:255',
        ],[
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا',
        ]);

        Product::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    public function update(Request $request){
        $id = $request->id;

        $this->validate($request, [

            'Product_name' => 'required|max:255|unique:products,Product_name,'.$id,
        ],[

            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا',

        ]);

        $products = Product::find($id);
        $products->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    public function destroy(Request $request){
        $id=$request->id;
        $product = Product::findOrFail($id);
        $product->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
