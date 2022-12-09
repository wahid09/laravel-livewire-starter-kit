<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="{{ route('app.dashboard') }}" class="nav-link {{ request()->is('app/dashboard') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

              <li class="nav-item has-treeview customLiClass">
                <a href="#" class="nav-link">
                  <i class="nav-icon far fa-envelope"></i>
                  <p>
                    Access Control
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('app.users') }}" class="nav-link">
                      <i class="fas fa-users nav-icon"></i>
                      <p>Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/mailbox/compose.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Compose</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/mailbox/read-mail.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Read</p>
                    </a>
                  </li>
                </ul>
              </li>
            
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>