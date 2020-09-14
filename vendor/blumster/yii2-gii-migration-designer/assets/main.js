jQuery(function($) {
    var $templateCont = $('#template-container');

    function initHintBlocks() {
        $('.hint-block').each(function () {
            var $hint = $(this);
            if ($hint.parent().find('label').hasClass('help')) {
                return;
            }

            $hint.parent().find('label').addClass('help').popover({
                html: true,
                trigger: 'hover',
                placement: 'right',
                content: $hint.html()
            });
        });
    }

    $(document).on('click', '.btn-table-collapse', function(e) {
        e.preventDefault();
    });

    $(document).on('click', '.btn-add-table', function(e) {
        e.preventDefault();

        var $destCont = $('.table-container');
        var $badgeCont = $('#table-badge');

        $destCont.append($templateCont.data('table-template').replace(new RegExp('{{i}}', 'g'), $destCont.find('tr.table-form:last-child').data('i') === undefined ? 0 : $destCont.find('tr.table-form:last-child').data('i') + 1));
        $badgeCont.html(parseInt($badgeCont.html()) + 1).removeClass('hidden');

        initHintBlocks();
    });

    $(document).on('click', '.btn-remove-table', function(e) {
        e.preventDefault();

        $(this).closest('tr').remove();

        var $badgeCont = $('#table-badge');

        var count = parseInt($badgeCont.html());
        if (count == 1) {
            $badgeCont.addClass('hidden');
        }

        $badgeCont.html(parseInt($badgeCont.html()) - 1);
    });

    $(document).on('click', '.btn-add-column', function(e) {
        e.preventDefault();

        var $destCont = $(this).closest('table').find('.column-container');

        $destCont.append($templateCont.data('column-template').replace(new RegExp('{{i}}', 'g'), $(this).closest('tr.table-form').data('i')).replace(new RegExp('{{c}}', 'g'), $destCont.find('tr.column-form:last-child').data('c') === undefined ? 0 : $destCont.find('tr.column-form:last-child').data('c') + 1));

        initHintBlocks();
    });

    $(document).on('click', '.btn-remove-column', function(e) {
        e.preventDefault();

        var $destCont = $(this).closest('.column-container');
        var addNew = $destCont.find('tr').length === 1;

        $(this).closest('tr').remove();

        if (addNew) {
            $destCont.append($templateCont.data('column-template').replace(new RegExp('{{i}}', 'g'), $(this).closest('tr.table-form').data('i')).replace(new RegExp('{{c}}', 'g'), $destCont.find('tr.column-form:last-child').data('c') === undefined ? 0 : $destCont.find('tr.column-form:last-child').data('c') + 1));

            initHintBlocks();
        }
    });

    $(document).on('click', '.btn-add-index', function(e) {
        e.preventDefault();

        var $destCont = $('.index-container');
        var $badgeCont = $('#index-badge');

        $destCont.append($templateCont.data('index-template').replace(new RegExp('{{i}}', 'g'), $destCont.find('tr.index-form:last-child').data('i') === undefined ? 0 : $destCont.find('tr.index-form:last-child').data('i') + 1));
        $badgeCont.html(parseInt($badgeCont.html()) + 1).removeClass('hidden');

        initHintBlocks();
    });

    $(document).on('click', '.btn-remove-index', function(e) {
        e.preventDefault();

        $(this).closest('tr').remove();

        var $badgeCont = $('#index-badge');

        var count = parseInt($badgeCont.html());
        if (count == 1) {
            $badgeCont.addClass('hidden');
        }

        $badgeCont.html(parseInt($badgeCont.html()) - 1);
    });

    $(document).on('click', '.btn-add-foreign-key', function(e) {
        e.preventDefault();

        var $destCont = $('.foreign-key-container');
        var $badgeCont = $('#foreign-key-badge');

        $destCont.append($templateCont.data('foreign-key-template').replace(new RegExp('{{i}}', 'g'), $destCont.find('tr.foreign-key-form:last-child').data('i') === undefined ? 0 : $destCont.find('tr.foreign-key-form:last-child').data('i') + 1));
        $badgeCont.html(parseInt($badgeCont.html()) + 1).removeClass('hidden');

        initHintBlocks();
    });

    $(document).on('click', '.btn-remove-foreign-key', function(e) {
        e.preventDefault();

        $(this).closest('tr').remove();

        var $badgeCont = $('#foreign-key-badge');

        var count = parseInt($badgeCont.html());
        if (count == 1) {
            $badgeCont.addClass('hidden');
        }

        $badgeCont.html(parseInt($badgeCont.html()) - 1);
    });
});
