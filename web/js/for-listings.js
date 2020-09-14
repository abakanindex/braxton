$(function () {
    'use strict';
    var changeLandlordId = $('#change-landlord-id');

    $(function () {
        changeLandlordId.after(
            '<div id="contacts-search-results" class="list-group" style="display: none; position: absolute; width: 100%; z-index: 100; height: 450px; overflow: auto;">' +
            '<a href="#" class="list-group-item list-group-item-action default">' +
            changeLandlordId.attr('search-text-default') +
            '</a>' +
            '</div>'
        );
    });

    changeLandlordId.keyup(function() {
        var that = $(this);
        var contactsSearchResults = $('#contacts-search-results');
        contactsSearchResults.hide();
        contactsSearchResults.find('.result').remove();

        if (that.val().length > 2) {
            startLoadingProcess();
            $.ajax({
                url: that.attr('data-url-search-handler'),
                data: {'text' : that.val()},
                type: 'post',
                success: function (response) {
                    if (response.success) {
                        contactsSearchResults.show();

                        if (response.models.length > 0) {
                            $.each(response.models, function(key, model) {
                                contactsSearchResults.append(
                                    '<a href="#" class="list-group-item list-group-item-action result" data-id="' + model.id + '">' +
                                    model.first_name + ' ' + model.last_name +
                                    '</a>'
                                );
                            });
                            contactsSearchResults.find('.default').hide();

                        } else {
                            contactsSearchResults.find('.default').show();
                        }
                    }
                }
            }).always(function() {finishLoadingProcess();});
        }
    });

    $('body').on("click", "#contacts-search-results .result", function() {
        var that = $(this);
        $('#contacts-search-results').hide();
        changeLandlordId.val( that.text() );
        $('#landlordId').val( that.attr('data-id') );
    });

    $(document).mouseup(function(e)
    {
        var container = $('#contacts-search-results');

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });
});
