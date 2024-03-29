<nav class="navbar navbar-default navbar-static-top">
   <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="{{ url('/') }}">Ideam Forum</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
               <li class="active"><a href="{{ route('ideapanel.create')}}">Idea Create</a></li>
            </ul>
         <ul class="nav navbar-nav navbar-right">
            @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            @else
            <li class="dropdown">

               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
               <ul class="dropdown-menu">
                  <!-- <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li> -->
                   @if(Auth::user()->role == 'student')
                   
                  <li><a href="{{ route('ideapanel.create') }}"><strong>Idea Create</strong></a>
                  
                  @endif
                  @if(! (Auth::user()->role == 'student') )
                  <li><a href="{{ route('adminhome') }}"><strong>Dashboard</strong></a>
                  @endif
                  @if(! (Auth::user()->role == 'student') )
                  <li><a href="{{ route('ideaadmin.index') }}"><strong>Post List</strong></a>
                  @endif
                  @if(! (Auth::user()->role == 'student') )
                  <li><a href="{{ route('ideaadmin.comment') }}"><strong>Comment List</strong></a>
                  @endif
                  @if(Auth::user()->role == 'student')
                  <li><a href="{{ route('ideapanel.index') }}"><strong>Idea List</strong></a>
                  @endif
                  <li><a href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><strong>Logout</strong></a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
                  </li>
                  
                  
                     
                  </li>
               </ul>
            </li>
            @endguest
         </ul>
      </div><!--/.nav-collapse -->
   </div>
</nav>