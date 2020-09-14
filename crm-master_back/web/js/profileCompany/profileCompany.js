$(document).ready(function() {

    $('#result').on('click', ".kv-preview-thumb .kv-file-remove", function() {
        var that = $(this);
        $.ajax({
            url: '/web/profileCompany/profile-company/drop-img',
            type: 'POST',
            data: {
                companyId : $('input[name=companyId]').val(),
                typeImage : that.closest('.profile-company-input-block').attr('data-type')
            },
            success: function(){
            },
            error: function(){
            }
        });

        that.closest('.kv-preview-thumb').remove();
    });

});
