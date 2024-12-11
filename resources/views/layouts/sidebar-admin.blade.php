
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
                            <div class="h4 fw-bolder ps-2 mt-3" style="font-family: 'Viga'; color: #088A9A">SIMKERMA</div>
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

                <li class="sidebar-item {{ url()->current() == url('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard') }}" class='sidebar-link'>
                        <i class="fas fa-th-large"></i>
                        <span class="text-capitalize">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ url()->current() == url('admin/kerjasama') ? 'active' : '' }}">
                    <a href="{{ url('admin/kerjasama') }}" class='sidebar-link'>
                        <i class="fas fa-handshake"></i>
                        <span class="text-capitalize">kerja sama</span>
                    </a>
                </li>
                <li class="sidebar-item {{ url()->current() == url('admin/pengajuan-kerjasama') ? 'active' : '' }}">
                    <a href="{{ url('admin/pengajuan-kerjasama') }}" class='sidebar-link'>
                        <i class="fas fa-file"></i>
                        <span class="text-capitalize">pengajuan kerja sama</span>
                    </a>
                </li>
                <li class="sidebar-item {{ url()->current() == url('admin/jenis-kerjasama') ? 'active' : '' }}">
                    <a href="{{ url('admin/jenis-kerjasama') }}" class='sidebar-link'>
                        <i class="fas fa-layer-group"></i>
                        <span class="text-capitalize">jenis kerja sama</span>
                    </a>
                </li>
                <li class="sidebar-item {{ url()->current() == url('admin/perjanjian-kerjasama') ? 'active' : '' }}">
                    <a href="{{ url('admin/perjanjian-kerjasama') }}" class='sidebar-link'>
                        <i class="fas fa-file-alt"></i>
                        <span class="text-capitalize">perjanjian kerja sama</span>
                    </a>
                </li>
                <li class="sidebar-item {{ url()->current() == url('admin/template/') ? 'active' : '' }}">
                    <a href="{{ url('admin/template/') }}" class='sidebar-link'>
                        <i class="fas fa-clipboard"></i>
                        <span class="text-capitalize">Template</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#unitProdiMenu" class='sidebar-link' data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="unitProdiMenu">
                        <i class="fas fa-sign"></i>
                        <span class="text-capitalize">Unit & Prodi</span>
                    </a>
                    <div class="collapse" id="unitProdiMenu">
                        <ul class="menu mt-0"> <!-- Add margin or padding to nest the items -->
                            <li class="sidebar-item {{ url()->current() == url('admin/unit') ? 'active' : '' }}">
                                <a href="{{ url('admin/unit') }}" class='sidebar-link'>
                                    <i class="fas fa-sign"></i>
                                    <span class="text-capitalize">Unit</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ url()->current() == url('admin/prodi') ? 'active' : '' }}">
                                <a href="{{ url('admin/prodi') }}" class='sidebar-link'>
                                    <i class="fas fa-house-user"></i>
                                    <span class="text-capitalize">Prodi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-item">
                    <a href="#unitMitraMenu" class='sidebar-link' data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="unitMitraMenu">
                        <i class="fas fa-folder"></i>
                        <span class="text-capitalize">Mitra</span>
                    </a>
                    <div class="collapse" id="unitMitraMenu">
                        <ul class="menu mt-0"> <!-- Add margin or padding to nest the items -->
                            <li class="sidebar-item {{ url()->current() == url('admin/kriteria/kemitraan') ? 'active' : '' }}">
                                <a href="{{ url('admin/kriteria/kemitraan') }}" class='sidebar-link'>
                                    {{-- <i class="fas fa-sign"></i> --}}
                                    <span class="text-capitalize">Kriteria Kemitraan</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ url()->current() == url('admin/kriteria/mitra') ? 'active' : '' }}">
                                <a href="{{ url('admin/kriteria/mitra') }}" class='sidebar-link'>
                                    {{-- <i class="fas fa-house-user"></i> --}}
                                    <span class="text-capitalize">Kriteria Mitra</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-item {{ url()->current() == url('admin/user/') ? 'active' : '' }}">
                    <a href="{{ url('admin/user/') }}" class='sidebar-link'>
                        <i class="fas fa-user"></i>
                        <span class="text-capitalize">User</span>
                    </a>
                </li>
                <hr>
                <li class="sidebar-item {{ url()->current() == url('admin/my-profile/'.Auth::user()->id) ? 'active' : '' }}">
                    <a href="{{ url('admin/my-profile/'.Auth::user()->id) }}" class='sidebar-link'>
                        <i class="fas fa-user"></i>
                        <span class="text-capitalize">My Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class='sidebar-link' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out"></i>
                        <span class="text-capitalize">{{ __('Logout') }}</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
