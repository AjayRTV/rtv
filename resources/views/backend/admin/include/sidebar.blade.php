<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- Sidebar Menu -->
    <?php  $user = Auth::user(); if($user != ""){ ?>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin/img/'.Auth::user()->image)}}" class="img-circle elevation-2" width="50px" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
    </div>
    <?php } ?>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Analytics
            </p>
          </a>
        </li>
        <!-- =---------------------------- [ For Org ] ------------------------------= -->
        <li class="nav-item {{ (request()->is('org*')) ||  (request()->is('org*')) ||   (request()->is('addRole*')) || (request()->is('permision*'))  ? 'active menu-open' : '' }} " >          
          <a href="" class="nav-link {{ (request()->is('org*')) ||  (request()->is('org*')) ||  (request()->is('addRole*'))  ||  (request()->is('permision*')) ? 'active' : '' }}">
              <i class="fa fa-globe"></i>
              <p> Org  <i class="right fas fa-angle-left"></i> </p>
          </a>
          <ul class="nav nav-treeview">
              @can('org')
              <li class="nav-item">
                <a href="{{route('org')}}" class="nav-link {{ (request()->is('org*')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>org</p>
                </a>
              </li>
              @endcan
               @can('addRole')
              <li class="nav-item">
                <a href="{{ route('addRole')}}" class="nav-link {{ (request()->is('addRole*')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Role List</p>
                </a>
              </li> 
              @endcan
              @can('permision')
              <li class="nav-item">
                <a href="{{ route('permision')}}" class="nav-link {{ (request()->is('permision*')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Permision</p>
                </a>
              </li>  
              @endcan
          </ul>
        </li> 
        <!-- For Demo -->
        @can('demo')
          <li class="nav-item {{ (request()->is('demo*')) ? 'active menu-open' : '' }} " >          
           <a href="{{route('demo')}}" class="nav-link {{ (request()->is('demo*')) ||  (request()->is( 'demo*')) ? 'active' : '' }}">
                <i class="fa fa-globe"></i>
                <p> Demo </p>
            </a>
          </li>  
        @endcan
        @can('test')
          <li class="nav-item {{ (request()->is('test*')) ? 'active menu-open' : '' }} " >          
           <a href="{{route('test')}}" class="nav-link {{ (request()->is('test*')) ||  (request()->is('test*')) ? 'active' : '' }}">
                <i class="fa fa-globe"></i>
                <p> Test </p>
            </a>
          </li>  
        @endcan
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
@yield('sidebar')