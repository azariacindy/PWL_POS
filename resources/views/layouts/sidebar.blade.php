<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ auth()->check() ? auth()->user()->getProfilePictureUrl() : asset('adminlte/dist/img/user2-160x160.jpg') }}"
            class="img-circle elevation-2" alt="User Image" style="width: 32px; height: 32px; object-fit: cover;"> 
        </div>
        <div class="info">
            <a href="{{ url('/profile') }}" class="d-block">{{ auth()->check() ? auth()->user()->nama : 'Guest' }}</a>
        </div>
    </div>
  
    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
  
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
            <li class="nav-header">User Data</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>User Data</p>
                </a>
            </li>
            <li class="nav-header">Item Data</li>
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori')? 'active' : '' }} ">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Item Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')? 'active' : '' }} ">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Item Data</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Item Stock</p>
                </a>
            </li>
            <li class="nav-header">Transaction Data</li>
            <li class="nav-item">
                <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Sales Transaction</p>
                </a>
                <a href="{{ url('/penjualan_detail') }}" class="nav-link {{ $activeMenu == 'penjualan_detail' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shipping-fast"></i>
                    <p>Sales Details</p>
                </a>
            </li>
             <li class="nav-header">Log out</li>
             <li class="nav-item">
                 <a href="{{ url('/logout') }}" class="nav-link {{ $activeMenu == 'logout' ? 'active' : '' }}">
                     <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                     <p class="text-danger">Log out</p>
                 </a>
             </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>