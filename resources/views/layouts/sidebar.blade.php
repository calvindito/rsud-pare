<div class="page-content">
    <div class="sidebar sidebar-main sidebar-expand-xl">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <div class="sidebar-section-body d-flex justify-content-center pb-1">
                    <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigasi</h5>
                    <div>
                        <button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-xl-inline-flex"><i class="ph-arrows-left-right"></i></button>
                        <button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-xl-none"><i class="ph-x"></i></button>
                    </div>
                </div>
            </div>
            <div class="sidebar-section">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Menu</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'dashboard' ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="ph-house"></i>
                            <span>Dashboard</span>
                        </a>
                        <ul class="nav-group-sub collapse {{ Request::segment(1) == 'dashboard' ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="{{ url('dashboard/general') }}" class="nav-link {{ Request::segment(1) == 'dashboard' && Request::segment(2) == 'general' ? 'active' : '' }}">Umum</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="ph-archive"></i>
                            <span>Master Data</span>
                        </a>
                        <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' ? 'show' : '' }}">
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">General</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/class-type') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'class-type' ? 'active' : '' }}">Kelas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/doctor') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'doctor' ? 'active' : '' }}">Dokter</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/dtd') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'dtd' ? 'active' : '' }}">DTD</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/employee') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'employee' ? 'active' : '' }}">Karyawan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/medical-service') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'medical-service' ? 'active' : '' }}">Pelayanan Medik</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/medicine') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'medicine' ? 'active' : '' }}">Obat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/patient') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'patient' ? 'active' : '' }}">Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/patient-group') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'patient-group' ? 'active' : '' }}">Golongan Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/religion') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'religion' ? 'active' : '' }}">Agama</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/unit') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'unit' ? 'active' : '' }}">Unit</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'location' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Wilayah</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'location' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/location/province') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'location' && Request::segment(3) == 'province' ? 'active' : '' }}">Provinsi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/location/city') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'location' && Request::segment(3) == 'city' ? 'active' : '' }}">Kota</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/location/district') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'location' && Request::segment(3) == 'district' ? 'active' : '' }}">Kecamatan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/location/village') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'location' && Request::segment(3) == 'village' ? 'active' : '' }}">Kelurahan</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-shield-plus"></i>
                            <span>BPJS</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-user-plus"></i>
                            <span>Pasien</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-first-aid"></i>
                            <span>Rekam Medik</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-syringe"></i>
                            <span>Data Rawat</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-bed"></i>
                            <span>Data OK</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="ph-video-camera"></i>
                            <span>Radiologi</span>
                        </a>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-flask"></i>
                            <span>Laboratorium</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-heartbeat"></i>
                            <span>Farmasi</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="ph-files"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">
                            <i class="ph-clipboard-text"></i>
                            <span>Laporan</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">Dropdown 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'setting' ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="ph-gear"></i>
                            <span>Pengaturan</span>
                        </a>
                        <ul class="nav-group-sub collapse {{ Request::segment(1) == 'setting' ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="{{ url('setting/role') }}" class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'role' ? 'active' : '' }}">Role</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-inner">
