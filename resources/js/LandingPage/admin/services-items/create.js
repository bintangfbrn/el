$(document).ready(function () {

    $('select[name="pin"], select[name="status"]').select2({
        width: '100%'
    });

    $('#btn_loading').hide();

    $('form').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let isValid = true;
        const maxSize = 5 * 1024 * 1024; // 5MB
        $('.is-invalid, .is-valid').removeClass('is-invalid is-valid');

        $('[required]').each(function () {
            const input = $(this);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.addClass('is-valid');
            }
        });

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

        if (!isValid) {
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
            return false;
        }

        Swal.fire({
            title: 'Yakin ingin menyimpan artikel ini?',
            text: "Pastikan semua data sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#btn_loading').removeAttr('hidden').show();
                $('button[type="submit"]').hide();

                // Submit form
                form.submit();
            }
        });
    });
});
