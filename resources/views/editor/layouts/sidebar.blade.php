<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img
        src="{{ asset('admin-assets/img/asset 0.jpeg') }}"
        alt="AdminLTE Logo"
        class="brand-image"
        style="opacity: 1"
      />
      <!-- <span class="brand-text font-weight-light">Blog</span> -->
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('editor.dashboard') }}" class="nav-link">
              <i class="fa-solid fa-globe"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('ed-categories.create') }}" class="nav-link">
              <i class="fa-solid fa-cube"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('comment.index') }}" class="nav-link">
              <i class="fa-solid fa-comments"></i>
              <p>Comments</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('editor-posts.index') }}" class="nav-link">
              <i class="nav-icon fas fa-pencil-alt"></i>
              <p>Post</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('editor-sub-categories.create') }}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Sub Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('editor-tags.create') }}" class="nav-link">
              <i class="fa-solid fa-tags"></i>
              <p>Tags</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>