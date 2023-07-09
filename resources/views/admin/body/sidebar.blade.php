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
          <li class="nav-item nav-category">Tracking Action</li>
          <li class="nav-item">
            <a href="{{  route('admin.view.user')  }}" class="nav-link">
              <i class="link-icon" data-feather="list"></i>
              <span class="link-title">View Users</span>
            </a>
          </li>
          <li class="nav-item nav-category">web apps</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="mail"></i>
              <span class="link-title">Email</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="emails">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  
                  <a href="https://mailtrap.io/inboxes" class="nav-link" target="_blank">Inbox</a>

                </li>
              </ul>
            </div>
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
              <i class="link-icon" data-feather="edit"></i>
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
    