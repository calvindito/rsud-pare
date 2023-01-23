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
                                <a href="#" class="nav-link">Umum</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/class-type') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'class-type' ? 'active' : '' }}">Kelas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/doctor') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'doctor' ? 'active' : '' }}">Dokter</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/employee') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'employee' ? 'active' : '' }}">Karyawan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/general/medical-service') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'general' && Request::segment(3) == 'medical-service' ? 'active' : '' }}">Pelayanan Medik</a>
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
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'medical-record' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Rekam Medik</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'medical-record' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/medical-record/patient') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'medical-record' && Request::segment(3) == 'patient' ? 'active' : '' }}">Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/medical-record/dtd') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'medical-record' && Request::segment(3) == 'dtd' ? 'active' : '' }}">DTD</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/medical-record/icd') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'medical-record' && Request::segment(3) == 'icd' ? 'active' : '' }}">ICD</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'room' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Kamar</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'room' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/room/data') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'room' && Request::segment(3) == 'data' ? 'active' : '' }}">Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/room/room-class') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'room' && Request::segment(3) == 'room-class' ? 'active' : '' }}">Kelas Kamar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/room/room-space') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'room' && Request::segment(3) == 'room-space' ? 'active' : '' }}">Ruang Kamar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/room/bed') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'room' && Request::segment(3) == 'bed' ? 'active' : '' }}">Tempat Tidur</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Tindakan</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/action/data') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' && Request::segment(3) == 'data' ? 'active' : '' }}">Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/action/other') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' && Request::segment(3) == 'other' ? 'active' : '' }}">Lain - Lain</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/action/operative') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' && Request::segment(3) == 'operative' ? 'active' : '' }}">Operatif</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/action/non-operative') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' && Request::segment(3) == 'non-operative' ? 'active' : '' }}">Non Operatif</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/action/supporting') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' && Request::segment(3) == 'supporting' ? 'active' : '' }}">Penunjang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/action/emergency-care') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'action' && Request::segment(3) == 'emergency-care' ? 'active' : '' }}">Rawat Darurat</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'operating-room' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Kamar Operasi</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'operating-room' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/operating-room/action') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'operating-room' && Request::segment(3) == 'action' ? 'active' : '' }}">Tindakan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/operating-room/action-type') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'operating-room' && Request::segment(3) == 'action-type' ? 'active' : '' }}">Jenis Tindakan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/operating-room/operating-group') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'operating-room' && Request::segment(3) == 'operating-group' ? 'active' : '' }}">Golongan Operasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/operating-room/anesthetist') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'operating-room' && Request::segment(3) == 'anesthetist' ? 'active' : '' }}">Anestesi</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'health-service' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Layanan Kesehatan</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'health-service' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/health-service/upf') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'health-service' && Request::segment(3) == 'upf' ? 'active' : '' }}">UPF</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/health-service/bed') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'health-service' && Request::segment(3) == 'bed' ? 'active' : '' }}">Tempat Tidur</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'poly' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Poli</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'poly' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/poly/data') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'poly' && Request::segment(3) == 'data' ? 'active' : '' }}">Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/poly/action') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'poly' && Request::segment(3) == 'action' ? 'active' : '' }}">Tindakan</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Laboratorium</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/category') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'category' ? 'active' : '' }}">Kategori</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/item') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'item' ? 'active' : '' }}">Item</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/item-parent') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'item-parent' ? 'active' : '' }}">Item Parent</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/item-option') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'item-option' ? 'active' : '' }}">Item Option</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/item-group') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'item-group' ? 'active' : '' }}">Item Grup</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/medicine') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'medicine' ? 'active' : '' }}">Obat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/fee') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'fee' ? 'active' : '' }}">Biaya</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/lab/condition') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'lab' && Request::segment(3) == 'condition' ? 'active' : '' }}">Kondisi</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'radiology' ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="#" class="nav-link">Radiologi</a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'radiology' ? 'show' : '' }}">
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/radiology/data') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'radiology' && Request::segment(3) == 'data' ? 'active' : '' }}">Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master-data/radiology/action') }}" class="nav-link {{ Request::segment(1) == 'master-data' && Request::segment(2) == 'radiology' && Request::segment(3) == 'action' ? 'active' : '' }}">Tindakan</a>
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
                                </ul>
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
                                <a href="{{ url('setting/menu') }}" class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'menu' ? 'active' : '' }}">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('setting/role') }}" class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'role' ? 'active' : '' }}">Hak Akses</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('setting/user') }}" class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'user' ? 'active' : '' }}">Pengguna</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('setting/nunber-medical-record') }}" class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'nunber-medical-record' ? 'active' : '' }}">Nomor Rekam Medik</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-inner">
