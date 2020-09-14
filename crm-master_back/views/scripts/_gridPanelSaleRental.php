<?php
use yii\web\View;
use yii\helpers\Url;
$getResponsiblesItemUrl = Url::to(['/task-manager/get-responsible-item']);
$msgEnterEmail = Yii::t('app', 'Enter email');

$script = <<<JS
$(document).ready(function() {
    var urlMakePublished             = "$urlMakePublished";
    var urlMakeUnPublished           = "$urlMakeUnPublished";
    var urlBulkUpdate                = "$urlBulkUpdate";
    var locations                    = $locations;
    var subLocations                 = $subLocations;
    var urlDownloadListingAsPdfTable = "$urlDownloadListingAsPdfTable";
    var urlGeneratePoster            = "$urlGeneratePoster";
    var urlGenerateBrochure          = "$urlGenerateBrochure";
    var urlGetContact                = "$urlGetContact";
    var urlGetLead                   = "$urlGetLead";
    var urlSharePreviewLinks         = "$urlSharePreviewLinks";
    var urlShareBrochure             = "$urlShareBrochure";
    var msgEnterEmail                = "$msgEnterEmail";

    $('body').on('click', '#grid-redirect-to-owner-page', function() {
        var countChecked = $('.check-column-in-grid:checked').length;
        var items        = [];

        if (countChecked == 1) {
            window.open($('.check-column-in-grid:checked').attr('data-owner-url'), '_blank');
        } else {
            $('.check-column-in-grid:checked').each(function() {
                items.push($(this).val());
            })
            $.ajax({
                    url: '$urlGetListOwners',
                    type: 'POST',
                    data: {
                        items: JSON.stringify(items)
                    },
                    beforeSend: function() {
                        startLoadingProcess();
                    },
                    complete: function() {
                        finishLoadingProcess();
                    },
                    success: function(response) {
                        bootbox.alert(response);
                    }
                })
        }

        return false;
    })

    $("body").on("click", "#btn-send-brochure", function() {
        var email = $("#share-options-set-email").val();
        var items = [];

        $(".check-column-in-grid:checked").each(function() {
            items.push($(this).attr("data-ref"));
        })

        if (!email) {
            alert(msgEnterEmail);
            return false;
        }

        $.ajax({
            url: "$urlShareBrochure",
            data: {
                email: email,
                items: JSON.stringify(items)
            },
            type: 'post',
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(data) {
                 alert(data.msg);
            },
            complete: function() {
                finishLoadingProcess();
            }
        })
    })

    $("body").on("click", "#btn-share-links", function() {
        var email = $("#share-options-set-email").val();
        var items = [];

        $(".check-column-in-grid:checked").each(function() {
            items.push($(this).attr("data-ref"));
        })

        if (!email) {
            alert(msgEnterEmail);
            return false;
        }

        $.ajax({
            url: '$urlSharePreviewLinks',
            type: 'POST',
            data: {
                email: email,
                items: JSON.stringify(items)
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(data) {
                alert(data.msg);
            },
            complete: function() {
                finishLoadingProcess();
            }
        });
    })

    $("body").on("click", ".share-options-check-lead", function() {
        var val = $(this).val();

        $.ajax({
            url: '$urlGetLead',
            type: 'POST',
            data: {
                ref: val
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(data) {
                $("#share-options-set-email").val(data.email);
            },
            complete: function() {
                finishLoadingProcess();
            }
        });
    })

    $("body").on("click", ".share-options-check-contact", function() {
        var val = $(this).val();

        $.ajax({
            url: '$urlGetContact',
            type: 'POST',
            data: {
                ref: val
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(data) {
                if (data.personal_email) {
                     $("#share-options-set-email").val(data.personal_email);
                } else if (data.other_email) {
                     $("#share-options-set-email").val(data.other_email);
                } else if (data.work_email) {
                     $("#share-options-set-email").val(data.work_email);
                }
            },
            complete: function() {
                finishLoadingProcess();
            }
        });
    })

    $("body").on("click", "#btn-submit-advanced-search", function() {
        $.ajax({
            type: 'post',
            url: $("#advanced-search-form").attr('action') + "?" + $("#advanced-search-form").serialize(),
            success: function(xml, textStatus, xhr) {
                if (xhr.status == 200) {
                    $(".tab-pane-grid.active").find(".replace-grid-listing").html(xml);
                    $("#modal-advanced-search").modal('hide');
                }
            }
        })

        return false;
    })

    $("body").on("click", "#unarchive-items", function() {
        var checked   = [];
        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.pjax({
                type       : 'POST',
                url        : '$urlUnArchive',
                container  : '#result',
                data       : {
                    items: JSON.stringify(checked)
                },
                push       : false,
                scrollTo   : false
                //replace    : false,
                //timeout    : 10000
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#open-pending-listings", function() {
        $.pjax({
            type       : 'POST',
            url        : '$urlGridPanelPending',
            container  : '#pjax-grid-panel',
            data       : {},
            push       : false,
            scrollTo   : false
            //replace    : false,
            //timeout    : 10000,
        })
    })

    $("body").on("click", "#open-current-listings", function() {
        $.pjax({
            type       : 'POST',
            url        : '$urlGridPanelCurrent',
            container  : '#pjax-grid-panel',
            data       : {},
            push       : false,
            scrollTo   : false
            //replace    : false,
            //timeout    : 10000,
        })
    })

    $("body").on("click", "#open-archived-listings", function() {
         $.pjax({
            type       : 'POST',
            url        : '$urlGridPanelArchive',
            container  : '#pjax-grid-panel',
            data       : {},
            push       : false,
            scrollTo   : false
            //replace    : false,
            //timeout    : 10000,
        })
    })

    function syncResponsibiles() {
        var responsiblesId, responsiblesIds = [];
        $('#choosed-responsibles-list li').each(function( index ) {
          responsiblesId = $(this).data('id');
              if (responsiblesId)
                responsiblesIds.push(responsiblesId);
        });
        responsiblesIds = JSON.stringify(responsiblesIds);
        if ( responsiblesIds != '[]' ) {
            // $('.field-taskmanager-responsible .help-block').hide();
            $('#taskmanager-responsible').val(responsiblesIds);
        }
        else
            $('#taskmanager-responsible').val('');
    }

    $('.add-responsibles').on('click', function() {
        var responsiblesId, responsiblesIdsJson;
        var responsiblesIds = [];
        $('#users-gridview input[type="checkbox"]').each(function( index ) {
          if( $( this ).prop('checked') ) {
              responsiblesId = $( this ).closest('tr').data('key');
              if (responsiblesId) {
                  var isResponsiblesUnique = true;
                  $('#choosed-responsibles-list li').each(function( index ) {
                      if ($(this).data('id') == responsiblesId)
                          isResponsiblesUnique = false;
                   });
                  if (isResponsiblesUnique)
                      responsiblesIds.push(responsiblesId);
              }
          }
        });
        responsiblesIdsJson = JSON.stringify(responsiblesIds);
        $.post("$getResponsiblesItemUrl", {responsiblesIds: responsiblesIdsJson}, function(data, status){
            $('#choosed-responsibles-list').append(data);
            syncResponsibiles();
        });

        $('#users-modal').modal('hide');
        return false;
    });

    $("#choosed-responsibles-list").on("click",".remove-responsibles-item", function(){
        $(this).closest('li').remove();
         syncResponsibiles();
        return false;
    });

    $('.open-users-gridview').on('click', function() {
        $('#users-modal').modal('show');
        return false;
    });

    $("body").on("click", "#btnCreateToDoForItem", function() {
        $.ajax({
            type: 'post',
            url: $("#formAddToDoItem").attr('action'),
            data: $("#formAddToDoItem").serialize(),
            success: function(xml, textStatus, xhr) {
                if (xhr.status == 200)
                    location.reload();
            }
        })

        return false;
    })

    $("body").on("click", "#btnCreateLeadForItem", function() {
        $.ajax({
            type: 'post',
            url: $("#formAddLeadForItem").attr('action'),
            data: $("#formAddLeadForItem").serialize(),
            success: function(xml, textStatus, xhr) {
                if (xhr.status == 200)
                    location.reload();
            }
        });

        return false;
    });
    
    $("body").on("click", "#btnCreateDealForItem", function() {
        startLoadingProcess();
        var form = $("#formAddDealForItem");
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(xml, textStatus, xhr) {
                if (xhr.status == 200) {
                    location.reload();
                }
                finishLoadingProcess();
            }
        });

        return false;
    });

    $("body").on("click", "#toggleActions", function() {
        $("#dropdown-actions").toggle();

        return false;
    })

    $("body").on("click", "#toggleView", function() {
        $("#dropdown-views").toggle();

        return false;
    })

    $("body").on("click", "#toggleShareOptions", function() {
        var checked   = [];
        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $("#shareOptionsBox").fadeIn();
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#submitBulkUpdate", function() {
        var targetId  = $("#selectField option:selected").attr("data-target-id");
        var attribute = $("#selectField option:selected").attr("data-attribute");
        var val       = $("#selectField option:selected").val();
        var checked   = [];
        var newValue  = $("#" + targetId).val();

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (val == -1) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: urlBulkUpdate,
            data: {
                items: JSON.stringify(checked),
                attribute: attribute,
                newValue: newValue,
                emirate: $("#emiratesSelect").val(),
                location: $("#locationsSelect").val(),
                subLocation: $("#subLocationsSelect").val(),
                page: '$page'
            },
            success: function(response) {}
        })
    })

    $("body").on("change", "#selectField", function() {
        $(".add-display-none").addClass('display-none');
        var targetId = $("#selectField option:selected").attr("data-target-id");
        var targetDescription = $("#selectField option:selected").attr("data-target-description");

        $("#" + targetId).removeClass('display-none');
        $("#" + targetDescription).removeClass('display-none');
    })

    $("body").on("click", "#emiratesSelect", function() {
        var val = $('#emiratesSelect option:selected').val();
        $('#locationsSelect').find('option').not(':first').remove();
        $('#subLocationsSelect').find('option').not(':first').remove();

        if (val > 0) {
            $("#locationsSelect").removeAttr('disabled');
            var emirateLocations = locations[val];
            for (var i = 0; i < emirateLocations.length; i++) {
                $('#locationsSelect').append($('<option>', {
                    value: emirateLocations[i].id,
                    text : emirateLocations[i].name
                }));
            }
        } else {
            $("#locationsSelect").attr('disabled', true);
            $("#subLocationsSelect").attr('disabled', true);
        }
    })

    $("body").on("click", "#locationsSelect", function() {
         var val = $(this).val();
         $('#subLocationsSelect').find('option').not(':first').remove();

        if (val > 0) {
            $("#subLocationsSelect").removeAttr('disabled');
            var subLocationData = subLocations[val];
            for (var i = 0; i < subLocationData.length; i++) {
                $('#subLocationsSelect').append($('<option>', {
                    value: subLocationData[i].id,
                    text : subLocationData[i].name
                }));
            }
        } else {
            $("#subLocationsSelect").attr('disabled', true);
        }
    })

    $("body").on("click", "#bulkUpdate", function() {
        var checked = [];

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $("#modal-bulk-update").modal('show');
            $("#countRecordToUpdate").html(checked.length);
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#download-listing-as-pdf-table", function() {
        var checked = [];

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.ajax({
                async: true,
                type: 'post',
                url: urlDownloadListingAsPdfTable,
                data: {
                    items: JSON.stringify(checked),
                    flagListing: $("#flag-listing").val()
                },
                beforeSend: function() {
                    startLoadingProcess();
                },
                success: function(response) {
                    $("#modal-download-pdf").modal('show');
                    $("#link-download-pdf").prop('href', response.url);
                }
            }).always(function() {
                finishLoadingProcess();
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#link-download-brochure", function() {
        var checked = [];

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.ajax({
                async: true,
                type: 'post',
                url: urlGenerateBrochure,
                data: {
                    items: JSON.stringify(checked),
                    flagListing: $("#flag-listing").val(),
                    agentDetails: $("input[name='agent-brochure-to-generate']:checked").val()
                },
                beforeSend: function() {
                    startLoadingProcess();
                },
                success: function(response) {
                      location.href = response.url;
                }
            }).always(function() {
                finishLoadingProcess();
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#link-download-poster", function() {
        var checked = [];

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.ajax({
                async: true,
                type: 'post',
                url: urlGeneratePoster,
                data: {
                    items: JSON.stringify(checked),
                    flagListing: $("#flag-listing").val(),
                    agentDetails: $("input[name='agent-details-to-generate']:checked").val()
                },
                beforeSend: function() {
                    startLoadingProcess();
                },
                success: function(response) {
                      location.href = response.url;
                }
            }).always(function() {
                finishLoadingProcess();
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#unPublishRecords", function() {
        var checked = [];

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.ajax({
                type: 'post',
                url: urlMakeUnPublished,
                data: {
                    items: JSON.stringify(checked),
                    flagListing: $("#flag-listing").val()
                },
                success: function(response) {}
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#publishRecords", function() {
        var checked = [];

        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.ajax({
                type: 'post',
                url: urlMakePublished,
                data: {
                    items: JSON.stringify(checked),
                    flagListing: $("#flag-listing").val()
                },
                success: function(response) {}
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })
})
JS;

$this->registerJs($script, View::POS_READY);
