<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryConrtoller extends Controller
{
    //
    protected $category;
    public function __construct(Category $category){
        $this->category = $category;
    }
    public function index()
    {
        //paginate(5) là phân trang ở phải có dòng Paginator::useBootstrapFive() ở hàm boot;
        //ở trong Providers/AppServiceProvider
        // $roles=Role::paginate(3);
        // cai duoi dung der hien thi nhung cai role moi tao len dau
        $categories=$this->category::latest('id')->paginate(3);

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $parentCategories=$this->category->getParents();
        return view('admin.categories.create',compact('parentCategories'));
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
       $dataCreate=$request->all();
       $category=$this->category->create($dataCreate);
       return redirect()->route('categories.index')->with('message','create category new < '. $category->name.' > successfully ');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category=$this->category->with('childrents')->findOrFail($id);
        $parentCategories=$this->category->getParents();
        return view('admin.categories.edit',compact('category','parentCategories'));
      
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
      $dateUpdate=$request->all();
      $category=$this->category->findOrFail($id);
      $category->update($dateUpdate);
      return redirect()->route('categories.index')->with('message','Update category  < '. $category->name.' > successfully ');


    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category=$this->category->findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('message','Delete category < '. $category->name.' > successfully ');
       
    }
}
