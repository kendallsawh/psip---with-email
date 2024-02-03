<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">Home</a></li>
        @auth
          @role('admin')
          <li><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">Users</a></li>
          <li><a href="{{ route('roles.index') }}" class="nav-link px-2 text-white">Roles</a></li>
          <li><a href="{{ route('permissions.index') }}" class="nav-link px-2 text-white">Permissions</a></li>
          @endrole
          
          <li><a href="{{ route('posts.index') }}" class="nav-link px-2 text-white">Discussion</a></li>
          @role('planning|admin')
          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              Agricultural Planning Options
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="{{ route('division.create') }}" target="_blank">Add a Division</a></li>
              <li><a class="dropdown-item" href="{{ route('psip.create') }}">Add a new PSIP/Vote to a Department/Division</a></li>              
              <li><a class="dropdown-item" href="{{ route('activities.create') }}">Add a new Project Activity to a PSIP/Vote</a></li>
              <li><a class="dropdown-item" href="{{ route('assign.create') }}">Assign/Request a document to be uploaded by a department</a></li>
              <li><a class="dropdown-item" href="{{ route('update.psip.financials') }}">Update PSIP to Current Financial Year</a></li>
              
            </ul>
          </div>
          @endrole
        @endauth
      </ul>

      <form id="searchform" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="post" action="{{ route('searchform') }}" enctype="multipart/form-data">
        <!-- CROSS Site Request Forgery Protection -->
                                    @csrf
        <input type="text" id="search" name="search" class="typeahead form-control form-control-dark" placeholder="Search..." aria-label="Search">
        <input type="submit" id="submitsearch" name="submitsearch" class="submit btn btn-outline-primary" hidden="hidden"/>

      </form>

      @auth
        {{auth()->user()->name}}&nbsp;
        <div class="text-end">
          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <!-- <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a> -->
        </div>
      @endguest
    </div>
  </div>
</header>