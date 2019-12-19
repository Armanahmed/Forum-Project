@extends('layouts.main')

@section('content')

<div class="container wrapper-container">
      <div class="row">
         <div class="col-md-12">
            <div class="wrapper-box" id="detail-idea-box">
               <h2 class="head-h2 text-center">Department {{strip_tags($post->dept_name)}}</h2>

               <div class="forum-idea-detail">
                  <!-- <a href="#" class="forum-idea-short"> -->
                  <div class="short-idea-user">
                     @if($post->anonymous == 0)                     
                     <p class="idea-user-name"><span>User:</span> {{strip_tags($post->name)}}</p>

                     <p class="short-idea-dept"><span>Session:</span> {{strip_tags($post->period_name)}}</p>
                     @else
                     <p class="idea-user-name"><span>User:</span> Anonymous</p>

                     <p class="short-idea-dept"><span>Session:</span> {{strip_tags($post->period_name)}}</p>
                     @endif
                  </div>

                  <div class="short-idea-details">
                     <p>{{$post->post_details}}</p>
                     @foreach($postfiles as $postfile)
                     <a href="/download/{{ $postfile->file_name }}" class="file_class" id="file_class"><i class="icon-download-alt"> </i> {{ $postfile->file_name }} </a>
                     @endforeach

                  </div>
                  <!-- </a> -->
                  <span class="content-divider"></span>

                  <div class="idea-info">
                     <div class="info-left">
                        <p><span>Posted by: </span><span>{{ date('M j, Y', strtotime($post->post_created)) }}</span></p>
                     </div>
                     <div class="info-right">
                        <div class="info-block">                           
                           @if(empty($likes))
                           <a class="dropdown-item" href="{{ route('postlike.store') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('postlike-form').submit();">
                              <i class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></i>
                           </a>
                           <span>{{$likecount}}</span>


                           <form id="postlike-form" action="{{ route('postlike.store') }}" method="POST" style="display: none;">
                               @csrf
                              <input type="hidden" id="post_like" name="post_like" value="1">
                              <input type="hidden" id="post_id" name="post_id" value="{{$post->post_id}}">
                              <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}">
                           </form>
                           @else 
                           <strong>Like: &nbsp;</strong>
                           <span>{{$likecount}}</span>
                           @endif


                        </div>
                        <div class="info-block">
                           

                           @if(empty($likes))
                           <a class="dropdown-item" href="{{ route('postdislike.store') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('postdislike-form').submit();">
                              <i class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></i>
                           </a>
                           <span>{{strip_tags($dislikecount)}}</span>

                           <form id="postdislike-form" action="{{ route('postdislike.store') }}" method="POST" style="display: none;">
                               @csrf
                              <input type="hidden" id="post_dislike" name="post_dislike" value="1">
                              <input type="hidden" id="post_id" name="post_id" value="{{$post->post_id}}">
                              <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}">
                           </form>
                           @else 
                           <strong>Dislike: &nbsp;</strong>
                           <span>{{strip_tags($dislikecount)}}</span>
                           @endif
                        </div>
                     </div>                           
                  </div>

               </div>

            </div>
         </div>
      </div>
   </div>

   <div class="container wrapper-container">
      <div class="row">
         <div class="col-md-12">
            <div class="wrapper-box wrapper-box-show" id="idea-comment-box">
               
               @if($definefinaldate > 0)
               <h4 class="text-center">Read Comments Only.</h4>
               
               @else 
               <h4 class="text-center">Read Comments or Reply Here.</h4>
               <div id="comment-idea">
                  <!-- <a href="#" class="forum-idea-short"> -->
                  <div class="comment-idea-user">
                     
                     <p class="idea-user-name"><span>User:</span> {{strip_tags($currentusename)}}</p>
                     @if($currentuserrole == 'student')
                     <p class="short-idea-dept">Student</p>
                     @else
                     <p class="short-idea-dept">Staff</p>
                     @endif
                  </div>

                  <div class="comment-idea-details">
                     <form class="comment-form" action="{{ route('comments.store', $post->post_id) }}" method="POST" data-parsley-validate>
                     {{ csrf_field() }}
                     <input type="hidden" id="post_id" name="post_id" value="{{$post->post_id}}">
                     <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}">
                        <div class="form-group">

                           <textarea class="form-control" id="idea_desc" name="idea_desc" rows="5" minlength="15" required></textarea>
                           
                        </div>

                        <div class="form-group">

                           <div class="checkbox">
                              <label>
                                 <input type="checkbox" id="anonymous" name="anonymous"> Post Anonymously
                              </label>
                           </div>

                        </div>
                        <div class="form-group">

                           <button type="submit" class="btn btn-default forum-button">Submit Comment</button>
                           
                        </div>
                     </form>
                  </div>

               </div>
               @endif

               
               @foreach($comments as $comment)
               <div id="comment-idea">
                  <!-- <a href="#" class="forum-idea-short"> -->
                  <div class="comment-idea-user">
                     @if($comment->anonymous == 0)                  
                     <p class="idea-user-name"><span>User:</span> {{$comment->name}}</p>
                     @else
                     <p class="idea-user-name"><span>User:</span> Anonymous</p>
                     @endif                    
                     @if($comment->role == 'student')
                        <p class="short-idea-dept">Student</p>
                     @else
                        <p class="short-idea-dept">Staff</p>
                     @endif
                  </div>

                  <div class="comment-idea-details">
                     <p>{{$comment->comment_details}}</p>
                  </div>

               </div>
               @endforeach

            </div>
         </div>
      </div>
   </div>

@endsection

