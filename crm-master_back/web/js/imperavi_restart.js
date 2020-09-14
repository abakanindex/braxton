$(document).ready(function() {
    $('#modal-marketing-media-more-info').on('shown.bs.modal', function (e) {
        $('#marketing-media-description').redactor('core.destroy');
        $('#marketing-media-description').redactor({
            'lang'   : 'en',
            'buttons': ['link']
        });
    });

    $('#modal-add-to-do').on('shown.bs.modal', function (e) {
        $('#task-manager-description').redactor('core.destroy');
        $('#task-manager-description').redactor({
            'lang'   : 'en',
            'buttons': ['link']
        });
    })
});