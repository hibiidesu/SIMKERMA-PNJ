@extends('layouts.app')
@section('heading', 'Dashboard')

@section('content')
<section class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm" id="chart-data">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama <br> Masih Berlaku / Sudah Berakhir
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-5"></div>
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm" id="chart-by-sifat">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama <br> Berdasarkan Sifat
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <select name="filter" id="filter" class="border rounded ps-2 pe-3 py-1">
                        <option value="0">Semua</option>
                        <option value="1" selected>Masih Berlaku</option>
                        <option value="2">Sudah Berakhir</option>
                    </select>
                </div>
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm" id="chart-by-jenis-kerjasama">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama <br> Berdasarkan Bidang Kerja Sama
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <select name="filter" id="filter" class="border rounded ps-2 pe-3 py-1">
                        <option value="0">Semua</option>
                        <option value="1" selected>Masih Berlaku</option>
                        <option value="2">Sudah Berakhir</option>
                    </select>
                </div>
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm" id="chart-by-memorandum">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama <br> Berdasarkan <i>Memorandum</i>
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <select name="filter" id="filter" class="border rounded ps-2 pe-3 py-1">
                        <option value="0">Semua</option>
                        <option value="1" selected>Masih Berlaku</option>
                        <option value="2">Sudah Berakhir</option>
                    </select>
                </div>
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm" id="chart-by-sifat-year">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama Baru Setiap Tahun-nya <br> Berdasarkan Sifat
                </h5>
            </div>
            <div class="card-body">
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm" id="chart-by-jenis-year">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama Baru Setiap Tahun-nya <br> Berdasarkan Bidang Kerja Sama
                </h5>
            </div>
            <div class="card-body">
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mb-4">
        <div class="card shadow-sm" id="chart-by-unit">
            <div class="card-header text-center">
                <h5 class="card-title mb-0">
                    Data Kerja Sama <br> Berdasarkan Unit
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <select name="filter" id="filter" class="border rounded ps-2 pe-3 py-1">
                        <option value="0">Semua</option>
                        <option value="1" selected>Masih Berlaku</option>
                        <option value="2">Sudah Berakhir</option>
                    </select>
                </div>
                <canvas class="canvas-chart"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/chart-init.js') }}"></script>
<script>
    const dynamicColors = function() {
        return Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255);
    };

    function getDataChart() {
        chartData.data.labels = [];
        chartData.data.datasets[0].data = [];
        chartData.data.datasets[0].borderColor = [];
        chartData.data.datasets[0].backgroundColor = [];

        $.ajax({
            url: "{{ url('/chart/data') }}",
            type: 'GET',
            success: function(response) {
                response.data.map((item, index) => {
                    const color = dynamicColors();
                    chartData.data.labels.push(response.labels[index]);
                    chartData.data.datasets[0].data.push(item);
                    chartData.data.datasets[0].borderColor.push('rgba(' + color + ', 1)');
                    chartData.data.datasets[0].backgroundColor.push('rgba(' + color + ', 0.4)');
                });
                chartData.update();
            }
        });
    }
    function getDataChartByJenisYear() {
        let chartData = [];
        let chartLabels = [];
        let chartDatasets = {
            datasets: [],
            labels: [],
        }
        $.ajax({
            url: "{{ url('/chart/jenis-year') }}",
            type: 'GET',
            data: {
                filter: $('#chart-by-jenis #filter').val()
            },
            success: function(response) {
                response.labels.map((item, index) => {
                    chartDatasets.labels.push(item.year);
                });
                response.result.map((item, index) => {
                    if (!chartLabels.includes(item.label)) {
                        chartLabels.push(item.label);
                        chartData[item.label] = [];
                    }
                    chartData[item.label][chartDatasets.labels.indexOf(item.year)] = item.data;
                });
                chartLabels.map((item, index) => {
                    chartDatasets.labels.map((x, index) => {
                        chartData[item][index] = chartData[item][index] || 0;
                    });
                    const color = dynamicColors();
                    chartDatasets.datasets.push({
                        fill: true,
                        label: item,
                        type: "line",
                        data: chartData[item],
                        borderColor: 'rgba(' + color + ', 1)',
                        backgroundColor: 'rgba(' + color + ', 0.1)',
                    });
                });
                chartByJenisYear.data = chartDatasets
                chartByJenisYear.update();
            }
        });
    }
    function getDataChartBySifatYear() {
        let chartData = [];
        let chartLabels = [];
        let chartDatasets = {
            datasets: [],
            labels: [],
        }
        $.ajax({
            url: "{{ url('/chart/sifat-year') }}",
            type: 'GET',
            data: {
                filter: $('#chart-by-sifat #filter').val()
            },
            success: function(response) {
                response.labels.map((item, index) => {
                    chartDatasets.labels.push(item.year);
                });
                response.result.map((item, index) => {
                    if (!chartLabels.includes(item.label)) {
                        chartLabels.push(item.label);
                        chartData[item.label] = [];
                    }
                    chartData[item.label][chartDatasets.labels.indexOf(item.year)] = item.data;
                });
                chartLabels.map((item, index) => {
                    chartDatasets.labels.map((x, index) => {
                        chartData[item][index] = chartData[item][index] || 0;
                    });
                    const color = dynamicColors();
                    chartDatasets.datasets.push({
                        fill: true,
                        label: item,
                        type: "line",
                        data: chartData[item],
                        borderColor: 'rgba(' + color + ', 1)',
                        backgroundColor: 'rgba(' + color + ', 0.1)',
                    });
                });
                chartBySifatYear.data = chartDatasets
                chartBySifatYear.update();
            }
        });
    }
    function getDataChartBySifat(x) {
        chartBySifat.data.labels = [];
        chartBySifat.data.datasets[0].data = [];
        if (x) {
            chartBySifat.data.datasets[0].borderColor = [];
            chartBySifat.data.datasets[0].backgroundColor = [];
        }

        $.ajax({
            url: "{{ url('/chart/sifat') }}",
            type: 'GET',
            data: {
                filter: $('#chart-by-sifat #filter').val()
            },
            success: function(response) {
                response.result.map((item, index) => {
                    const color = dynamicColors();
                    chartBySifat.data.labels.push(item.label);
                    chartBySifat.data.datasets[0].data.push(item.data);
                    if (x) {
                        chartBySifat.data.datasets[0].borderColor.push('rgba(' + color + ', 1)');
                        chartBySifat.data.datasets[0].backgroundColor.push('rgba(' + color + ', 0.4)');
                    }
                });
                chartBySifat.update();
            }
        });
    }
    function getDataChartByMemorandum(x) {
        let moreData = [];
        chartByMemorandum.data.labels = [];
        chartByMemorandum.data.datasets[0].data = [];
        if (x) {
            chartByMemorandum.data.datasets[0].borderColor = [];
            chartByMemorandum.data.datasets[0].backgroundColor = [];
        }

        $.ajax({
            url: "{{ url('/chart/memorandum') }}",
            type: 'GET',
            data: {
                filter: $('#chart-by-memorandum #filter').val()
            },
            success: function(response) {
                response.more.map((item, index) => {
                    item.label.split(',').map((x, index) => {
                        if (x in moreData) {
                            moreData[x] += item.data;
                        } else {
                            moreData[x] = item.data;
                        }
                    });
                });
                response.result.map((item, index) => {
                    const color = dynamicColors();
                    chartByMemorandum.data.labels.push(item.label);
                    chartByMemorandum.data.datasets[0].data.push(item.data + (moreData[item.pks_id] || 0));
                    if (x) {
                        chartByMemorandum.data.datasets[0].borderColor.push('rgba(' + color + ', 1)');
                        chartByMemorandum.data.datasets[0].backgroundColor.push('rgba(' + color + ', 0.4)');
                    }
                });
                chartByMemorandum.update();
            }
        });
    }
    function getDataChartByJenisKerjasama(x) {
        chartByJenisKerjasama.data.labels = [];
        chartByJenisKerjasama.data.datasets[0].data = [];
        if (x) {
            chartByJenisKerjasama.data.datasets[0].borderColor = [];
            chartByJenisKerjasama.data.datasets[0].backgroundColor = [];
        }

        $.ajax({
            url: "{{ url('/chart/jenis-kerjasama') }}",
            type: 'GET',
            data: {
                filter: $('#chart-by-jenis-kerjasama #filter').val()
            },
            success: function(response) {
                response.labels.map((item, index) => {
                    const color = dynamicColors();
                    chartByJenisKerjasama.data.labels.push((item.label ? item.label : '-'));
                    if (x) {
                        chartByJenisKerjasama.data.datasets[0].borderColor.push('rgba(' + color + ', 1)');
                        chartByJenisKerjasama.data.datasets[0].backgroundColor.push('rgba(' + color + ', 0.4)');
                    }
                });
                response.result.map((item, index) => {
                    if (chartByJenisKerjasama.data.labels.includes(item.label)) {
                        chartByJenisKerjasama.data.datasets[0].data[chartByJenisKerjasama.data.labels.indexOf(item.label)] = item.data;
                    }
                    if (!item.label && chartByJenisKerjasama.data.labels.includes('-')) {
                        chartByJenisKerjasama.data.datasets[0].data.push(item.data);
                    }
                });
                chartByJenisKerjasama.update();

            }
        });
    }
    function getDataChartByUnit(x) {
        let moreData = [];
        chartByUnit.data.labels = [];
        chartByUnit.data.datasets[0].data = [];
        if (x) {
            chartByUnit.data.datasets[0].borderColor = [];
            chartByUnit.data.datasets[0].backgroundColor = [];
        }

        $.ajax({
            url: "{{ url('/chart/unit') }}",
            type: 'GET',
            data: {
                filter: $('#chart-by-unit #filter').val()
            },
            success: function(response) {
                response.more.map((item, index) => {
                    item.label.split(',').map((x, index) => {
                        if (x in moreData) {
                            moreData[x] += item.data;
                        } else {
                            moreData[x] = item.data;
                        }
                    });
                });
                response.result.map((item, index) => {
                    const color = dynamicColors();
                    chartByUnit.data.labels.push(item.label);
                    chartByUnit.data.datasets[0].data.push(item.data + (moreData[item.pks_id] || 0));
                    if (x) {
                        chartByUnit.data.datasets[0].borderColor.push('rgba(' + color + ', 1)');
                        chartByUnit.data.datasets[0].backgroundColor.push('rgba(' + color + ', 0.4)');
                    }
                });
                chartByUnit.update();
            }
        });
    }
    $(document).ready(function() {
        getDataChart();
        getDataChartByUnit(1);
        getDataChartBySifat(1);
        getDataChartBySifatYear(1);
        getDataChartByJenisYear(1);
        getDataChartByMemorandum(1);
        getDataChartByJenisKerjasama(1);
    });

    $('#chart-by-unit #filter').change(function() {
        getDataChartByUnit(0);
    });
    $('#chart-by-sifat #filter').change(function() {
        getDataChartBySifat(0);
    });
    $('#chart-by-jenis-kerjasama #filter').change(function() {
        getDataChartByJenisKerjasama(0);
    });
    $('#chart-by-memorandum #filter').change(function() {
        getDataChartByMemorandum(0);
    });
</script>
@endsection
