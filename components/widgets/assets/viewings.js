jQuery(document).on('submit', "#viewings-form", function (event) {jQuery.pjax.submit(event, '#viewing-container', {"push":false, "timeout":1000});});

$(document).ready(function() {
    var modalViewingReportForm = $('#modal-viewing-report-form');

    $("body").on("click", ".radio-select-viewing-item", function() {
        var val = $(this).val();
        var full_name = $(this).attr('data-full-name');
        createViewingSetData(val);

        if (full_name)
            $("#viewingsName").val(full_name);
    })

    $("body").on("click", ".viewing-edit", function() {
        $.pjax({
            type: 'POST',
            url:  $(this).attr('href'),
            container: '#viewing-container',
            push: false,
            scrollTo: false,
            data: {}
        })

        return false;
    })

    $("body").on("click", ".new-report-for-viewing", function() {
        var url = $(this).attr('data-url');
        var id  = $(this).attr('data-id');

        $.ajax({
            type: 'POST',
            data: {
                id: id
            },
            url: url,
            success: function(response) {
                if (response) {
                    modalViewingReportForm.modal('show');
                    modalViewingReportForm.find('#modal-content').html(response);
                }
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            complete: function() {
                finishLoadingProcess()
            }
        })
    })
})