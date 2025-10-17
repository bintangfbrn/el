"use strict";

$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('#perusahaanTables').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `${baseUrl}/about/AboutPerusahaan/`,
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            width: '5%'
        },
        {
            data: 'company_name',
            name: 'company_name'
        },
        {
            data: 'founded_year',
            name: 'founded_year'
        },
        {
            data: 'address',
            name: 'address'
        },
        {
            data: 'email',
            name: 'email'
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

});
