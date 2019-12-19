<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Category;
use App\User;
use App\Post;
use App\File;
use App\Department;
use App\Comment;
use App\Like;
use DB;
use DateTime;
use Illuminate\Support\Facades\Response;

class ManageController extends Controller
{
    public function entrypage() {

        if(Auth::check()){
            // dd(Auth::user()->role);
            if (Auth::user()->role == 'coordinator') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'staff') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'manager') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'student') {
                return redirect('ideapanel');
            }
        }
        
        return view('login'); // only guests will see this
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentuserid = Auth::user()->id;
        $currentuserrole = Auth::user()->role;
        // dd($currentuserid);
        // if($currentuserrole == 'staff'){

        //     $department_name = DB::table('departments_users')
        //         ->join('departments', 'departments_users.department_id', '=', 'departments.id')
        //         ->select('departments.dept_name')
        //         ->where('departments_users.user_id', '=', $currentuserid)
        //         ->first();        

        // }
        $totalposts = DB::table('posts')
                ->count();
        // dd($totalposts);
        $deptideas = DB::table('posts')
                ->join('departments', 'posts.department_id', '=', 'departments.id')
                ->select('department_id', 'dept_name', DB::raw('COUNT(department_id) as all_idea'))
                ->groupBy('department_id', 'dept_name')
                ->get();
            // dd($deptideas);

        $contributors = DB::table('posts')
                // ->join('departments', 'posts.department_id', '=', 'departments.id')
                ->select('user_id')
                ->groupBy('user_id')
                ->get();
        
        $deptcontributors = DB::table('posts')
                ->join('departments', 'posts.department_id', '=', 'departments.id')
                ->select('department_id','dept_name', DB::raw('COUNT(DISTINCT user_id) as all_contributor'))
                ->distinct('user_id')
                ->groupBy('department_id', 'dept_name')
                ->get();

        $ideawithcomment = DB::table('posts')
                ->join('comments', 'posts.id', '=', 'comments.post_id')
                ->select('posts.id as postid')
                ->where('posts.id', '<>', 'comments.post_id')
                ->count();
        $ideawithoutcomment = $totalposts - $ideawithcomment;

        $ideaanonymous = DB::table('posts')
                ->select('posts.id')
                ->where('posts.anonymous', '=', '1')
                ->count();

        $commentanonymous = DB::table('comments')
                ->select('comments.id')
                ->where('comments.anonymous', '=', '1')
                ->count();
    
        // dd($ideawithoutcomment);
        
            return view('adminhome')->withDeptideas($deptideas)->withTotalposts($totalposts)->withDeptcontributors($deptcontributors)->withIdeawithoutcomment($ideawithoutcomment)->withIdeaanonymous($ideaanonymous)->withCommentanonymous($commentanonymous);
       
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
