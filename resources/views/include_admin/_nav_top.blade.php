

<nav class="navbar navbar-default top-navbar" role="navigation">

   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><strong><i class="icon fa fa-lightbulb-o"></i> Idea Forum</strong></a>

      <div id="sideNav" href="">
         <i class="fa fa-bars icon"></i> 
      </div>
   </div>

   <ul class="nav navbar-top-links navbar-right">
      <li class="dropdown">
         
      </li>
      <!-- /.dropdown -->
      
      <!-- /.dropdown -->
      
      <!-- /.dropdown -->
      <li class="dropdown">
         <a class="dropdown-toggle user-name" id="user-name" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
         </a>
         <ul class="dropdown-menu dropdown-user">
            <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
            </li>
            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
            </li>
            <li class="divider"></li> -->
            <li>
            <a href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
            </li>
         </ul>
         <!-- /.dropdown-user -->
      </li>
      <!-- /.dropdown -->
   </ul>
</nav>
<!--/. NAV TOP  -->