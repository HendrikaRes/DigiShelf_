  <!-- Sidebar Start -->
  <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-book"></i> DigiShelf</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                       <img class="rounded-circle" src="{{ asset('img/logosmp.png') }}" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle  border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Tester</h6>
                        <span>{{ Auth::user()->role }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                   <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" 
    class="nav-item nav-link 
    {{ request()->is('admin/dashboard') || request()->is('user/dashboard') ? 'active' : '' }}">
    <i class="fa fa-tachometer-alt me-2"></i>Dashboard
</a>

                       @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('anggota.index') }}" 
                        class="nav-item nav-link {{ request()->is('anggota*') ? 'active' : '' }}">
                            <i class="fa fa-user-circle"></i> Anggota
                        </a>
                    @endif

                      <a href="{{ auth()->user()->role === 'admin' ? route('admin.buku.index') : route('user.buku.index') }}"
                        class="nav-item nav-link {{ request()->is('admin/buku*') || request()->is('user/buku*') ? 'active' : '' }}">
                        <i class="fa fa-book"></i> Buku
                        </a>

                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.peminjaman.index') : route('user.peminjaman.index') }}"
    class="nav-item nav-link 
    {{ request()->is('admin/peminjaman*') || request()->is('user/peminjaman*') ? 'active' : '' }}">
    <i class="fa fa-envelope"></i> Peminjaman
</a>

                        <a href="{{ auth()->user()->role === 'admin' 
        ? route('admin.pengembalian.index') 
        : route('user.pengembalian.index') }}"
    class="nav-item nav-link 
    {{ request()->is('admin/pengembalian*') || request()->is('user/pengembalian*') ? 'active' : '' }}">
    <i class="fa fa-table me-2"></i> Pengembalian
</a>
@if(auth()->check() && auth()->user()->role === 'user' && auth()->user()->nis === 'Kepala')
    <a href="{{ route('laporan.index') }}"
        class="nav-item nav-link {{ request()->is('laporan') ? 'active' : '' }}">
        <i class="fa fa-file-alt me-2"></i> Laporan Kepala
    </a>
@endif


                    
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->