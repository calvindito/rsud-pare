<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Dashboard - <span class="fw-normal">Kunjungan</span>
            </h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="row">
        <div class="col-md-12">
            <form id="form-chart-1">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Kunjungan Per Tahun</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart1()">
                                        @for($i = date('Y'); $i >= 2018; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Tahun {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-light" onclick="chart1()">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-1" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form id="form-chart-2">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Kunjungan 3 Tahun Terakhir</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <span>Tahun {{ date('Y', strtotime('-3 years')) }} s/d Tahun {{ date('Y') }}</span>
                                <a href="javascript:void(0);" class="btn btn-light" onclick="chart2()">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-2" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form id="form-chart-3">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Kunjungan 5 Tahun Terakhir</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <span>Tahun {{ date('Y', strtotime('-3 years')) }} s/d Tahun {{ date('Y') }}</span>
                                <a href="javascript:void(0);" class="btn btn-light" onclick="chart3()">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-3" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <form id="form-chart-4">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Kunjungan Rawat Jalan</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart4()">
                                        @for($i = date('Y'); $i >= 2018; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Tahun {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-light" onclick="chart4()">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-4" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <form id="form-chart-5">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Kunjungan Rawat Inap</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart5()">
                                        @for($i = date('Y'); $i >= 2018; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Tahun {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-light" onclick="chart5()">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-5" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <form id="form-chart-6">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Kunjungan IGD</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart6()">
                                        @for($i = date('Y'); $i >= 2018; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Tahun {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-light" onclick="chart6()">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-6" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
        loadAllChart();
    });

    function loadAllChart() {
        chart1();
        chart2();
        chart3();
        chart4();
        chart5();
        chart6();
    }

    function chart1() {
        $.ajax({
            url: '{{ url("dashboard/visit/per-year") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-1').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-1');
            },
            success: function(response) {
                onLoading('close', '#form-chart-1');

                var chartSelector = document.getElementById('chart-1');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    grid: {
                        left: 0,
                        right: 2,
                        top: 10,
                        bottom: 0,
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: response.label,
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
                    series: response.data
                };

                option && chart.setOption(option);
            },
            error: function(response) {
                onLoading('close', '#form-chart-1');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function chart2() {
        $.ajax({
            url: '{{ url("dashboard/visit/last-3-year") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-2').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-2');
            },
            success: function(response) {
                onLoading('close', '#form-chart-2');

                var chartSelector = document.getElementById('chart-2');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'item'
                    },
                    series: [
                        {
                            type: 'pie',
                            smooth: true,
                            radius: '90%',
                            data: response,
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
            },
            error: function(response) {
                onLoading('close', '#form-chart-2');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function chart3() {
        $.ajax({
            url: '{{ url("dashboard/visit/last-5-year") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-3').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-3');
            },
            success: function(response) {
                onLoading('close', '#form-chart-3');

                var chartSelector = document.getElementById('chart-3');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'item'
                    },
                    series: [
                        {
                            type: 'pie',
                            smooth: true,
                            radius: '90%',
                            data: response,
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
            },
            error: function(response) {
                onLoading('close', '#form-chart-3');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function chart4() {
        $.ajax({
            url: '{{ url("dashboard/visit/inpatient") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-4').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-4');
            },
            success: function(response) {
                onLoading('close', '#form-chart-4');

                var chartSelector = document.getElementById('chart-4');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                        type: 'shadow'
                        }
                    },
                    grid: {
                        left: 0,
                        right: 10,
                        top: 50,
                        bottom: 0,
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: response.label,
                            axisTick: {
                                alignWithLabel: true
                            }
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value'
                        }
                    ],
                    series: [
                        {
                            type: 'bar',
                            smooth: true,
                            barWidth: '90%',
                            data: response
                        }
                    ]
                };

                option && chart.setOption(option);
            },
            error: function(response) {
                onLoading('close', '#form-chart-4');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function chart4() {
        $.ajax({
            url: '{{ url("dashboard/visit/outpatient") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-4').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-4');
            },
            success: function(response) {
                onLoading('close', '#form-chart-4');

                var chartSelector = document.getElementById('chart-4');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        left: 0,
                        right: 2,
                        top: 10,
                        bottom: 0,
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: response.label,
                            axisTick: {
                                alignWithLabel: true
                            },
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
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
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
                        }
                    ],
                    axisPointer: [
                        {
                            lineStyle: {
                                color: '#6B7280'
                            }
                        }
                    ],
                    series: [
                        {
                            name: 'Total',
                            type: 'bar',
                            smooth: true,
                            barWidth: '60%',
                            data: response.data
                        }
                    ]
                };

                option && chart.setOption(option);
            },
            error: function(response) {
                onLoading('close', '#form-chart-4');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function chart5() {
        $.ajax({
            url: '{{ url("dashboard/visit/inpatient") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-5').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-5');
            },
            success: function(response) {
                onLoading('close', '#form-chart-5');

                var chartSelector = document.getElementById('chart-5');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        left: 0,
                        right: 2,
                        top: 10,
                        bottom: 0,
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: response.label,
                            axisTick: {
                                alignWithLabel: true
                            },
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
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
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
                        }
                    ],
                    axisPointer: [
                        {
                            lineStyle: {
                                color: '#6B7280'
                            }
                        }
                    ],
                    series: [
                        {
                            name: 'Total',
                            type: 'bar',
                            smooth: true,
                            barWidth: '60%',
                            data: response.data
                        }
                    ]
                };

                option && chart.setOption(option);
            },
            error: function(response) {
                onLoading('close', '#form-chart-5');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function chart6() {
        $.ajax({
            url: '{{ url("dashboard/visit/emergency-department") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-chart-6').serialize(),
            beforeSend: function() {
                onLoading('show', '#form-chart-6');
            },
            success: function(response) {
                onLoading('close', '#form-chart-6');

                var chartSelector = document.getElementById('chart-6');
                var chart = echarts.init(chartSelector, null, {
                    renderer: 'canvas'
                });

                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        left: 0,
                        right: 2,
                        top: 10,
                        bottom: 0,
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: response.label,
                            axisTick: {
                                alignWithLabel: true
                            },
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
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
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
                        }
                    ],
                    axisPointer: [
                        {
                            lineStyle: {
                                color: '#6B7280'
                            }
                        }
                    ],
                    series: [
                        {
                            name: 'Total',
                            type: 'bar',
                            smooth: true,
                            barWidth: '60%',
                            data: response.data
                        }
                    ]
                };

                option && chart.setOption(option);
            },
            error: function(response) {
                onLoading('close', '#form-chart-6');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }
</script>
