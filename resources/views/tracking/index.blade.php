@extends('layouts.app')
@section('content')
<section class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="card-title mb-4 text-center">Track Kerjasama</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Track Persetujuan Kerjasama</h4>
                <form id="trackForm">
                    <div class="input-group mb-3">
                        <input type="text" id="tracker_id" class="form-control" name="tracker_id" required placeholder="Masukan ID Pengajuan">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
                <div id="response" class="mt-4"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#trackForm').on('submit', function(e) {
        e.preventDefault();
        const trackerId = $('#tracker_id').val();
        $.ajax({
            url: `/api/track/${trackerId}`,
            type: 'GET',
            success: function(response) {
                if (response.message === "success") {
                    const data = response.data[0];
                    $('#response').html(`
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Status:<br>${data.step}</h5>
                                <div class="progress mb-4" style="height: 25px; background-color: ${getProgressPercentage(data.step_code) === 0 ? '#dc3545' : '#e9ecef'};">
                                    <div class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: ${getProgressPercentage(data.step_code)}%;
                                                ${getProgressPercentage(data.step_code) === 0 ? 'background-color: transparent !important;' : ''}
                                                color: #000;
                                                font-weight: bold;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                transition: width 0.6s ease;"
                                        aria-valuenow="${getProgressPercentage(data.step)}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.log.map((item) => `
                                                <tr>
                                                    <td>👉</td>
                                                    <td><b>${item.created_at}</b></td>
                                                    <td>${item.step}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                                <h5 class="card-title">Detail<br>Kerjasama: ${data.kerjasama}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Mitra: ${data.mitra}</h6>
                                <p class="card-text mt-3">
                                    <strong>Nomor:</strong> ${data.nomor}<br>
                                    <strong>Periode:</strong> ${data.tanggal_mulai} s/d ${data.tanggal_selesai}<br>
                                    <strong>Jenis:</strong> ${data.jenis_kerjasama}<br>
                                    <strong>Sifat:</strong> ${data.sifat}
                                </p>
                                <div class="mt-3">
                                    <h6>Kriteria Mitra:</h6>
                                    <ul>
                                        ${data.kriteria_mitra.map(item => `<li>${item}</li>`).join('')}
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <h6>Kriteria Kemitraan:</h6>
                                    <ul>
                                        ${data.kriteria_kemitraan.map(item => `<li>${item}</li>`).join('')}
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <h6>Jurusan / Unit Terkait:</h6>
                                    <ul>
                                        ${data.jurusan.map(item => `<li>${item}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    $('#response').html("<p class='text-danger'>No data found.</p>");
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    'title': status.toUpperCase(),
                    'text': 'Data Tidak Di Temukan',
                    'icon': 'error'
                });
            }
        });
    });

    function getProgressPercentage(step) {
        const steps = {
            1 : 14,
            2 : 0,
            3 : 42,
            4 : 0,
            5 : 70,
            6 : 0,
            7 : 100
        };
        return steps[step] || 0;
    }
});
</script>
@endsection
