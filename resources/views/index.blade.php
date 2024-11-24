@extends('layouts.apps')

@section('content')
{{-- <div style="background-color: #f5f5f5">
    <div class="container py-md-5 py-3">
        <div class="row align-items-center">
            <div class="col-md-6 order-md-0 order-1">
                <h2 class="fw-bold my-4 ">
                    Dashboard SIMKERMA <br>Politenik Negeri Jakarta
                </h2>
                <p>
                    Sistem Kerja Sama (SIMKERMA) PNJ menyajikan data historis kerja sama Politeknik Negeri Jakarta
                </p>
            </div>
            <div class="col-md-6 text-center order-md-1 order-0 mb-md-0 mb-3">
                <img src="{{ asset('img/banner.png') }}" alt="Header" class="img-responsive w-75">
            </div>
        </div>
    </div>
</div> --}}
<div style="">
    <img src="{{ asset('img/header.jpg') }}" alt="Header" class="img-responsive w-100" style="max-height: 500px">
</div>
<div class="container-xl container-fluid py-md-5 py-4">
    <div class="row justify-content-md-center">
        <div class="col-12 mb-3">
            <h2 class="fw-bold text-center">Data Kerja Sama</h2>
        </div>
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header text-center"><strong>Total kerjasama</strong></div>
                        <div class="card-body">
                            <h5 class="card-title text-center" id="totalKerjasama">0</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header text-center"><strong>Total kerjasama yang sedang berlangsung</strong></div>
                        <div class="card-body">
                            <h5 class="card-title text-center" id="kerjasamaBerlangsung">0</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header text-center"><strong>Total kerjasama yang sudah selesai</strong></div>
                        <div class="card-body">
                            <h5 class="card-title text-center" id="kerjasamaSelesai">0</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <h2 class="fw-bold text-center">Data Statistik</h2>
        </div>
        <div class="col-lg-6 mb-4">
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
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm" id="chart-by-sifat">
                <div class="card-header text-center">
                    <h5 class="card-title mb-0">
                        Data Kerja Sama  <br> Berdasarkan Sifat
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
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm" id="chart-by-jenis-kerjasama">
                <div class="card-header text-center">
                    <h5 class="card-title mb-0">
                        Data Kerja Sama <br> Berdasarkan Jenis Kerja Sama
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
        <div class="col-lg-6 mb-4">
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
        <div class="col-lg-6 mb-4">
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
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm" id="chart-by-jenis-year">
                <div class="card-header text-center">
                    <h5 class="card-title mb-0">
                        Data Kerja Sama Baru Setiap Tahun-nya <br> Berdasarkan Jenis Kerja Sama
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
    </div>
</div>
<div class="container-fluid py-md-5 py-4">
    <div class="row">
        <div class="col-12 mb-3 px-4">
            <div class="owl-carousel owl-theme">
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/kominfo.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/rindam.jpg') }}" alt="kerjasama pnj" style="width : 150px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/jasamarga.png') }}" alt="kerjasama pnj" style="width : 220px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/kota-jakarta.png') }}" alt="kerjasama pnj" style="width : 150px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/kord.png') }}" alt="kerjasama pnj" style="width : 220px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/kota-depok.png') }}" alt="kerjasama pnj" style="width : 120px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/bni.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/bnsp.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/bri.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/mandiri.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/msu.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/ui.png') }}" alt="kerjasama pnj" style="width : 120px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/denso.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/gmf.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/holcim.jpg') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/itc.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/mercubuana.jpg') }}" alt="kerjasama pnj" style="width : 150px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/metro.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/mnc.jpg') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/budi-luhur.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/ngl.png') }}" alt="kerjasama pnj" style="width : 120px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/paragon.jpg') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/pln.png') }}" alt="kerjasama pnj" style="width : 120px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/polban.png') }}" alt="kerjasama pnj" style="width : 120px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/pp.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/skp.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/surveyor.jpg') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/trakindo.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/tual.png') }}" alt="kerjasama pnj" style="width : 120px; display: unset">
                </div>
                <div class="text-center">
                    <img src="{{ asset('img/kerjasama/ungku-oemar.png') }}" alt="kerjasama pnj" style="width : 180px; display: unset">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-info">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center small align-items-center text-white pt-3">
                <p>Copyright © <a href="https://www.pnj.ac.id/" target="_blank" class="text-white fw-bold text-decoration-none">Politeknik Negeri Jakarta</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/chart-init.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        stagePadding: 70,
        margin:10,
        autoplay:true,
        autoplayTimeout:2500,
        nav:false,
        responsive:{
            0:{
                items:2,
                margin:120,
                stagePadding: 0,
            },
            568:{
                items:2
            },
            768:{
                items:3
            },
            1200:{
                items:6
            }
        }
    })
    const dynamicColors = function() {
        return Math.floor((0 + Math.random()) * 256/1.5) + "," + Math.floor((0 + Math.random()) * 256/1.5) + "," + Math.floor((0 + Math.random()) * 256/1.5);
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

    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    function fetchKerjasamaStats() {
        fetch('/api/data-kerjasama')
            .then(response => response.json())
            .then(data => {
                animateValue(document.getElementById("totalKerjasama"), 0, data.total, 2000);
                animateValue(document.getElementById("kerjasamaBerlangsung"), 0, data.berlangsung, 2000);
                animateValue(document.getElementById("kerjasamaSelesai"), 0, data.selesai, 2000);
            });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        fetchKerjasamaStats();
    });
</script>
@endsection
