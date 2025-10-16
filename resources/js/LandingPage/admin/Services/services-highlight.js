"use strict";

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('features-container');
    const addBtn = document.getElementById('add-feature');

    // Function untuk mengupdate nomor feature
    function updateFeatureNumbers() {
        const featureItems = container.querySelectorAll('.feature-item');
        featureItems.forEach((item, index) => {
            const title = item.querySelector('h6.mb-0');
            title.textContent = `Feature ${index + 1}`;

            // Update input names dengan index yang benar
            const inputs = item.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/features\[\d+\]/, `features[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    addBtn.addEventListener('click', function () {
        const index = container.querySelectorAll('.feature-item').length;
        const html = `
        <div class="card mb-3 feature-item">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Feature ${index + 1}</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-feature">Remove</button>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Icon (Upload Gambar)</label>
                        <input type="file" name="features[${index}][icon]" class="form-control feature-icon" accept="image/*">
                        <div class="preview-container mt-2" style="display:none;">
                            <img src="" alt="Preview" class="img-thumbnail" width="80">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="req">Title</label>
                        <input type="text" name="features[${index}][title]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Description</label>
                        <textarea name="features[${index}][description]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>`;

        container.insertAdjacentHTML('beforeend', html);

        toastr.success('New feature has been added successfully', 'Feature Added');
    });

    // Preview icon upload otomatis
    container.addEventListener('change', function (e) {
        if (e.target.classList.contains('feature-icon')) {
            const fileInput = e.target;
            const previewContainer = fileInput.closest('.col-md-4').querySelector('.preview-container');
            const imgTag = previewContainer.querySelector('img');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    imgTag.src = event.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                previewContainer.style.display = 'none';
                imgTag.src = '';
            }
        }
    });


    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-feature')) {
            const featureItems = container.querySelectorAll('.feature-item');
            if (featureItems.length > 1) {
                // Show Yes/No confirmation dialog before removing
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to remove this feature?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const removedItem = e.target.closest('.feature-item');
                        removedItem.remove();
                        updateFeatureNumbers();

                        toastr.success('Feature Berhasil Dihapus', 'Remove Berhasil');
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        toastr.info('Feature removal was cancelled', 'Cancelled');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot Remove',
                    text: 'Minimum must have 1 feature',

                });
            }
        }
    });

    // Inisialisasi nomor feature pertama kali
    updateFeatureNumbers();

});
