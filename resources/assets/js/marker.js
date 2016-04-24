$(function () {
    // CONFIG
    var markerEndpoint = '/marker';


    $('body').on('click', 'a[data-marker=clear]', function (e) {
        e.preventDefault();
        var self = $(this);
        var type = self.data('marker-type');
        $.ajax({
            type: 'POST',
            url: markerEndpoint,
            dataType: 'json',
            data: {
                'clear': true,
                'type': type
            },
            success: function (data) {
                if (data.success) {
                    $('.marker-dropdown[data-marker-type=' + type + ']').html(data.dropdown);
                    $('input[data-marker=checkbox]').prop('checked', false);
                }
            }
        }).fail(function () {
            // TODO: handle failure
        });
    });
    $('body').on('change', '[data-marker=checkbox]', function (e) {
        var self = $(this);
        var type = self.data('marker-type');
        var value = self.val();
        var checked = self.is(':checked');
        var data = {
            type: type,
            value: value
        };
        data[checked ? 'add' : 'remove'] = true;
        $.ajax({
            type: 'POST',
            url: markerEndpoint,
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.success) {
                    $('.marker-dropdown[data-marker-type=' + type + ']').html(data.dropdown)
                }
            }
        }).fail(function () {
            // TODO: handle failure
        });
    });
    $('body').on('change', '[data-marker=checkbox-toggle]', function (e) {
        var self = $(this);
        var type = self.data('marker-type');
        var checked = self.is(':checked');
        var data = {
            type: type,
            values: []
        };
        data[checked ? 'add' : 'remove'] = true;
        $('input[data-marker=checkbox][data-marker-type='+type+']').prop('checked', checked).each(function (_, el) {
            data.values.push($(el).val());
        });
        $.ajax({
            type: 'POST',
            url: markerEndpoint,
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.success) {
                    $('.marker-dropdown[data-marker-type=' + type + ']').html(data.dropdown)
                }
            }
        }).fail(function () {
            // TODO: handle failure
        });
    });
});