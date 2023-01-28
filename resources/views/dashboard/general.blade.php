<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">Dashboard Umum</h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="chart-visits-per-years" style="width:100%; height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="chart-visits-last-five-years" style="width:100%; height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="chart-patient-type-group" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="chart-recap-outpatient-visits" style="width:100%; height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="chart-recap-inpatient-visits" style="width:100%; height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills nav-pills-outline nav-pills-toolbar nav-justified">
                        <li class="nav-item">
                            <a href="#uptodate-outpatient-registration" class="nav-link rounded-start-pill active" data-bs-toggle="tab">
                                Registrasi Terkini Pasien Rawat Jalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#uptodate-inpatient-registration" class="nav-link rounded-end-pill" data-bs-toggle="tab">
                                Registrasi Terkini Pasien Rawat Inap
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content flex-1">
                        <div class="tab-pane fade show active" id="uptodate-outpatient-registration">
                            <p class="mt-2">
                                <div class="list-group list-group-borderless py-2">
									<div class="list-group-item fw-semibold">List Pasien Rawat Jalan</div>
									<a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">James Alexander, TN</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / James Alexander, TN ke Unit IGD
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">James Alexander, TN</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / James Alexander, TN ke Unit IGD
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">James Alexander, TN</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / James Alexander, TN ke Unit IGD
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">James Alexander, TN</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / James Alexander, TN ke Unit IGD
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">James Alexander, TN</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / James Alexander, TN ke Unit IGD
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">James Alexander, TN</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / James Alexander, TN ke Unit IGD
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
								</div>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="uptodate-inpatient-registration">
                            <p class="mt-2">
                                <div class="list-group list-group-borderless py-2">
									<div class="list-group-item fw-semibold">List Pasien Rawat Inap</div>
									<a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face2.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">Monica Smith, NY</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / Monica Smith, NY ke Unit IGD Kelas
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face2.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">Monica Smith, NY</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / Monica Smith, NY ke Unit IGD Kelas
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face2.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">Monica Smith, NY</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / Monica Smith, NY ke Unit IGD Kelas
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face2.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">Monica Smith, NY</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / Monica Smith, NY ke Unit IGD Kelas
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face2.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">Monica Smith, NY</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / Monica Smith, NY ke Unit IGD Kelas
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
                                    <a href="#" class="list-group-item list-group-item-action hstack gap-3">
                                        <img src="{{ asset('template/assets/images/demo/users/face2.jpg') }}" class="w-40px h-40px rounded-pill">
										<div class="flex-fill">
											<div class="fw-semibold text-primary">Monica Smith, NY</div>
											<span class="text-muted">
                                                {{ rand(000000, 999999) }} / Monica Smith, NY ke Unit IGD Kelas
                                            </span>
										</div>
										<div class="align-self-center ms-3">
											<span class="text-success">
												<i class="ph-clock me-1"></i>
												{{ date('d/m/Y H:i:s') }}
											</span>
										</div>
									</a>
								</div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        chartPatientTypeGroup();
        chartVisitsPerYears();
        chartVisitsLastFiveYears();
        chartRecapOutpatientVisits();
        chartRecapInpatientVisits();
    });

    function chartPatientTypeGroup() {
        var chartSelector = document.getElementById('chart-patient-type-group');
        var chart = echarts.init(chartSelector, null, {
            renderer: 'canvas'
        });

        var option = {
            title: {
                text: 'Kelompok Jenis Pasien',
                left: 'center',
                top: 0,
                bottom: 0,
                right: 0
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: 'bottom'
            },
            series: [
                {
                    name: 'Persentasi',
                    type: 'pie',
                    radius: '100%',
                    top: 60,
                    bottom: 60,
                    data: [
                        { value: 1048, name: 'Search Engine' },
                        { value: 735, name: 'Direct' },
                        { value: 580, name: 'Email' },
                        { value: 484, name: 'Union Ads' },
                        { value: 300, name: 'Video Ads' }
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        option && chart.setOption(option);
    }

    function chartVisitsPerYears() {
        var chartSelector = document.getElementById('chart-visits-per-years');
        var chart = echarts.init(chartSelector, null, {
            renderer: 'canvas'
        });

        var option = {
            title: {
                text: 'Kunjungan Tahun {{ date("Y") }}',
                left: 'center',
                top: 0,
                bottom: 0,
                right: 0
            },
            tooltip: {
                trigger: 'axis',
            },
            legend: {
                data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine'],
                top: 40
            },
            grid: {
                left: 0,
                right: 10,
                top: 80,
                bottom: 0,
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisLine: {
                    lineStyle: {
                        color: '#9CA3AF'
                    }
                },
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: '#E5E7EB'
                    }
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '{value} °C',
                    color: 'rgba(31, 41, 55, .65)'
                },
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: '#9CA3AF'
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: '#E5E7EB'
                    }
                },
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: ['rgba(255, 255, 255, .01)', 'rgba(0, 0, 0, .01)']
                    }
                }
            },
            axisPointer: [
                {
                    lineStyle: {
                        color: '#6B7280'
                    }
                }
            ],
            series: [
                {
                    name: 'Email',
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name: 'Union Ads',
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name: 'Video Ads',
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name: 'Direct',
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [320, 332, 301, 334, 390, 330, 320]
                },
                {
                    name: 'Search Engine',
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [820, 932, 901, 934, 1290, 1330, 1320]
                }
            ]
        };

        option && chart.setOption(option);
    }

    function chartVisitsLastFiveYears() {
        var chartSelector = document.getElementById('chart-visits-last-five-years');
        var chart = echarts.init(chartSelector, null, {
            renderer: 'canvas'
        });

        var option = {
            title: {
                text: 'Kunjungan 5 Tahun Terakhir',
                left: 'center',
                top: 0,
                bottom: 0,
                right: 0
            },
            tooltip: {
                trigger: 'axis',
            },
            legend: {
                data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine'],
                top: 40
            },
            grid: {
                left: 0,
                right: 10,
                top: 80,
                bottom: 0,
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisLine: {
                    lineStyle: {
                        color: '#9CA3AF'
                    }
                },
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: '#E5E7EB'
                    }
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '{value} °C',
                    color: 'rgba(31, 41, 55, .65)'
                },
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: '#9CA3AF'
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: '#E5E7EB'
                    }
                },
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: ['rgba(255, 255, 255, .01)', 'rgba(0, 0, 0, .01)']
                    }
                }
            },
            axisPointer: [
                {
                    lineStyle: {
                        color: '#6B7280'
                    }
                }
            ],
            series: [
                {
                    name: 'Email',
                    type: 'line',
                    stack: 'Total',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name: 'Union Ads',
                    type: 'line',
                    stack: 'Total',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name: 'Video Ads',
                    type: 'line',
                    stack: 'Total',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name: 'Direct',
                    type: 'line',
                    stack: 'Total',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [320, 332, 301, 334, 390, 330, 320]
                },
                {
                    name: 'Search Engine',
                    type: 'line',
                    stack: 'Total',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    data: [820, 932, 901, 934, 1290, 1330, 1320]
                }
            ]
        };

        option && chart.setOption(option);
    }

    function chartRecapOutpatientVisits() {
        var chartSelector = document.getElementById('chart-recap-outpatient-visits');
        var chart = echarts.init(chartSelector, null, {
            renderer: 'canvas'
        });

        var option = {
            title: {
                text: 'Rekap Kunjungan Rawat Jalan',
                left: 'center',
                top: 0,
                bottom: 0,
                right: 0
            },
            tooltip: {
                trigger: 'axis',
            },
            grid: {
                left: 0,
                right: 10,
                top: 50,
                bottom: 0,
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    color: ['#005FA5'],
                    data: [120, 200, 150, 80, 70, 110, 130],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }
            ]
        };

        option && chart.setOption(option);
    }

    function chartRecapInpatientVisits() {
        var chartSelector = document.getElementById('chart-recap-inpatient-visits');
        var chart = echarts.init(chartSelector, null, {
            renderer: 'canvas'
        });

        var option = {
            title: {
                text: 'Rekap Kunjungan Rawat Inap',
                left: 'center',
                top: 0,
                bottom: 0,
                right: 0
            },
            tooltip: {
                trigger: 'axis',
            },
            grid: {
                left: 0,
                right: 10,
                top: 50,
                bottom: 0,
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    color: ['#005FA5'],
                    data: [120, 200, 150, 80, 70, 110, 130],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }
            ]
        };

        option && chart.setOption(option);
    }
</script>
