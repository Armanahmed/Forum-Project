@extends('layouts.main')

@section('content')


    <div class="container wrapper-container">
      <div class="row">
         <div class="col-md-12">

            @if(Session::has('danger'))
            <div class="alert alert-danger">                  
               <strong>Danger:</strong> {{ Session::get('danger') }}
            </div>
            @endif
           
            @if(count($posts) > 0 )
            <div class="wrapper-box" id="short-idea-box">
               <h2 class="head-h2 text-center">ALL IDEAS are HERE !</h2>
               <span class="section-title-border"></span>
               
               <nav aria-label="Page navigation" class="pagination-container">
                  {!! $posts->links() !!}
               </nav>
               @foreach($posts as $post)
               <div class="forum-idea-short">
                  <!-- <a href="#" class="forum-idea-short"> -->
                  <div class="short-idea-user">
                     @if($post->post_anonymous == 0)
                     <p class="idea-user-name"><span>User:</span> {{strip_tags($post->name)}} </p>
                     @else
                     <p class="idea-user-name"><span>User:</span> Anonymous </p>
                     @endif
                     <p class="short-idea-dept"><span>Dept:</span> {{strip_tags($post->dept_name)}}</p>
                  </div>

                  <div class="short-idea-details">
                     <p>{{ substr(strip_tags($post->post_details), 0, 150) }} {{ strlen(strip_tags($post->post_details)) > 150 ? "..." : "" }}</p>
                     <a href="{{ route('ideapanel.show', $post->post_id) }}">Read More</a>
                     <span class="content-divider"></span>

                     <div class="idea-info">
                        <div class="info-left">
                           <p><span>Posted by: </span><span>{{ date('M j, Y', strtotime($post->post_created)) }}</span></p>
                        </div>
                        <div class="info-right">
                           <div class="info-block">
                              <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>
                              <span>{{ strip_tags($post->views) }}</span>
                           </div>
                           <div class="info-block">
                              <i class="glyphicon glyphicon-comment" aria-hidden="true"></i>
                              <span>
                              
                                 <?php $find = 0; ?>
                                  @foreach($commentcounts as $commentcount)
                                     @if( $commentcount->comment_post_id == $post->post_id )
                                        <?php $find = $commentcount->post_comment; ?>
                                        @break
                                     
                                     @endif
                                  @endforeach
                                  
                                  <?php echo $find; ?>
                              </span>
                           </div>
                        </div>                           
                     </div>


                  </div>
                  <!-- </a> -->

               </div>
               @endforeach
               

               <nav aria-label="Page navigation" class="pagination-container">
                  {!! $posts->links() !!}
               </nav>

            </div>
            
            @else
            <div class="wrapper-box" id="short-idea-box">
               <h2 class="head-h2 text-center">No IDEAS HERE !</h2>
               <span class="section-title-border"></span>
               @if(Auth::user()->role == 'student')
                  <a class="text-center" style="display: block; font-size: 30px; text-decoration: underline;" href="{{ route('ideapanel.create') }}"><strong>Create a Idea</strong></a>
               @endif

            </div>
            @endif


         </div>
      </div>
   </div>

@endsection

@section('custom_scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
<script type="text/javascript">
// Vue.component('example-component', require('./../../assets/js/components/ExampleComponent.vue'));

var app = new Vue({
  el: '#app',
  data: {
    idea_submit: false
  }
});
</script>

@endsection