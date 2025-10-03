<div class="content-header row">
    @if (count($breadcrumbs))
        <div class="content-header-left col-12 mb-3">
            <div class="breadcrumbs-top">
                <div class="d-flex flex-column flex-lg-row justify-content-start">
                    <h3 class="content-header-title mb-0 me-4">{{ $breadcrumbs->last()->title }}</h3>
                    <div class="breadcrumb-wrapper mt-2">
                        <ol class="breadcrumb">
                            @foreach ($breadcrumbs as $breadcrumb)
                                @if ($breadcrumb->url && !$loop->last)
                                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}"
                                            id="breadcrumbs-active-hover"
                                            style="transition: .3s ease">{{ $breadcrumb->title }}</a></li>
                                @else
                                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
