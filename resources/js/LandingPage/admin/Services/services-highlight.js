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
                            <label>Icon (path / URL)</label>
                            <input type="text" name="features[${index}][icon]" class="form-control">
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

        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Feature Added',
            text: 'New feature has been added successfully',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
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
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const removedItem = e.target.closest('.feature-item');
                        removedItem.remove();
                        updateFeatureNumbers();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Feature has been removed successfully',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Show cancel message
                        Swal.fire({
                            icon: 'info',
                            title: 'Cancelled',
                            text: 'Feature removal was cancelled',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot Remove',
                    text: 'Minimum must have 1 feature',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            }
        }
    });

    // Inisialisasi nomor feature pertama kali
    updateFeatureNumbers();

});