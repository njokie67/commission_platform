@include('layouts.header')
@php
    use App\Models\Organization;
@endphp
<body>
  
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="/dashboard">
          <img src="https://www.closing.solutions/hosted/images/df/db9359396644a8ba75f16c37a2ae26/NEW-stratton-logo-fixed-.png" class="navbar-brand-img" alt="Logo">
        </a>
      </div>
      <div class="navbar-inner">
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-sitemap text-primary" aria-hidden="true"></i> Organizations
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach (Organization::all() as $organisation)
                  <a class="dropdown-item" href="/organization/{{$organisation->system_id}}/dashboard">{{$organisation->name}}</a>
                @endforeach
                <a class="dropdown-item" data-toggle="modal" data-target="#addOrganization"><i class="fa fa-plus text-success" aria-hidden="true"></i> add organization</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/organization/{{$organization->system_id}}/opportunities">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Opportunities</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#setCommission">
                <i class="ni ni-key-25 text-info"></i>
                <span class="nav-link-text">Commission</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/organization/{{$organization->system_id}}/management">
                <i class="ni ni-circle-08 text-pink"></i>
                <span class="nav-link-text">Management</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="/documentation" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Documentation</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="/assets/img/theme/team-4.jpg">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="/admin/settings" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="modal fade" id="setCommission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Set Commission</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="modal-body form-group" action="/organization/{{$organization->system_id}}/commission" method="POST">
              <input type="number" min="0" required name="commission" class="form-control" value="{{$organization->commission}}">
              @csrf
              <div class="mt-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
          </form>
        </div>
      </div>
    </div>



    <div class="modal fade" id="addOrganization" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Organization <i class="fa fa-plus-circle" aria-hidden="true"></i></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="modal-body form-group" id='organizationapiadd'>
              <div class="row">
                <div class="col-lg-12">
                  <label>Organization Name</label>
                  <input type="text" class="form-control" required name="organization_name" placeholder="Organization Name">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12 mt-3">
                  <label>API Key</label>
                  <input type="text" name="organization_apikey" class="form-control" required placeholder="Organization API key">
                </div>
              </div>
              <div class="mt-4">
                @csrf
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary organizationapiadd">Add</button>
              </div>
          </form>
        </div>
      </div>
    </div>



    <div class="modal fade" id="searchFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Filter <i class="fa fa-filter" aria-hidden="true"></i></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="modal-body form-group" action="#">
              <div class="row">
                <div class="col-md-6 mt-3">
                  <label>From</label>
                  <input type="date" id='dateselect' name="from" class="form-control" required>
                </div>
                <div class="col-md-6 mt-3">
                  <label>To</label>
                  <input type="date" name="to" id='dateselect' class="form-control" required>
                </div>
              </div>
              <div class="mt-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Filter</button>
              </div>
          </form>
        </div>
      </div>
    </div>


    <div class="modal fade" id="refreshData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body form-group" action="#">
              <div class="row">
                <div class="col-md-12 text-center text-danger">
                  <p><i class="fa fa-lightbulb fa-4x" aria-hidden="true"></i><br> It will take awhile to refresh data for this organization. Please confirm you wish to continue or cancel</p>
                </div>
              </div>
              <form>
              <div class="mt-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success refreshDataBtn">Proceed</button>
              </div>
            </form>
            </div>
        </div>
      </div>
    </div>

    @yield('content')


    <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; <script>document.write(new Date().getFullYear()); </script> All rights reserved. 
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  @include('layouts.footer')