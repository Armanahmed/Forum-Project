<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use Session;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $categoryposts = DB::table('categories')
            ->join('posts', 'categories.id', '=', 'posts.category_id')
            ->select('categories.id as cat_id', 'posts.id as post_id')
            ->where('categories.id', '!=', 'posts.id')
            ->get();
        // dd($categoryposts);


        return view('categories.index')->withCategories($categories)->withCategoryposts($categoryposts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'category_name' => 'bail|required|min:3|unique:categories,category_name',
            'category_detail' => 'bail|required',

        ));

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->category_detail = $request->category_detail;

        $category->save();

        Session::flash('success', 'Successfull ! The new Category is added to the list.');

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        $categoryposts = DB::table('categories')
            ->join('posts', 'categories.id', '=', 'posts.category_id')
            ->select('categories.id as cat_id', 'posts.id as post_id')
            ->where('categories.id', '!=', 'posts.id')
            ->get();

        $post_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->select('departments.dept_name', 'periods.period_name', 'posts.id as post_id', 'posts.anonymous as anonymous_post', 'posts.post_details', 'posts.created_at as post_created')
            ->where('posts.category_id', '=', $id)
            // ->where([ ['departments.id', '=', $department_id->department_id], ['periods.id', '=', $period_id->period_id] ])
            ->get();
        return view('categories.show')->withCategory($category)->withCategoryposts($categoryposts)->withPosts($post_list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit')->withCategory($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if($category->category_name == $request->category_name){
            $this->validate($request, array(
                'category_detail' => 'bail|required'
            ));
        } else {
            $this->validate($request, array(
                'category_name' => 'bail|required|min:3|unique:categories,category_name',
                'category_detail' => 'bail|required'
            ));
        }
        

        $category->category_name = $request->category_name;
        $category->category_detail = $request->category_detail;

        $category->save();

        Session::flash('success', 'Successfull ! The Category is edited.');

        return redirect()->route('categories.show', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        Session::flash('success', 'The Category was successfully deleted.');

        return redirect()->route('categories.index');
    }
}
