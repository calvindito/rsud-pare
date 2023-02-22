<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Dashboard - <span class="fw-normal">Pendapatan</span>
            </h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="row">
        <div class="col-md-6">
            <form id="form-chart-1">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Pembelian Item Per Tahun</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart1()">
                                        @for($i = date('Y'); $i >= 2015; $i--)
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
                        <h6 class="py-sm-3 mb-sm-0">Penjualan Item Per Tahun</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart2()">
                                        @for($i = date('Y'); $i >= 2015; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Tahun {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
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
        <div class="col-md-12">
            <form id="form-chart-3">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h6 class="py-sm-3 mb-sm-0">Perbandingan Pembelian & Penjualan Item Per Tahun</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart3()">
                                        @for($i = date('Y'); $i >= 2015; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Tahun {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
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
                        <h6 class="py-sm-3 mb-sm-0">Laba Pendapatan Item Per Tahun</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart4()">
                                        @for($i = date('Y'); $i >= 2015; $i--)
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
                        <h6 class="py-sm-3 mb-sm-0">Pendapatan Dari Kamar Operasi Per Tahun</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <select class="form-select wmin-200" name="year" onchange="chart5()">
                                        @for($i = date('Y'); $i >= 2015; $i--)
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
    }

    function chart1() {
        $.ajax({
            url: '{{ url("dashboard/income/purchase-item") }}',
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
                        left: 2,
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
            url: '{{ url("dashboard/income/sale-item") }}',
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
                        trigger: 'axis'
                    },
                    grid: {
                        left: 2,
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
            url: '{{ url("dashboard/income/compare-purchase-sale-item") }}',
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
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        left: 2,
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
                    series: response.data
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
            url: '{{ url("dashboard/income/profit-item") }}',
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
                        trigger: 'axis'
                    },
                    grid: {
                        left: 2,
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
                    series: [
                        {
                            type: 'line',
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
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
            url: '{{ url("dashboard/income/operating-room") }}',
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
                        trigger: 'axis'
                    },
                    grid: {
                        left: 2,
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
                    series: [
                        {
                            type: 'line',
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
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
</script>
