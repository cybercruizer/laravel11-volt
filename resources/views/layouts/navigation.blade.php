<ul class="nav flex-column pt-3 pt-md-0">
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link d-flex align-items-center">
            <span class="sidebar-icon me-3">
                <img src="{{ asset('images/brand/brand-smk.png') }}" height="20" width="20" alt="Volt Logo">
            </span>
            <span class="mt-1 ms-1 sidebar-text">
                {{ env('APP_NAME') }}
            </span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="nav-link">
            <span class="sidebar-icon">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                </svg>
            </span>
            <span class="sidebar-text">{{ __('Dashboard') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('siswas.index') ? 'active' : '' }}">
        <a href="{{ route('siswas.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-users fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Daftar Siswa') }}</span>
        </a>
    </li>

    {{-- KALENDER --}}
    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#kalender-sub">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-calendar"></i>
                </span>
                <span class="sidebar-text">Kalender</span>
            </span>
            <span class="link-arrow">
                <i class="fas fa-arrow-right"></i>
            </span>
        </span>
        <div class="multi-level collapse {{ request()->is('*/kalender/*') ? 'show' : '' }}" role="list"
            id="kalender-sub" aria-expanded="{{ request()->is('*/kalender/*') ? 'true' : 'false' }}">
            <ul class="flex-column nav">
                @can('event-create')
                    <li class="nav-item {{ request()->routeIs('kalender.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kalender.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-edit"></i>
                            </span>
                            <span class="sidebar-text">Edit Kalender</span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item {{ request()->routeIs('kalender.show') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kalender.show') }}">
                        <span class="sidebar-icon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <span class="sidebar-text">Lihat Kalender</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    @can('woroworo-list')
        {{-- Pengumuman --}}
        <li class="nav-item {{ request()->routeIs('woroworo.index') ? 'active' : '' }}">
            <a href="{{ route('woroworo.index') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-satellite-dish"></i>
                </span>
                <span class="sidebar-text">Pengumuman</span>
            </a>
        </li>
    @endcan
    @can('kelas-list')
        {{-- Kelas --}}
        <li class="nav-item {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
            <a href="{{ route('kelas.index') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <span class="sidebar-text">Kelas</span>
            </a>
        </li>
        {{-- <li class="nav-item {{ request()->routeIs('kelas.naik') ? 'active' : '' }}">
            <a href="{{ route('kelas.naik') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-arrow-up"></i>
                </span>
                <span class="sidebar-text">Naik Kelas</span>
            </a>
        </li> --}}
        <li class="nav-item {{ request()->routeIs('kelas.step1') ? 'active' : '' }}">
            <a href="{{ route('kelas.step1') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-list"></i>
                </span>
                <span class="sidebar-text">Proses Naik Kelas</span>
            </a>
        </li>
    @endcan
    @can('presensi-list')
        @role('WaliKelas')
            <li class="nav-item {{ request()->routeIs('administrasi.index') ? 'active' : '' }}">
                <a href="{{ route('administrasi.index') }}" class="nav-link">
                    <span class="sidebar-icon me-3">
                        <i class="fas fa-user-cog"></i>
                    </span>
                    <span class="sidebar-text">Administrasi Kelas</span>
                </a>
            </li>
        @endrole
        <!-- Presensi -->
        <li class="nav-item">
            <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                data-bs-target="#presensi-sub">
                <span>
                    <span class="sidebar-icon me-3">
                        <i class="fas fa-list"></i>
                    </span>
                    <span class="sidebar-text">Presensi</span>
                </span>
                <span class="link-arrow">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </span>
            <div class="multi-level collapse" role="list" id="presensi-sub" aria-expanded="false">
                <ul class="flex-column nav">

                    <li class="nav-item {{ request()->routeIs('presensi.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('presensi.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-users"></i>
                            </span>
                            <span class="sidebar-text">Isi Presensi</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('presensi.laporan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('presensi.laporan') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-user-tag"></i>
                            </span>
                            <span class="sidebar-text">Laporan</span>
                        </a>
                    </li>
                    @can('presensi-admin')
                    <li class="nav-item {{ request()->routeIs('presensi.admin') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('presensi.admin') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-check"></i>
                            </span>
                            <span class="sidebar-text">Lap Per Kelas</span>
                        </a>
                    </li>
                    @endcan
                    @can('presensi-list')
                    <li class="nav-item {{ request()->routeIs('presensi.rekap.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('presensi.rekap.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-check"></i>
                            </span>
                            <span class="sidebar-text">Rekap per tanggal</span>
                        </a>
                    </li>
                    @endcan

                    @can('presensi-create')
                        <li class="nav-item {{ request()->routeIs('presensi.edit') ? 'active' : '' }}">
                            <a class="nav-link" href="/presensi/edit">
                                <span class="sidebar-icon">
                                    <i class="fa fa-user-tag"></i>
                                </span>
                                <span class="sidebar-text">Edit</span>
                            </a>
                        </li>
                    @endcan
                    @can('presensi-delete')
                        <li class="nav-item {{ request()->routeIs('presensi.reset') ? 'active' : '' }}">
                            <a class="nav-link" href="/presensi/reset">
                                <span class="sidebar-icon">
                                    <i class="fa fa-user-tag"></i>
                                </span>
                                <span class="sidebar-text">Reset</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
    @endcan

    {{-- Menu keuangan --}}
    @can('tagihan-list')
    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#submenu-keuangan">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-coins"></i>
                </span>
                <span class="sidebar-text">Keuangan</span>
            </span>
            <span class="link-arrow">
                <i class="fas fa-arrow-right"></i>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="submenu-keuangan" aria-expanded="true">
            <ul class="flex-column nav">
                    <li class="nav-item {{ request()->routeIs('tagihan.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tagihan.index') }}">
                            <span class="sidebar-icon">
                                <i class="fas fa-stream"></i>
                            </span>
                            <span class="sidebar-text">Jenis Tagihan</span>
                        </a>
                    </li>
                @can('pembayaran-list')
                    <li class="nav-item {{ request()->routeIs('pembayaran.spp') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pembayaran.spp') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-balance-scale"></i>
                            </span>
                            <span class="sidebar-text">Rekap SPP</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('pembayaran.lain') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pembayaran.lain') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-balance-scale"></i>
                            </span>
                            <span class="sidebar-text">Pembayaran Lain</span>
                        </a>
                    </li>
                    {{--<li class="nav-item {{ request()->routeIs('pelanggaran.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pelanggaran.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-balance-scale"></i>
                            </span>
                            <span class="sidebar-text">Rekap Pembayaran lain</span>
                        </a>
                    </li>--}}
                @endcan
                @can('pembayaran-edit')
                <li class="nav-item {{ request()->routeIs('pembayaran.sync') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembayaran.sync') }}">
                        <span class="sidebar-icon">
                            <i class="fa fa-balance-scale"></i>
                        </span>
                        <span class="sidebar-text">Sinkronisasi</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </li>
    @endcan
    {{-- End Menu keuangan --}}


    {{-- Menu BK --}}
    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#submenu-bk">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-gavel"></i>
                </span>
                <span class="sidebar-text">BK</span>
            </span>
            <span class="link-arrow">
                <i class="fas fa-arrow-right"></i>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="submenu-bk" aria-expanded="true">
            <ul class="flex-column nav">
                @can('pelanggaran-list')
                    <li class="nav-item {{ request()->routeIs('jenispelanggaran.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('jenispelanggaran.index') }}">
                            <span class="sidebar-icon">
                                <i class="fas fa-stream"></i>
                            </span>
                            <span class="sidebar-text">Jenis Pelanggaran</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('pelanggaran.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pelanggaran.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-balance-scale"></i>
                            </span>
                            <span class="sidebar-text">Laporan Pelanggaran</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('pelanggaran.cari') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pelanggaran.cari') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-user"></i>
                            </span>
                            <span class="sidebar-text">Cari Siswa</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('penanganan.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('penanganan.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="sidebar-text">Penanganan Siswa</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
    {{-- End Menu BK --}}

    <!-- Seting -->
    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#submenu-app">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-cogs"></i>
                </span>
                <span class="sidebar-text">Seting</span>
            </span>
            <span class="link-arrow">
                <i class="fas fa-arrow-right"></i>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="submenu-app" aria-expanded="false">
            <ul class="flex-column nav">
                @can('user-list')
                    <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-users"></i>
                            </span>
                            <span class="sidebar-text">User</span>
                        </a>
                    </li>
                @endcan

                @can('role-list')
                    <li class="nav-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-user-tag"></i>
                            </span>
                            <span class="sidebar-text">Roles</span>
                        </a>
                    </li>
                @endcan
                @can('jurusan-list')
                    <li class="nav-item {{ request()->routeIs('jurusan.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('jurusan.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="sidebar-text">Jurusan</span>
                        </a>
                    </li>
                @endcan    
                @can('walikelas-list')
                    <li class="nav-item {{ request()->routeIs('walikelas.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('walikelas.index') }}">
                            <span class="sidebar-icon">
                                <i class="fa fa-user-tag"></i>
                            </span>
                            <span class="sidebar-text">Daft Wali Kelas</span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('profile.show') }}">
                        <span class="sidebar-icon">
                            <i class="fa fa-user-tag"></i>
                        </span>
                        <span class="sidebar-text">Ubah Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>
<li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
<span class="text-gray-400 text-xs letter-spacing-0 mx-3 d-block">Peran anda: {{ Auth::user()->getRoleNames()[0] }}</span>
@role('Kapro')
    @php
        $kelas=Auth::user()->jurusan->kelas;
    @endphp
    <span class="text-gray-400 text-xs letter-spacing-0 mx-3 d-block">Kelas:
        @foreach ($kelas as $kel )
            {{$kel->class_name}}, 
    @endforeach
    </span>
@endrole
