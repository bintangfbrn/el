@props(['id', 'title', 'action' => '#', 'formId' => 'form', 'disable' => ''])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="{{ $formId }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{ $slot }}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btnSimpanModal"
                        class="btn btn-primary {{ $disable }}">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
