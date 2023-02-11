<?php

return [
    [
        'name' => 'dashboard',
        'menu' => 'Dashboard',
        'icon' => 'ph-house',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'general',
                'menu' => 'Umum',
                'icon' => null,
                'link' => 'dashboard/general',
                'sub' => null
            ],
            [
                'name' => 'poly',
                'menu' => 'Poli',
                'icon' => null,
                'link' => 'dashboard/poly',
                'sub' => null
            ],
        ]
    ],
    [
        'name' => 'master-data',
        'menu' => 'Master Data',
        'icon' => 'ph-archive',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'general',
                'menu' => 'Umum',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'class-type',
                        'menu' => 'Kelas',
                        'icon' => null,
                        'link' => 'master-data/general/class-type',
                        'sub' => null
                    ],
                    [
                        'name' => 'doctor',
                        'menu' => 'Dokter',
                        'icon' => null,
                        'link' => 'master-data/general/doctor',
                        'sub' => null
                    ],
                    [
                        'name' => 'employee',
                        'menu' => 'Karyawan',
                        'icon' => null,
                        'link' => 'master-data/general/employee',
                        'sub' => null
                    ],
                    [
                        'name' => 'medical-service',
                        'menu' => 'Pelayanan Medis',
                        'icon' => null,
                        'link' => 'master-data/general/medical-service',
                        'sub' => null
                    ],
                    [
                        'name' => 'patient-group',
                        'menu' => 'Golongan Pasien',
                        'icon' => null,
                        'link' => 'master-data/general/patient-group',
                        'sub' => null
                    ],
                    [
                        'name' => 'religion',
                        'menu' => 'Agama',
                        'icon' => null,
                        'link' => 'master-data/general/religion',
                        'sub' => null
                    ],
                    [
                        'name' => 'unit',
                        'menu' => 'Unit',
                        'icon' => null,
                        'link' => 'master-data/general/unit',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'medical-record',
                'menu' => 'Rekam Medis',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'patient',
                        'menu' => 'Pasien',
                        'icon' => null,
                        'link' => 'master-data/medical-record/patient',
                        'sub' => null
                    ],
                    [
                        'name' => 'dtd',
                        'menu' => 'DTD',
                        'icon' => null,
                        'link' => 'master-data/medical-record/dtd',
                        'sub' => null
                    ],
                    [
                        'name' => 'icd',
                        'menu' => 'ICD',
                        'icon' => null,
                        'link' => 'master-data/medical-record/icd',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'room',
                'menu' => 'Kamar',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'data',
                        'menu' => 'Data',
                        'icon' => null,
                        'link' => 'master-data/room/data',
                        'sub' => null
                    ],
                    [
                        'name' => 'room-class',
                        'menu' => 'Kelas Kamar',
                        'icon' => null,
                        'link' => 'master-data/room/room-class',
                        'sub' => null
                    ],
                    [
                        'name' => 'room-space',
                        'menu' => 'Ruang Kamar',
                        'icon' => null,
                        'link' => 'master-data/room/room-space',
                        'sub' => null
                    ],
                    [
                        'name' => 'bed',
                        'menu' => 'Tempat Tidur',
                        'icon' => null,
                        'link' => 'master-data/room/bed',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'action',
                'menu' => 'Tindakan',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'data',
                        'menu' => 'Data',
                        'icon' => null,
                        'link' => 'master-data/action/data',
                        'sub' => null
                    ],
                    [
                        'name' => 'other',
                        'menu' => 'Lain - Lain',
                        'icon' => null,
                        'link' => 'master-data/action/other',
                        'sub' => null
                    ],
                    [
                        'name' => 'operative',
                        'menu' => 'Operatif',
                        'icon' => null,
                        'link' => 'master-data/action/operative',
                        'sub' => null
                    ],
                    [
                        'name' => 'non-operative',
                        'menu' => 'Non Operatif',
                        'icon' => null,
                        'link' => 'master-data/action/non-operative',
                        'sub' => null
                    ],
                    [
                        'name' => 'supporting',
                        'menu' => 'Penunjang',
                        'icon' => null,
                        'link' => 'master-data/action/supporting',
                        'sub' => null
                    ],
                    [
                        'name' => 'emergency-care',
                        'menu' => 'Rawat Darurat',
                        'icon' => null,
                        'link' => 'master-data/action/emergency-care',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'operating-room',
                'menu' => 'Kamar Operasi',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'action',
                        'menu' => 'Tindakan',
                        'icon' => null,
                        'link' => 'master-data/operating-room/action',
                        'sub' => null
                    ],
                    [
                        'name' => 'action-type',
                        'menu' => 'Jenis Tindakan',
                        'icon' => null,
                        'link' => 'master-data/operating-room/action-type',
                        'sub' => null
                    ],
                    [
                        'name' => 'operating-group',
                        'menu' => 'Golongan Operasi',
                        'icon' => null,
                        'link' => 'master-data/operating-room/operating-group',
                        'sub' => null
                    ],
                    [
                        'name' => 'anesthetist',
                        'menu' => 'Anestesi',
                        'icon' => null,
                        'link' => 'master-data/operating-room/anesthetist',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'health-service',
                'menu' => 'Layanan Kesehatan',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'functional-service',
                        'menu' => 'UPF',
                        'icon' => null,
                        'link' => 'master-data/health-service/functional-service',
                        'sub' => null
                    ],
                    [
                        'name' => 'bed',
                        'menu' => 'Tempat Tidur',
                        'icon' => null,
                        'link' => 'master-data/health-service/bed',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'poly',
                'menu' => 'Poli',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'data',
                        'menu' => 'Data',
                        'icon' => null,
                        'link' => 'master-data/poly/data',
                        'sub' => null
                    ],
                    [
                        'name' => 'action',
                        'menu' => 'Tindakan',
                        'icon' => null,
                        'link' => 'master-data/poly/action',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'lab',
                'menu' => 'Laboratorium',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'category',
                        'menu' => 'Kategori',
                        'icon' => null,
                        'link' => 'master-data/lab/category',
                        'sub' => null
                    ],
                    [
                        'name' => 'item',
                        'menu' => 'Item',
                        'icon' => null,
                        'link' => 'master-data/lab/item',
                        'sub' => null
                    ],
                    [
                        'name' => 'item-parent',
                        'menu' => 'Item Parent',
                        'icon' => null,
                        'link' => 'master-data/lab/item-parent',
                        'sub' => null
                    ],
                    [
                        'name' => 'item-option',
                        'menu' => 'Item Option',
                        'icon' => null,
                        'link' => 'master-data/lab/item-option',
                        'sub' => null
                    ],
                    [
                        'name' => 'item-group',
                        'menu' => 'Item Grup',
                        'icon' => null,
                        'link' => 'master-data/lab/item-group',
                        'sub' => null
                    ],
                    [
                        'name' => 'fee',
                        'menu' => 'Biaya',
                        'icon' => null,
                        'link' => 'master-data/lab/fee',
                        'sub' => null
                    ],
                    [
                        'name' => 'condition',
                        'menu' => 'Kondisi',
                        'icon' => null,
                        'link' => 'master-data/lab/condition',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'pharmacy',
                'menu' => 'Farmasi',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'distributor',
                        'menu' => 'Distributor',
                        'icon' => null,
                        'link' => 'master-data/pharmacy/distributor',
                        'sub' => null
                    ],
                    [
                        'name' => 'factory',
                        'menu' => 'Pabrik',
                        'icon' => null,
                        'link' => 'master-data/pharmacy/factory',
                        'sub' => null
                    ],
                    [
                        'name' => 'medicine',
                        'menu' => 'Obat',
                        'icon' => null,
                        'link' => 'master-data/pharmacy/medicine',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'radiology',
                'menu' => 'Radiologi',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'data',
                        'menu' => 'Data',
                        'icon' => null,
                        'link' => 'master-data/radiology/data',
                        'sub' => null
                    ],
                    [
                        'name' => 'action',
                        'menu' => 'Tindakan',
                        'icon' => null,
                        'link' => 'master-data/radiology/action',
                        'sub' => null
                    ],
                ]
            ],
            [
                'name' => 'location',
                'menu' => 'Wilayah',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'province',
                        'menu' => 'Provinsi',
                        'icon' => null,
                        'link' => 'master-data/location/province',
                        'sub' => null
                    ],
                    [
                        'name' => 'city',
                        'menu' => 'Kota',
                        'icon' => null,
                        'link' => 'master-data/location/city',
                        'sub' => null
                    ],
                    [
                        'name' => 'district',
                        'menu' => 'Kecamatan',
                        'icon' => null,
                        'link' => 'master-data/location/district',
                        'sub' => null
                    ],
                ]
            ],
        ]
    ],
    [
        'name' => 'collection',
        'menu' => 'Pendataan',
        'icon' => 'ph-folder-notch-open',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'outpatient',
                'menu' => 'Rawat Jalan',
                'icon' => null,
                'link' => 'collection/outpatient',
                'sub' => null
            ],
            [
                'name' => 'inpatient',
                'menu' => 'Rawat Inap',
                'icon' => null,
                'link' => 'collection/inpatient',
                'sub' => null
            ],
            [
                'name' => 'emergency-department',
                'menu' => 'IGD',
                'icon' => null,
                'link' => 'collection/emergency-department',
                'sub' => null
            ],
            [
                'name' => 'online',
                'menu' => 'Online',
                'icon' => null,
                'link' => 'collection/online',
                'sub' => null
            ],
        ]
    ],
    [
        'name' => 'lab',
        'menu' => 'Laboratorium',
        'icon' => 'ph-flask',
        'link' => 'lab',
        'sub' => null
    ],
    [
        'name' => 'radiology',
        'menu' => 'Radiologi',
        'icon' => 'ph-monitor',
        'link' => 'radiology',
        'sub' => null
    ],
    [
        'name' => 'accounting',
        'menu' => 'Akuntansi',
        'icon' => 'ph-books',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'chart-of-account',
                'menu' => 'Bagan Akun',
                'icon' => null,
                'link' => 'accounting/chart-of-account',
                'sub' => null
            ],
        ]
    ],
    [
        'name' => 'finance',
        'menu' => 'Keuangan',
        'icon' => 'ph-money',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'budget',
                'menu' => 'Anggaran',
                'icon' => null,
                'link' => 'finance/budget',
                'sub' => null
            ],
            [
                'name' => 'cash-bank',
                'menu' => 'Kas & bank',
                'icon' => null,
                'link' => 'finance/cash-bank',
                'sub' => null
            ],
        ]
    ],
    [
        'name' => 'report',
        'menu' => 'Laporan',
        'icon' => 'ph-newspaper',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'finance',
                'menu' => 'Keuangan',
                'icon' => null,
                'link' => 'javascript:void(0);',
                'sub' => [
                    [
                        'name' => 'budget',
                        'menu' => 'Anggaran',
                        'icon' => null,
                        'link' => 'report/finance/budget',
                        'sub' => null
                    ],
                ]
            ],
        ]
    ],
    [
        'name' => 'setting',
        'menu' => 'Pengaturan',
        'icon' => 'ph-gear',
        'link' => 'javascript:void(0);',
        'sub' => [
            [
                'name' => 'role',
                'menu' => 'Hak Akses',
                'icon' => null,
                'link' => 'setting/role',
                'sub' => null
            ],
            [
                'name' => 'user',
                'menu' => 'Pengguna',
                'icon' => null,
                'link' => 'setting/user',
                'sub' => null
            ],
        ]
    ],
];
