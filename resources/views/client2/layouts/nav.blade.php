<header id="header" class="site-header header-scrolled position-fixed text-black bg-light">
    <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{route('client2.home')}}">
           <img src="{{asset('client/home/images/logo1.jpg')}}" style="width: 100px ;height: 60px;" alt="logo">
        </a>
        <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <svg class="navbar-icon">
            <use xlink:href="#navbar-icon"></use>
          </svg>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
          <div class="offcanvas-header px-4 pb-0">
            <a class="navbar-brand" href="index.html">
               <img src="{{asset('client/home/images/logo.jpg')}}" style="width: 150px" alt="logo">
            </a>
            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdNavbar"></button>
          </div>
          <div class="offcanvas-body">
            <ul id="navbar" class="navbar-nav text-uppercase justify-content-end align-items-center flex-grow-1 pe-3">
              
              <div class="col-lg-3 col-6 text-right">

                <a href="{{route('client2.carts.index')}}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge text-black" id="productCountCart">{{$countProductInCart}}</span>
                </a>
              </div>
              <li  class="mx-3">
                <a href="{{route('client2.home')}}" class="dropdown-item">HOME</a>
              </li>
              <li  class="mx-3" >
                <a href="{{route('client2.orders.index')}}" class="dropdown-item">ORDER</a>
              </li>
              {{-- <li  class="mx-3" >
                <a href="{{ route('client2.orders.index', ['id' => auth()->id()]) }}" class="dropdown-item">ORDER</a>
              </li> --}}
              
                @foreach ($categories as $item)
                @if ($item->childrents->count() > 0)
                    <li class="nav-item dropdown">
                        <a class="nav-link me-4 dropdown-toggle link-dark" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"> {{$item->name}}</a>
                        <ul class="dropdown-menu">
                          <li class="mx-3">
                              @foreach ($item->childrents as $childCategory)
                              <a href="{{route('client2.products.index',['category_id'=>$childCategory->id])}}"
                                  class="dropdown-item">{{$childCategory->name}}</a>
                                  @endforeach
                          </li>
                        </ul>
                    </li>
                @else
                <li class="nav-item mx-3">
                    <a href="{{route('client2.products.index',['category_id'=>$item->id])}}"
                        class="dropdown-item">{{$item->name}}</a>
                </li>
                
                @endif
              @endforeach
                <li class="nav-item">
                  <div class="user-items ps-5">
                      <ul class="d-flex justify-content-end list-unstyled">
                          <li class="search-item pe-3">
                            <ul class="d-flex justify-content-end list-unstyled">
                                @if (auth()->check())
                                    <li class="nav-item dropdown">
                                        <a data-mdb-dropdown-init class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                                            <img src="https://mdbootstrap.com/img/new/avatars/2.jpg" class="rounded-circle" height="22" alt="Avatar" loading="lazy" />
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="navbarDropdownMenuLink">
                                            <li><p class="dropdown-item" href="#">{{auth()->user()->name}}</p></li>
                                            <li><a class="dropdown-item {{request()->routeIs('profile.*')}}" href="{{route('profile-setting.index')}}">Cài Đặt</a></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }} 
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li class="pe-3">
                                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                                    </li>
                                    <li class="pe-3">
                                        <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                      </ul>
                  </div>
              </li>
          </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>