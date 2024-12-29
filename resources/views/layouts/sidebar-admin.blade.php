
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ asset('img/logo-pnj.png') }}" alt="logo" style="height: 40px">
                            </div>
                            <div class="h4 fw-bolder ps-2 mt-3" style="font-family: 'Viga'; color: #018979">SIMKERMA</div>
                        </div>
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                {{-- <li class="sidebar-title">Menu</li> --}}

                <li class="sidebar-item" 
    style="{{ request()->is('admin/dashboard') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none; border: none;' : '' }}">
    <a href="{{ url('admin/dashboard') }}" 
    class="sidebar-link" 
    style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
    <i class="fas fa-th-large" 
    style="margin-right: 8px; color: {{ request()->is('admin/dashboard') ? 'white' : '#018797' }};"></i>
    <span class="text-capitalize">Dashboard</span>
 </a>
</li>

           <li class="sidebar-item" 
    style="{{ request()->is('admin/kerjasama') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none; border: none;' : '' }}">
    <a href="{{ url('admin/kerjasama') }}" 
       class="sidebar-link" 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-handshake" style="margin-right: 8px; color: {{ request()->is('admin/kerjasama') ? 'white' : '#018797' }};"></i>
        <span class="text-capitalize">Kerja Sama</span>
    </a>
</li>

<li class="sidebar-item" 
    style="{{ request()->is('admin/pengajuan-kerjasama') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none; border: none;' : '' }}">
    <a href="{{ url('admin/pengajuan-kerjasama') }}" 
       class="sidebar-link" 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-file" style="margin-right: 8px; color: {{ request()->is('admin/pengajuan-kerjasama') ? 'white' : '#018797' }};"></i>
        <span class="text-capitalize">Pengajuan Kerja Sama</span>
    </a>
</li>

<li class="sidebar-item" 
    style="{{ request()->is('admin/jenis-kerjasama') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none; border: none;' : '' }}">
    <a href="{{ url('admin/jenis-kerjasama') }}" 
       class="sidebar-link" 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-layer-group" style="margin-right: 8px; color: {{ request()->is('admin/jenis-kerjasama') ? 'white' : '#018797' }};"></i>
        <span class="text-capitalize">Jenis Kerja Sama</span>
    </a>
</li>

<li class="sidebar-item" 
    style="{{ request()->is('admin/perjanjian-kerjasama') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none; border: none;' : '' }}">
    <a href="{{ url('admin/perjanjian-kerjasama') }}" 
       class="sidebar-link" 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-file-alt" style="margin-right: 8px; color: {{ request()->is('admin/perjanjian-kerjasama') ? 'white' : '#018797' }};"></i>
        <span class="text-capitalize">Perjanjian Kerja Sama</span>
    </a>
</li>

<li class="sidebar-item">
    <a href="#unitProdiMenu" class="sidebar-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="unitProdiMenu"
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-sign" style="margin-right: 8px; color: #018797;"></i>
        <span class="text-capitalize">Unit & Prodi</span>
    </a>
    <div class="collapse" id="unitProdiMenu">
        <ul class="menu mt-0"> <!-- Add margin or padding to nest the items -->
            <li class="sidebar-item {{ url()->current() == url('admin/unit') ? 'active' : '' }}">
                <a href="{{ url('admin/unit') }}" class='sidebar-link'
                   style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
                    <i class="fas fa-sign" style="margin-right: 8px; color: {{ request()->is('admin/unit') ? 'white' : '#018797' }};"></i>
                    <span class="text-capitalize">Unit</span>
                </a>
            </li>
            <li class="sidebar-item {{ url()->current() == url('admin/prodi') ? 'active' : '' }}">
                <a href="{{ url('admin/prodi') }}" class='sidebar-link'
                   style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
                    <i class="fas fa-house-user" style="margin-right: 8px; color: {{ request()->is('admin/prodi') ? 'white' : '#018797' }};"></i>
                    <span class="text-capitalize">Prodi</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="sidebar-item">
    <a href="#unitMitraMenu" class="sidebar-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="unitMitraMenu"
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-folder" style="margin-right: 8px; color: #018797;"></i>
        <span class="text-capitalize">Mitra</span>
    </a>
    <div class="collapse" id="unitMitraMenu">
        <ul class="menu mt-0">
            <li class="sidebar-item {{ url()->current() == url('admin/kriteria/kemitraan') ? 'active' : '' }}">
                <a href="{{ url('admin/kriteria/kemitraan') }}" class='sidebar-link'
                   style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
                    <span class="text-capitalize">Kriteria Kemitraan</span>
                </a>
            </li>
            <li class="sidebar-item {{ url()->current() == url('admin/kriteria/mitra') ? 'active' : '' }}">
                <a href="{{ url('admin/kriteria/mitra') }}" class='sidebar-link'
                   style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
                    <span class="text-capitalize">Kriteria Mitra</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="sidebar-item {{ url()->current() == url('admin/user/') ? 'active' : '' }}">
    <a href="{{ url('admin/user/') }}" class='sidebar-link'
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-user" style="margin-right: 8px; color: {{ request()->is('admin/user/') ? 'white' : '#018797' }};"></i>
        <span class="text-capitalize">User</span>
    </a>
</li>

<hr>

<li class="sidebar-item {{ url()->current() == url('admin/my-profile/'.Auth::user()->id) ? 'active' : '' }}">
    <a href="{{ url('admin/my-profile/'.Auth::user()->id) }}" class='sidebar-link'
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-user" style="margin-right: 8px; color: {{ request()->is('admin/my-profile/'.Auth::user()->id) ? 'white' : '#018797' }};"></i>
        <span class="text-capitalize">My Profile</span>
    </a>
</li>

<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-sign-out" style="margin-right: 8px; color: #018797;"></i>
        <span class="text-capitalize">{{ __('Logout') }}</span>
    </a>
</li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
