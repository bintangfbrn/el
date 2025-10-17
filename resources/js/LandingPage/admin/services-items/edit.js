"use strict";

$(document).ready(function () {

    $('select[name="pin"], select[name="status"]').select2({
        width: '100%'
    });

    $('form').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let isValid = true;
        const maxSize = 5 * 1024 * 1024; // 5MB

        // Reset status validasi sebelumnya
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');

        // Validasi field required
        $('[required]').each(function () {
            const input = $(this);
            if (!input.val() || (input.is('select') && !input.val())) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.addClass('is-valid');
            }
        });

        // Validasi file upload (image & image_2)
        $('input[type="file"]').each(function () {
            const fileInput = $(this);
            const file = fileInput[0].files[0];

            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    fileInput.addClass('is-invalid');
                    Swal.fire('Format Tidak Valid', 'File harus berupa gambar (jpg, jpeg, png, webp)', 'error');
                    isValid = false;
                } else if (file.size > maxSize) {
                    fileInput.addClass('is-invalid');
                    Swal.fire('Ukuran Terlalu Besar', 'Ukuran gambar maksimal 5MB', 'error');
                    isValid = false;
                } else {
                    fileInput.addClass('is-valid');
                }
            }
        });

        // Jika tidak valid → hentikan submit
        if (!isValid) {
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
            return false;
        }

        // Konfirmasi simpan perubahan
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan semua data sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                $('#btn_loading').show();
                $('.btn-primary').prop('disabled', true);

                // Kirim form
                form.submit();
            }
        });
    });

});
