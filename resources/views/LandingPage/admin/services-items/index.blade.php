@extends('layouts.app')
@section('core-css')
@endsection
@section('vendor-css')
@endsection
@section('helper-js')
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render() }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0">{{ $title }}</h5>
            <a href="{{ route('create-services-items') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Items
            </a>
        </div>

        <div class="card-body">
            <table id="servicesTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Pin</th>
                        <th>Created At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- 🔍 Modal Detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detailModalLabel">Detail Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="detailContent" class="p-3">
                        <p><strong>Judul:</strong> <span id="detailTitle"></span></p>
                        <p><strong>Deskripsi Singkat:</strong> <span id="detailShortDesc"></span></p>
                        <p><strong>Deskripsi:</strong></p>
                        <div id="detailDesc"></div>
                        <div class="mt-3">
                            <img id="detailImage" src="" class="img-fluid rounded" style="max-height: 250px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @vite(['resources/js/LandingPage/admin/services-items/index.js'])
    <script>
        // 🔍 Lihat Detail
        $(document).on('click', '.detail', function() {
            const id = $(this).data('id');

            const url = "{{ route('show-services-items', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    $('#detailTitle').text(res.title);
                    $('#detailShortDesc').text(res.short_description ?? '-');
                    $('#detailDesc').html(res.description ?? '-');
                    $('#detailImage').attr('src', res.image ? '/storage/' + res.image :
                        '/assets/no-image.png');
                    $('#detailModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire('Gagal!', xhr.responseJSON?.message ||
                        'Tidak dapat mengambil detail data.', 'error');
                }
            });
        });
    </script>
@endsection
