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
            <a href="{{  route('user.dashboard')  }}" class="nav-link">
              <i class="link-icon" data-feather="home"></i>
              <span class="link-title">Home</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('user.flights.search') }}" class="nav-link">
              <i class="link-icon" data-feather="navigation"></i>
              <span class="link-title">Flights</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('user.view.car')  }}" class="nav-link">
              <i class="link-icon" data-feather="truck"></i>
              <span class="link-title">Cars</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('user.view.hotel')  }}" class="nav-link">
              <i class="link-icon" data-feather="map-pin"></i>
              <span class="link-title">Hotels</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('user.user_receipt')  }}" class="nav-link">
              <i class="link-icon" data-feather="shopping-cart"></i>
              <span class="link-title">Cart</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{  route('user.user_paid')  }}" class="nav-link">
              <i class="link-icon" data-feather="tag"></i>
              <span class="link-title">Paid</span>
            </a>
          </li>
          
          

          
          
          
          
          <li class="nav-item nav-category">Profile activity</li>
          <li class="nav-item">
            <a href="{{ route ('user.profile') }}" class="nav-link">
              <i class="link-icon" data-feather="user"></i>
              <span class="link-title">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route ('user.change.password') }}" class="nav-link">
              <i class="link-icon" data-feather="key"></i>
              <span class="link-title">Change Password</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route ('user.logout') }}" class="nav-link">
              <i class="link-icon" data-feather="log-out"></i>
              <span class="link-title">logout</span>
          </li>
        </ul>
      </div>
    </nav>
    