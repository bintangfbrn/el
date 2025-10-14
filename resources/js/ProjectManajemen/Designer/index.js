"use strict";

$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let table = $('#tableDesign').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `${baseUrl}/designer/`,
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            width: '5%'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'style',
            name: 'style'
        },
        {
            data: 'estimated_cost',
            name: 'estimated_cost'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            width: '15%'
        }
        ]
    });

    // Hapus desain
    $(document).on('click', '.btn-delete', function () {
        let url = $(this).data('url');
        let nama = $(this).data('nama');
        if (confirm('Hapus desain "' + nama + '" ?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function (res) {
                    toastr.success('Berhasil menghapus desain');
                    table.ajax.reload();
                },
                error: function () {
                    toastr.error('Gagal menghapus desain');
                }
            });
        }
    });
});