  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="#" class="nav-link">Contact</a>
          </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">


          <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  {{ Auth::check() ? Auth::user()->name : '' }}
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a href="{{ route('profile.edit') }}">
                          Profile
                      </a></li>
                  <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf

                          <a href="route('logout')"
                              onclick="event.preventDefault();
                                       this.closest('form').submit();">
                              {{ __('Log Out') }}
                          </a>
                      </form>
                  </li>
              </ul>
          </div>
          <!-- Responsive Settings Options -->

          <!-- Navbar Search -->
          <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="fas fa-search"></i>
              </a>
              <div class="navbar-search-block">
                  <form class="form-inline">
                      <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search"
                              aria-label="Search">
                          <div class="input-group-append">
                              <button class="btn btn-navbar" type="submit">
                                  <i class="fas fa-search"></i>
                              </button>
                              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                  <i class="fas fa-times"></i>
                              </button>
                          </div>
                      </div>
                  </form>


              </div>
          </li>


  </nav>
  <!-- /.navbar -->
