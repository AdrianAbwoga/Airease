<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          Air<span>Ease</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a href="{{  route('admin.dashboard')  }}" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="http://localhost/phpmyadmin/index.php?route=/database/structure&db=airease" class="nav-link">
              <i class="link-icon" data-feather="database"></i>
              <span class="link-title">Database</span>
            </a>
          </li>
          <li class="nav-item nav-category">Tracking Action</li>
          <li class="nav-item">
            <a href="{{  route('admin.view.user')  }}" class="nav-link">
              <i class="link-icon" data-feather="user-plus"></i>
              <span class="link-title">View Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('admin.view.flight')  }}" class="nav-link">
              <i class="link-icon" data-feather="navigation"></i>
              <span class="link-title">View Flights</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('admin.view.car')  }}" class="nav-link">
              <i class="link-icon" data-feather="truck"></i>
              <span class="link-title">View Cars</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('admin.view.order')  }}" class="nav-link">
              <i class="link-icon" data-feather="tag"></i>
              <span class="link-title">View orders</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('admin.view.hotel')  }}" class="nav-link">
              <i class="link-icon" data-feather="map-pin"></i>
              <span class="link-title">View hotels</span>
            </a>
          </li>
          
          <li class="nav-item nav-category">Profile activity</li>
          <li class="nav-item">
            <a href="{{ route ('admin.profile') }}" class="nav-link">
              <i class="link-icon" data-feather="user"></i>
              <span class="link-title">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route ('admin.change.password') }}" class="nav-link">
              <i class="link-icon" data-feather="key"></i>
              <span class="link-title">Change Password</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route ('admin.logout') }}" class="nav-link">
              <i class="link-icon" data-feather="log-out"></i>
              <span class="link-title">logout</span>
          </li>
        </ul>
      </div>
    </nav>
    