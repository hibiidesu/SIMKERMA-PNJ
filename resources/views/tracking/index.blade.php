@extends('layouts.app')
@section('heading', 'SIMKERMA Tracker')
@section('content')
<section class="row">
    <div class="col-10">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <div class="row">
                    <div class="order-md-0 order-1 col-12 col-md-8">
                        <h4>Track Kerjasama</h4>
                    </div>
                    <form id="trackForm">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
<<<<<<< Updated upstream
                                    <label class="mb-2 fw-bold text-capitalize" for="tracker_id">Cari Pengajuan<span class="text-danger"></span></label>
                                    <input type="text" id="tracker_id" class="form-control" name="tracker_id" required placeholder="Masukan ID Pengajuan cnth 1">
=======
                                    <label class="mb-2 fw-bold text-capitalize" for="tracker_id">Cari kerja sama<span class="text-danger"></span></label>
                                    <input type="text" id="tracker_id" class="form-control" name="tracker_id" required>
>>>>>>> Stashed changes
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 d-flex justify-content-start">
                                    <a class="btn btn-info" href="/">Kembali</a>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary mb-1">Submit</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div id="response" class="mt-3">
                    <!-- Tracking data will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
</section>

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
                        $('#response').empty();

                        // HTML untuk tracking status
                        $('#response').html(`
                            <div class="col-12" style="text-align: center; position: relative;">
                                <div class="card shadow-sm border mb-3" style="width: 100%; max-width: 100%; margin: auto;">
                                    <div class="card-body">
                                        <div style="display: flex; align-items: center; justify-content: space-between; text-align: center;">

                                            <!-- pengajuan -->
                                            <div>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; 
                                                    background-color: 
                                                        ${data.approve_status == '2' ? '#ffc107' : (['3', '4'].includes(data.approve_status) ? '#66BB6A' : '#66BB6A')}; 
                                                    display: flex; align-items: center; justify-content: center; margin: auto;">
                                                    <i class="fas fa-user" style="color: #ffffff; font-size: 24px;"></i>
                                                </div>
                                                <h6 style="margin-top: 13px; color: #000000;">pengajuan</h6>
                                                <div>${data.approve_status == '2' ? data.statusAlias.status : 'Menunggu Persetujuan'}</div>
                                                <div>${data.updated_at}</div>
                                            </div>

                                            <!-- Garis Horizontal -->
                                            <div style="flex-grow: 1; height: 1px; background-color: #018797; margin: 1%;"></div>

                                            <!-- Tim Legal -->
                                            <div>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; 
                                                    background-color: 
                                                        ${data.approve_status == '3' ? '#ffc107' : (data.approve_status == '4' ? '#66BB6A' : '#66BB6A')}; 
                                                    display: flex; align-items: center; justify-content: center; margin: auto;">
                                                    <i class="fas fa-user" style="color: #ffffff; font-size: 24px;"></i>
                                                </div>
                                                <h6 style="margin-top: 13px; color: #000000;">Tim Legal</h6>
                                                <div>${data.approve_status == '3' ? data.statusAlias.status : 'Menunggu Persetujuan'}</div>
                                                <div>${data.updated_at}</div>
                                            </div>

                                            <!-- Garis Horizontal -->
                                            <div style="flex-grow: 1; height: 1px; background-color: #018797; margin: 1%;"></div>

                                            <!-- Wadir 4 -->
                                            <div>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; 
                                                    background-color: 
                                                        ${data.approve_status == '3' ? '#ffc107' : (data.approve_status == '4' ? '#66BB6A' : '#66BB6A')}; 
                                                    display: flex; align-items: center; justify-content: center; margin: auto;">
                                                    <i class="fas fa-user" style="color: #ffffff; font-size: 24px;"></i>
                                                </div>
                                                <h6 style="margin-top: 13px; color: #000000;">wadir 4</h6>
                                                <div>${data.approve_status == '3' ? data.statusAlias.status : 'Menunggu Persetujuan'}</div>
                                                <div>${data.updated_at}</div>
                                            </div>

                                            <!-- Garis Horizontal -->
                                            <div style="flex-grow: 1; height: 1px; background-color: #018797; margin: 1%;"></div>


                                            <!-- Selesai Direview -->
                                            <div>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; 
                                                    background-color: ${data.approve_status == '4' ? '#66BB6A' : '#66BB6A'}; 
                                                    display: flex; align-items: center; justify-content: center; margin: auto;">
                                                    <i class="fas fa-check-circle" style="color: #ffffff; font-size: 24px;"></i>
                                                </div>
                                                <h6 style="margin-top: 13px; color: #000000;">Selesai Review</h6>
                                                <div>${data.approve_status == '4' ? data.statusAlias.status : ''}</div>
                                                <div>${data.updated_at}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {
                        $('#response').empty();
                        $('#response').html("<p class='text-danger'>No data found.</p>");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        'title': status.toUpperCase(),
                        'text': 'Data Tidak Ditemukan',
                        'icon': 'error'
                    });
                }
            });
        });
    });
</script>
@endsection
@endsection
