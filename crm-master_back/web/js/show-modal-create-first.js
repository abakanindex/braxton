$(document).ready(function() {
    $('body').on('mouseenter', '#listing-widget-actions, .show-modal-create-first', function() {
        $('#modal-create-first').modal('show');
    })
})