<div class="modal-body">
    <div class="row g-2">
        <div class="col-md-12">
            <label class="form-label" for="name">Name <small class="text-danger">*</small></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Ex. View_Permission"
                required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="guardName" class="form-label">Guard Name <small class="text-danger">*</small></label>
            <select id="guardName" name="guard_name" class="select2 form-select form-select-lg" data-allow-clear="true"
                data-placeholder="-Pilih Guard Name-" required>
                <option></option>
                @foreach ($guard as $gd)
                    <option value="{{ $gd->value }}">{{ strtolower($gd->name) }}</option>
                @endforeach
            </select>
            @error('guard_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
