jQuery(document).on('submit', "#documents-form", function (event) {jQuery.pjax.submit(event, '#documents', {"push":false, "timeout":1000});});

$(document).ready(function() {
    $("body").on("change", '#document-files-widget', function() {
        var fileSize = document.getElementById('document-files-widget').files[0].size;

        if (fileSize > 5242880) {
            alert('Max file size is 5 Mb');
            $("#document-files-widget").val('');
        }
    })
})