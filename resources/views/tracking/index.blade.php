@extends('layouts.app')
@section('heading', 'Track Kerjasama')
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <div class="row">
                    <div class="order-md-0 order-1 col-12 col-md-8">
                        <h4>Track Persetujuan</h4>
                    </div>
                    <form id="trackForm">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="tracker_id">Cari Pengajuan<span class="text-danger"></span></label>
                                    <input type="text" id="tracker_id" class="form-control" name="tracker_id" required>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-1">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="response" class="mt-3">
                    <div class="row">


                    </div>
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
                 url: '{{ url("api/track") }}/' + trackerId,
                 type: 'GET',
                success: function(response) {
        if (response.message === "success") {
            console.log(response.data[0]);
            const data = response.data[0]
            $('#response').empty();
            $('#response').append("<p>Data:</p>");
            $.each(data, function(key, value) {
                $('#response').append(`
                    <div class="form-group mb-2">
                        <label for="${key}">${key}</label>
                         <input type="text" class="form-control" id="${key}" value="${value}" readonly>
                    </div>
                `);
            });


        } else {
            $('#response').html("<p class='text-danger'>No data found.</p>");
        }
    },
    error: function(xhr, status, error) {
        Swal.fire({
            'title': status.toUpperCase(),
            'text': error.toUpperCase(),
            'icon'  : 'error'
        })
    }
});
        });
    });
</script>
@endsection
@endsection

