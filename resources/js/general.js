$('.select2').each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');

    let options = {}

    if ($this.data('placeholder')) {
        options.placeholder = $this.data('placeholder')
    }
    if ($this.data('hide-search')) {
        options.minimumResultsForSearch = -1
    }

    options.dropdownAutoWidth = true;
    options.width = '100%';
    options.dropdownParent = $this.parent();

    $this.select2(options)
});