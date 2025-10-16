"use strict";

$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let table = $('#servicesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `${baseUrl}/services-items/`,
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            width: '5%'
        },
        {
            data: 'title',
            name: 'title'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'pin',
            name: 'pin'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'aksi',
            name: 'aksi',
            orderable: false,
            searchable: false,
            width: '15%'
        }
        ]
    });


    // 🗑️ Hapus Data
    $(document).on('click', '.delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.services.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (res) {
                        Swal.fire('Berhasil!', res.message, 'success');
                        table.ajax.reload();
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    });
});
