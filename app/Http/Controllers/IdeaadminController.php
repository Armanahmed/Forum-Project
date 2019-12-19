<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Category;
use App\User;
use App\Post;
use App\File;
use App\Department;
use App\Comment;
use App\Like;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use ZipArchive;


use Session;
use DB;
use Input;
use Auth;

class IdeaadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentuserrole = Auth::user()->role;
        $currentuserid = Auth::user()->id;
        $userdept = DB::table('departments_users')
            ->join('users', 'departments_users.user_id', '=', 'users.id')
            ->select('departments_users.department_id')
            ->where('users.id', '=', $currentuserid)
            ->first();
         $posthasfiles = DB::table('files')
            ->select('files.post_id')
            ->groupBy('files.post_id')
            ->get();
        // dd($userdept);

        if( $currentuserrole == 'staff'){
            $post_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->select('departments.dept_name', 'departments.id as d_id', 'periods.period_name', 'posts.id as post_id', 'posts.anonymous as anonymous_post', 'posts.post_details', 'posts.created_at as post_created')
            ->where('departments.id', '=', $userdept->department_id)
            ->get();
        } else {
            $post_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->leftJoin('files', 'posts.id', '=', 'files.post_id')
            ->select('departments.dept_name', 'periods.period_name', 'posts.id as post_id', 'posts.anonymous as anonymous_post', 'posts.post_details', 'posts.created_at as post_created')
            ->distinct()
            // ->where([ ['departments.id', '=', $department_id->department_id], ['periods.id', '=', $period_id->period_id] ])
            ->get();
        }
        

      // $currentPage = LengthAwarePaginator::resolveCurrentPage();
      // $col = new Collection($post_list);
      // $perPage = 5;
      // $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      //   // $departments = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      // $posts = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => url('ideapanel/')] );
      // dd($post_list);
        return view('adminidea.index')->withPosts($post_list)->withPosthasfiles($posthasfiles);
    }



    public function zipdownload($post_id) {

        $files = DB::table('files')
           ->join('posts', 'files.post_id', '=', 'posts.id')
           ->select('files.id as file_id', 'files.file_name')
           ->where( 'files.post_id', '=', $post_id )
           ->get();
         // dd($files);

        // $files=Document::select('doc')->where('session_id',$request->session_id)->get();

        $file_dir = public_path().'/files';
        // $file_path = public_path('files/'.$file_name);
        $public_dir = public_path().'/zipfileloads';
        $zipFileName = time().'.zip';

        $zip = new ZipArchive;

        for( $i=0; $i<sizeof($files); $i++ )
        {

            if($files[$i]->file_name!=null) {

               if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {

                  $ext = pathinfo($files[$i]->file_name, PATHINFO_EXTENSION);

                  $zip->addFile($file_dir . '/' . $files[$i]->file_name, time(). '.' . $ext);
                  $zip->close();

               }
            }

         }

        if (file_exists($public_dir . '/' . $zipFileName)) {
            return response()->download($public_dir . '/' . $zipFileName);
        } else {
            return redirect('ideaadmin');
        }

    }

    public function ideapopular()
    {
        $currentuserrole = Auth::user()->role;
        $currentuserid = Auth::user()->id;
        $userdept = DB::table('departments_users')
            ->join('users', 'departments_users.user_id', '=', 'users.id')
            ->select('departments_users.department_id')
            ->where('users.id', '=', $currentuserid)
            ->first();
        // dd($userdept);

        
            $post_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->select('posts.department_id', 'departments.dept_name', 'periods.period_name', 'posts.id as post_id', 'posts.total_like', 'posts.anonymous as anonymous_post', 'posts.post_details', 'posts.created_at as post_created')
            // ->where([ ['departments.id', '=', $department_id->department_id], ['periods.id', '=', $period_id->period_id] ])
            ->get();
        

      
            $department_name = DB::table('departments_users')
                ->join('departments', 'departments_users.department_id', '=', 'departments.id')
                ->select('departments.dept_name')
                ->where('departments_users.user_id', '=', $currentuserid)
                ->first();
            // $department_id = DB::table('departments_users')
            //     ->join('posts', 'departments_users.department_id', '=', 'posts.department_id')
            //     ->select('posts.department_id')
            //     ->where('departments_users.user_id', '=', $currentuserid)
            //     ->first();

            $populars = DB::table('posts')
                ->select('department_id', DB::raw('MAX(total_like) as all_like'))
                ->groupBy('department_id')
                ->get();
            // dd($populars);

        

        return view('adminidea.popular')->withPosts($post_list)->withPopulars($populars);
    }

    public function ideaviewed()
    {
        $currentuserrole = Auth::user()->role;
        $currentuserid = Auth::user()->id;
        $userdept = DB::table('departments_users')
            ->join('users', 'departments_users.user_id', '=', 'users.id')
            ->select('departments_users.department_id')
            ->where('users.id', '=', $currentuserid)
            ->first();
        // dd($userdept);

        
            $post_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->select('posts.department_id', 'departments.dept_name', 'periods.period_name', 'posts.id as post_id', 'posts.views', 'posts.anonymous as anonymous_post', 'posts.post_details', 'posts.created_at as post_created')
            // ->where([ ['departments.id', '=', $department_id->department_id], ['periods.id', '=', $period_id->period_id] ])
            ->get();
        

      
            $department_name = DB::table('departments_users')
                ->join('departments', 'departments_users.department_id', '=', 'departments.id')
                ->select('departments.dept_name')
                ->where('departments_users.user_id', '=', $currentuserid)
                ->first();
            // $department_id = DB::table('departments_users')
            //     ->join('posts', 'departments_users.department_id', '=', 'posts.department_id')
            //     ->select('posts.department_id')
            //     ->where('departments_users.user_id', '=', $currentuserid)
            //     ->first();

            $populars = DB::table('posts')
                ->select('department_id', DB::raw('MAX(views) as max_views'))
                ->groupBy('department_id')
                ->get();
            // dd($populars);

        

        return view('adminidea.viewed')->withPosts($post_list)->withPopulars($populars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ideacomment() {

        $currentuserrole = Auth::user()->role;
        $currentuserid = Auth::user()->id;
        $userdept = DB::table('departments_users')
            ->join('users', 'departments_users.user_id', '=', 'users.id')
            ->select('departments_users.department_id')
            ->where('users.id', '=', $currentuserid)
            ->first();
        // dd($userdept);

        if( $currentuserrole == 'staff'){
            $comment_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->join('comments', 'posts.id', '=', 'comments.post_id')
            ->select('departments.dept_name', 'departments.id as d_id', 'periods.period_name', 'posts.id as post_id', 'comments.comment_details', 'comments.created_at as comment_create')
            ->where('departments.id', '=', $userdept->department_id)
            ->get();
        } else {
            $comment_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->join('comments', 'posts.id', '=', 'comments.post_id')
            ->select('departments.dept_name', 'periods.period_name', 'posts.id as post_id', 'comments.comment_details', 'comments.created_at as comment_create')
            // ->where([ ['departments.id', '=', $department_id->department_id], ['periods.id', '=', $period_id->period_id] ])
            ->get();
        }

      // $currentPage = LengthAwarePaginator::resolveCurrentPage();
      // $col = new Collection($comment_list);
      // $perPage = 3;
      // $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      //   // $departments = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      // $comments = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => url('ideacomment/')] );

        return view('adminidea.comment')->withComments($comment_list);
    }

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
