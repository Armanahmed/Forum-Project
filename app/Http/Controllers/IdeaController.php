<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\IdeaEmail;
use App\Mail\CommentEmail;
use Illuminate\Database\Eloquent\Collection;
use App\Category;
use App\User;
use App\Post;
use App\File;
use App\Department;
use App\Comment;
use App\Like;
use DateTime;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;


use Session;
use DB;
use Input;
use Auth;


class IdeaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$categories = Category::all();

		$currentuserid = Auth::user()->id;
		// dd($currentuserid = Auth::user()->id);
		$period_id = DB::table('users')
			->join('periods', 'users.period_id', '=', 'periods.id')
			->select('users.period_id')
			->where('users.id', '=', $currentuserid)
			->first();
		// dd($period_id);

		$department_id = DB::table('users')
			->join('periods', 'users.period_id', '=', 'periods.id')
			->select('periods.department_id')
			->where('users.id', '=', $currentuserid)
			->first();

		
		$commentcounts = DB::table('comments')
                     ->select(DB::raw('count(*) as post_comment, post_id as comment_post_id'))
                     ->groupBy('comments.post_id')
                     ->get();
        // dd($commentcounts);

		// dd($department_id);

		$post_list = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->join('posts', 'periods.id', '=', 'posts.period_id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('departments.id', 'periods.id', 'departments.dept_name', 'periods.period_name', 'users.name', 'posts.id as post_id', 'posts.post_details', 'posts.anonymous as post_anonymous', 'posts.views', 'posts.created_at as post_created')
            ->where([ ['departments.id', '=', $department_id->department_id], ['periods.id', '=', $period_id->period_id] ])
            ->orderBy('posts.created_at', 'desc')
            ->get();
        // dd($post_list);

      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection($post_list);
      $perPage = 5;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        // $departments = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      $posts = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => url('ideapanel/')] );
      // dd($posts);
		// return view('ideapanel.index')->withCategories($categories)->withPosts($posts);
		return view('ideapanel.index')->withPosts($posts)->withCommentcounts($commentcounts);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$currentuserid = Auth::user()->id;
		// dd($currentuserid = Auth::user()->id);
		$userperiod = DB::table('users')
			->join('periods', 'users.period_id', '=', 'periods.id')
			->select('users.period_id', 'periods.closure_date', 'periods.final_date' )
			->where('users.id', '=', $currentuserid)
			->first();
		// dd($userperiod);

		$date1=date_create($userperiod->closure_date);
        $today = date_create(date("Y-m-d"));
        $diff = date_diff($today, $date1);
        // dd($diff->format('%R%a'));

        // dd($diff->format('%R%a'));
        
        if( $diff->format('%R%a') < 0) {
            Session::flash('danger', 'Idea submission is over for this Session!');

            return redirect()->route('ideapanel.index');
        }


		$categories = Category::all();
		return view('ideapanel.create')->withCategories($categories);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		
		$this->validate($request, [
				'category_id' => 'bail|required|numeric',
				'post_details' => 'required',
				'terms' => 'required',
				'user_id' => 'bail|required|numeric'
		]);

		$post = new Post();
      $post->post_details = $request->post_details;
      $post->user_id = $request->user_id;
      $post->period_id = $request->period_id;
      $post->category_id = $request->category_id;

      $depts = DB::table('users')
            ->join('periods', 'users.period_id', '=', 'periods.id')
            ->select('periods.department_id')
            ->where('users.id', '=', $post->user_id)
            ->first();

      $post->department_id = $depts->department_id;

      if(!empty($request->anonymous)) {
      	$post->anonymous = 1;
      	$post->save();
      } else {
      	$post->save();
      }

      $coordinatormail = DB::table('posts')
			->join('departments_users', 'posts.department_id', '=', 'departments_users.department_id')
			->join('users', 'departments_users.user_id', '=', 'users.id')
			->select('users.email')
			->where('posts.id', '=', $post->id)
			->first();

		if(!empty($request->file('idea_file'))) {

			$files = count($request->file('idea_file'));
        	foreach(range(0, $files) as $file) {
        		$this->validate($request, ['idea_file' => 'bail|filled|max:199000']);
	      }

	      

         for($i = 0;$i < count($request->file('idea_file'));$i++) {

	         	$file = $request->file('idea_file')[$i];
		         $destination_path = public_path().'/files';
		         $extension = $file->getClientOriginalExtension();
		         $files = $file->getClientOriginalName();
		         $fileName = $files.'_'.time().'.'.$extension;
		         $file->move($destination_path,$fileName);

		         $file_table = new File();
		         $file_table->file_name = $fileName;
		         $file_table->post_id = $post->id;
		         $file_table->user_id = $request->user_id;

		         $file_table->save();
	       }

	       

	       $data = array(
            'email' => $coordinatormail->email,
            'subject' => "Idea Forum New Post",
            'bodyMessage' => "There is a new Post on Idea Forum",
            'url' => "http://127.0.0.1:8000/ideapanel/$post->id"
            );
            Mail::to($data['email'])->send(new IdeaEmail($data));

	       Session::flash('success', 'Idea is submitted Successfully.');
	       return redirect()->route('ideapanel.index');

		} else {
			$data = array(
            'email' => $coordinatormail->email,
            'subject' => "Idea Forum New Post",
            'bodyMessage' => "There is a new Post on Idea Forum",
            'url' => "http://127.0.0.1:8000/ideapanel/$post->id"
            );
            Mail::to($data['email'])->send(new IdeaEmail($data));
			Session::flash('success', 'Idea is submitted Successfully.');
         return redirect()->route('ideapanel.show', $post->id);
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$currentuserid = Auth::user()->id;
		// dd($currentuserid);
		$currentuserrole = Auth::user()->role;
		$currentusename = Auth::user()->name;
		// dd($department_id);
		$post = DB::table('posts')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('periods', 'users.period_id', '=', 'periods.id')
			->join('departments', 'periods.department_id', '=', 'departments.id')
			->select('departments.dept_name', 'periods.period_name', 'users.name', 'users.id as user_id', 'posts.id as post_id', 'posts.anonymous', 'posts.post_details', 'posts.created_at as post_created')
			->where('posts.id', '=', $id)
			->first();
		if($currentuserrole == 'student') {
			$comments = DB::table('comments')
			->join('users', 'comments.user_id', '=', 'users.id')
			->select('comments.comment_details', 'users.name', 'users.role', 'users.id as users_id', 'comments.anonymous', 'comments.created_at')
			->where([ ['comments.post_id', '=', $id], ['users.role', '=', 'student'] ])
			->orderBy('comments.created_at', 'desc')
			->get();
		} else {
			$comments = DB::table('comments')
			->join('users', 'comments.user_id', '=', 'users.id')
			->select('comments.comment_details', 'users.name', 'users.role', 'users.id as users_id', 'comments.anonymous')
			->where('comments.post_id', '=', $id)
			->orderBy('comments.created_at', 'desc')
			->get();
		}
		
		// dd($comments);

		
		$likes = DB::table('likes')
			->select('likes.*')
			->where([ ['likes.post_id', '=', $id], ['likes.user_id', '=', $currentuserid] ])
			->first();

		$likecount = DB::table('likes')
			->select('likes.*')
			->where([ ['likes.post_id', '=', $id], ['likes.post_like', '=', '1'] ])
			->count();

		$dislikecount = DB::table('likes')
			->select('likes.*')
			->where([ ['likes.post_id', '=', $id], ['likes.post_dislike', '=', '1'] ])
			->count();
		// dd($likes);

		$postfiles = DB::table('files')
			->select('files.*')
			->where('post_id', '=', $id)
			->get();
		// dd($postfiles);


		// Determining whether comment can be done or not
		
		// dd($currentuserid = Auth::user()->id);
		$userperiod = DB::table('posts')
			->join('users', 'users.id', '=', 'posts.user_id')
			->join('periods', 'users.period_id', '=', 'periods.id')
			->select('users.period_id', 'periods.closure_date', 'periods.final_date' )
			->where('posts.id', '=', $id)
			->first();
		// dd($userperiod);

		$date1=date_create($userperiod->final_date);
        $today = date_create(date("Y-m-d"));
        $diff = date_diff($today, $date1);

        // dd($diff->format('%a'));
        $definefinaldate = 0;
        if( $diff->format('%R%a') < 0) {
            $definefinaldate = 1;
        }

        $currentpostviews = DB::table('posts')
			->select( 'posts.views' )
			->where('posts.id', '=', $id)
			->first();
		$newpostviews = $currentpostviews->views + 1;

        DB::table('posts')
                ->where('id', $id)
                ->update(['views' => $newpostviews ]);

       	// End of Determining whether comment can be done or not

		return view('ideapanel.show')->withPost($post)->withComments($comments)->withLikes($likes)->withLikecount($likecount)->withDislikecount($dislikecount)->withCurrentusename($currentusename)->withCurrentuserrole($currentuserrole)->withPostfiles($postfiles)->withDefinefinaldate($definefinaldate);
	}

	public function getDownload($file_name) {
		// $postfiles = DB::table('files')
		// 	->select('files.*')
		// 	->where('post_id', '=', $id)
		// 	->get();
		// for($i = 0;$i < count($postfiles); $i++) {

		// }
			//PDF file is stored under project/public/download/info.pdf
    	// $file= public_path(). "/files/info.pdf";


   		// return response()->download(public_path('file_path/from_public_dir.pdf'));

   		$file_path = public_path('files/'.$file_name);
    	return response()->download($file_path);

	}

	public function commentcreate(Request $request, $id) {
		// dd($request);
		$this->validate($request, [
			'post_id' => 'bail|required|numeric',
			'user_id' => 'bail|required|numeric',
			'idea_desc' => 'bail|required',
			]);

		$comment = new Comment();
		$comment->post_id = $request->post_id;
		$comment->user_id = $request->user_id;
		$comment->comment_details = $request->idea_desc;

		$postusermail = DB::table('posts')
			->join('users', 'posts.user_id', '=', 'users.id')
			->select('users.email')
			->where('posts.id', '=', $request->post_id)
			->first();

		$currentuserrole = Auth::user()->role;

		if(!empty($request->anonymous)) {
			$comment->anonymous = 1;
			$comment->save();

			if( $currentuserrole == 'student' ) {
				$data = array(
	            'email' => $postusermail->email,
	            'subject' => "Idea Forum New Comment",
	            'bodyMessage' => "There is a new Comment on Idea Forum Post",
	            'url' => "http://127.0.0.1:8000/ideapanel/$request->post_id"
	            );
	            Mail::to($data['email'])->send(new CommentEmail($data));
			}
			

		} else {
			$comment->save();

			if( $currentuserrole == 'student' ) {
				$data = array(
	            'email' => $postusermail->email,
	            'subject' => "Idea Forum New Comment",
	            'bodyMessage' => "There is a new Comment on Idea Forum Post",
	            'url' => "http://127.0.0.1:8000/ideapanel/$request->post_id"
	            );
	            Mail::to($data['email'])->send(new CommentEmail($data));
			}
		}
		return redirect()->route('ideapanel.show', $request->post_id);
	}

	public function likestore(Request $request) {
		// dd($request);
		$this->validate($request, [
				'post_id' => 'bail|required|numeric',
				'user_id' => 'bail|required|numeric',
				'post_like' => 'bail|required|numeric',
		]);

		$like = new Like();
      $like->post_id = $request->post_id;
      $like->user_id = $request->user_id;
      $like->post_like = $request->post_like;

		$like->save();

		DB::table('posts')
            ->where('id', '=', $request->post_id)
            ->increment('total_like', 1);
            // ->update(['total_like' => ]);

		// DB::table('posts')->increment('total_like', 1, ['id' => $request->post_id]);

      return redirect()->route('ideapanel.show', $request->post_id);
	}

	public function dislikestore(Request $request) {
		// dd($request);
		$this->validate($request, [
				'post_id' => 'bail|required|numeric',
				'user_id' => 'bail|required|numeric',
				'post_dislike' => 'bail|required|numeric',
		]);

		$like = new Like();
      $like->post_id = $request->post_id;
      $like->user_id = $request->user_id;
      $like->post_dislike = $request->post_dislike;

		$like->save();

		DB::table('posts')
            ->where('id', '=', $request->post_id)
            ->decrement('total_like', 1);
     
      return redirect()->route('ideapanel.show', $request->post_id);
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
