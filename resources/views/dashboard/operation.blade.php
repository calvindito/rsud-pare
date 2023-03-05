<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Dashboard - <span class="fw-normal">Operasi</span>
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
                        <h6 class="py-sm-3 mb-sm-0">Data Per Tahun</h6>
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
                        <h6 class="py-sm-3 mb-sm-0">Jenis Anestesi Per Bulan</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <div class="input-group">
                                    <span class="input-group-text">Filter</span>
                                    <input type="month" class="form-control" name="year_month" value="{{ date('Y-m') }}">
                                </div>
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
                        <h6 class="py-sm-3 mb-sm-0">Status Per Bulan</h6>
                        <div class="ms-sm-auto my-sm-auto">
                            <div class="hstack gap-3 justify-content-between">
                                <span>{{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}</span>
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
    }

    function chart1() {
        $.ajax({
            url: '{{ url("dashboard/operation/per-year") }}',
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
            url: '{{ url("dashboard/operation/anesthetist") }}',
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
            url: '{{ url("dashboard/operation/status") }}',
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
</script>
