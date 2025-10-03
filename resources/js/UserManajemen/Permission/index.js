"use strict";

$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let table = $("#permission-table").DataTable({
        pageLength: 10,
        fixedHeader: true,
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: `${baseUrl}/akun/permission/`,
        },
        columns: [{
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: 'text-center',
            orderable: false,
        },
        {
            data: "action",
            name: "action",
            className: 'text-left',
            orderable: false,
            searchable: false,
        },
        {
            data: "name",
            name: "name",
            className: 'text-left',
        },
        {
            data: "guard",
            name: "guard",
            className: 'text-left',
        },
        {
            data: "created_at",
            name: "created_at",
            className: 'text-left',
        },
        {
            data: "updated_at",
            name: "updated_at",
            className: 'text-left',
        },
        ],
        drawCallback: function (settings) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });

    $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
        console.log(message);
    };

    $(document).on("click", ".editPermission", function () {
        let id = $(this).data("id");
        let formAction = `${baseUrl}/akun/permission/${id}`;
        $.get(`${baseUrl}/akun/permission/${id}/edit`, function (response) {
            if (response && response.data && response.guard) {
                $('#namePermission').val(response.data.name);
                $('#guardId').empty().append(`<option value="" disabled selected>${$('#guardId').data('placeholder')}</option>`);
                response.guard.forEach(value => {
                    $('#guardId').append(`<option value="${value}" ${response.data.guard_name === value ? 'selected' : ''}>${value}</option>`);
                });

                $('#guardId').trigger('change');
                $("#editPermissionForm").attr("action", formAction);
                $("#editPermissionModal").modal("show");
            } else {
                console.error("Invalid response structure", response);
                alert("Failed to load permission data. Please try again.");
            }
        }).fail(function () {
            alert("An error occurred while fetching the permission data.");
        });
    });

    $('body').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        let nama = $(this).data("nama");
        let url = $(this).data("url");
        Swal.fire({
            title: 'Anda Yakin?',
            text: `Apakah anda yakin ingin menghapus data ${nama}?`,
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: 'Ya',
            denyButtonText: 'Batal',
            allowOutsideClick: false
        }).then(result => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function (data) {
                        toastr['success'](`Berhasil Menghapus Data ${nama}`, 'Berhasil!', {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                        });
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        })
    });
});

$(document).ready(function () {
    $('body').on('click', '.btn-show', function () {
        const id = $(this).data('id');

        $.ajax({
            url: `${baseUrl}/akun/permission/detail/${id}`,
            type: 'GET',
            success: function (res) {
                $('#detail-nama').text(res.name ?? '-');
                $('#detail-gn').text(res.guard_name ?? '-');

                let timelineHtml = '';
                res.logs.forEach(function (log) {
                    let label = log.flag?.label ?? 'info';
                    let namaFlag = log.flag?.nama ?? '-';
                    let deskripsi = log.deskripsi ?? '-';
                    let namaUser = log.nama ?? 'Sistem';
                    let waktu = new Date(log.created_at).toLocaleString('id-ID', {
                        day: '2-digit', month: 'long', year: 'numeric',
                        hour: '2-digit', minute: '2-digit'
                    });

                    timelineHtml += `
                        <li class="timeline-item">
                            <span class="timeline-point timeline-point-${label}"></span>
                            <div class="timeline-event">
                                <div class="timeline-header border-bottom mb-2">
                                    <h6 class="mb-0">${namaFlag}</h6>
                                </div>
                                <p class="mb-1">${deskripsi}</p>
                                <small class="text-muted">Oleh: ${namaUser}<br>Pada: ${waktu}</small>
                            </div>
                        </li>`;
                });

                $('#timeline-permission').html(timelineHtml);
                $('#detailLogModal').modal('show');
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                toastr.error('Gagal memuat detail data');
            }
        });
    });
});
