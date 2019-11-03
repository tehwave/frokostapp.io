require('./bootstrap');

$('form').submit(function(e) {
    $(this).find('[type="submit"]')
        .html('<span><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading</span></span>')
        .attr('disabled', 'disabled')
        .addClass('disabled');
});
