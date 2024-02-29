<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{route('dashboard')}}">
        {{-- <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo"> --}}
        <h5 class="ms-1 font-weight-bold text-white text-center">
         Hello Admin: <br>
         <span>{{auth()->user()->name}}</span>
        </h5>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
            {{-- nếu request chỉ vào nào row có dashboard thì sẽ in ra class đầu tiên là bg và active nếu không thì không in gì cả --}}
          <a class="nav-link text-white {{request()->routeIs('dashboard') ?' bg-gradient-primary active':''}}" href="{{route('dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @hasrole('super-admin|admin')
        <li class="nav-item">
            {{-- nếu request chỉ vào nào row có Role thì sẽ in ra class đầu tiên là bg và active nếu không thì không in gì cả --}}

          <a class="nav-link text-white  {{request()->routeIs('roles.*') ?' bg-gradient-primary active':''}}" href="{{route('roles.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Role</span>
          </a>
        </li>
        @endhasrole
        
        <li class="nav-item">
          <a class="nav-link text-white  {{request()->routeIs('users.*') ?' bg-gradient-primary active':''}}" href="{{route('users.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Người Dùng</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{request()->routeIs('products.*') ?' bg-gradient-primary active':''}} " href="{{route('products.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">view_in_ar</i>
            </div>
            <span class="nav-link-text ms-1">Sản Phẩm</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{request()->routeIs('categories.*') ?' bg-gradient-primary active':''}}" href="{{route('categories.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
            </div>
            <span class="nav-link-text ms-1">Danh Mục</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{request()->routeIs('admin.orders.*') ?' bg-gradient-primary active':''}}" href="{{route('admin.orders.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
            </div>
            <span class="nav-link-text ms-1">Orders</span>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link text-white {{request()->routeIs('thongke.*') ?' bg-gradient-primary active':''}}" href="{{route('thongke')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
            </div>
            <span class="nav-link-text ms-1">Thống Kê</span>
          </a>
        </li> --}}
       
        {{-- <li class="nav-item">
          <a class="nav-link text-white {{request()->routeIs('coupons.*') ?' bg-gradient-primary active':''}}" href="{{route('coupons.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
            </div>
            <span class="nav-link-text ms-1">Coupons</span>
          </a>
        </li> --}}
        
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        {{-- <a class="btn btn-outline-primary mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a> --}}
        {{-- <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a> --}}
        <a class="btn bg-gradient-primary w-100" href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
{{ __('Logout') }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
      </div>
    </div>
  </aside>