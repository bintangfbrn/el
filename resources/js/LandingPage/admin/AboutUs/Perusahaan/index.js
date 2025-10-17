"use strict";

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form_about_us');
    const submitBtn = document.getElementById('submit-btn');

    if (!form || !submitBtn) return;

    submitBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const isEdit = form.dataset.isEdit === "true";
        const title = isEdit ? 'Update Data?' : 'Save Data?';
        const text = isEdit
            ? 'Are you sure you want to update company profile?'
            : 'Are you sure you want to save company profile?';

        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, ' + (isEdit ? 'Update' : 'Save'),
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
