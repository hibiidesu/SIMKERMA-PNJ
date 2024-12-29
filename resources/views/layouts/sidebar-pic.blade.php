
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
                <li class="sidebar-item {{ url()->current() == url('pic/dashboard') ? 'active' : '' }}" 
    style="{{ url()->current() == url('pic/dashboard') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none;' : '' }}">
    <a href="{{ url('pic/dashboard') }}" class='sidebar-link' 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-th-large" style="margin-right: 8px;"></i>
        <span class="text-capitalize">Dashboard</span>
    </a>
</li>

<li class="sidebar-item {{ url()->current() == url('pic/kerjasama') ? 'active' : '' }}" 
    style="{{ url()->current() == url('pic/kerjasama') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none;' : '' }}">
    <a href="{{ url('pic/kerjasama') }}" class='sidebar-link' 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-handshake" style="margin-right: 8px;"></i>
        <span class="text-capitalize">Kerja Sama</span>
    </a>
</li>

<li class="sidebar-item {{ url()->current() == url('pic/pengajuan-kerjasama') ? 'active' : '' }}" 
    style="{{ url()->current() == url('pic/pengajuan-kerjasama') ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none;' : '' }}">
    <a href="{{ url('pic/pengajuan-kerjasama') }}" class='sidebar-link' 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-file" style="margin-right: 8px;"></i>
        <span class="text-capitalize">Pengajuan Kerja Sama</span>
    </a>
</li>

<hr>

<li class="sidebar-item {{ url()->current() == url('pic/my-profile/'.Auth::user()->id) ? 'active' : '' }}" 
    style="{{ url()->current() == url('pic/my-profile/'.Auth::user()->id) ? 'background-color: #018797; color: white; border-radius: 8px; box-shadow: none;' : '' }}">
    <a href="{{ url('pic/my-profile/'.Auth::user()->id) }}" class='sidebar-link' 
       style="display: flex; align-items: center; text-decoration: none; background-color: transparent; color: inherit; border: none; outline: none; box-shadow: none; padding: 10px; border-radius: 8px;">
        <i class="fas fa-user" style="margin-right: 8px;"></i>
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
