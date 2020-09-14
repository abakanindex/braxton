function startLoadingProcess() {
    $("#loading_process").addClass('show');
}

function finishLoadingProcess() {
    $("#loading_process").removeClass('show');
}

function createViewingSetData(val) {
    $("#listingRef").val(val);
    $("#listingRefLink").html(val);
}

startLoadingProcess();

$(document).ready(function() {
    finishLoadingProcess();

    $("body").on("change", ".price-for-year", function() {
        $(".price-for-year").val($(this).val());
    })

    $("body").on("click", "#deselect-portals", function() {
        ($(this).is(":checked")) ? $(".portal-item-checkbox").prop("checked", false) : $(".portal-item-checkbox").prop("checked", true);
    })

    $('body').on("click", ".full-listing-table-row td", function() {
        if (!$(this).hasClass("check-box-column"))
            location.href = $(this).closest('tr').data('url');
    });

    $("body").on("click", ".create-viewing-set-data", function() {
        createViewingSetData($(this).attr('data-ref'));
    })

    /**
     * 
     */
    $("body").on("click", ".select-assigned-to", function() {
        var username = $(this).attr("data-username");
        $("#assignedTo").val($(this).val());
        $("#change-assigned-to").val(username);
    });

    /**
     *
     */
    $('body').on('click', '.select-agent-referral', function() {
        $("#lead-agent-referral").val($(this).val());
        $("#lead-agent-referral-selected").val($(this).attr("data-username"));
    })

    /**
     * 
     */
    $("body").on("click", ".select-landlord-id", function() {
        var that = $(this);
        $("#landlordId").val(that.val());
        $("#change-landlord-id").val(that.attr("data-username"));
        $("#owner-mobile").text(that.attr("data-mobile"));
        $("#owner-email").text(that.attr("data-email"));
    });

    /**
     * 
     */
    $("body").on("click", ".close-error-box", function() {
        $(".error-box").fadeOut();
    })

    $("body").on("click", "#show-search-box", function() {
        $("#search-menu-header").toggle();
    })

    $("body").on("click", ".search-menu-item", function() {
        ($(this).hasClass("active")) ? $(this).removeClass("active") : $(this).addClass("active");
    })

    $("body").on("click", "#submit-search", function() {
        if ($(".search-menu-item.active").length == 0) {
            return false;
        } else {
            var str = "";
            $(".search-menu-item.active").each(function() {
                str += $(this).attr("data-value") + ";";
            })
            $("#search-in-objects").val(str);
        }
    })

    $("html").on("click", function(e) {
        // if the target of the click isn't the container nor a descendant of the container
        if (!$('#show-search-box').is(e.target) && $('#show-search-box').has(e.target).length === 0
            && !$('#search-menu-header').is(e.target) && $('#search-menu-header').has(e.target).length === 0) {
            $('#search-menu-header').hide();
        }
    });

    $('.modal').on('pjax:beforeSend', function () {
        startLoadingProcess();
    });

    $('.modal').on('pjax:complete', function () {
        finishLoadingProcess();
    });


});