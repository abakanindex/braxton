$(document).ready(function() {
    $(document).on('pjax:success', function(e) {
        if (e.relatedTarget.className == "view-contact") {
            $("html, body").animate({ scrollTop: 0 }, 1000);
        }
    })
})