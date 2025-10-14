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
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-feature')) {
            const featureItems = container.querySelectorAll('.feature-item');
            if (featureItems.length > 1) {
                e.target.closest('.feature-item').remove();
                updateFeatureNumbers();
            } else {
                alert('Minimal harus ada 1 feature');
            }
        }
    });

    // Inisialisasi nomor feature pertama kali
    updateFeatureNumbers();
});