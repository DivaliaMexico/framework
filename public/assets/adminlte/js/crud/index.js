/**
 * Created by dnaextrim on 3/25/2016.
 */

var checkstatus = false;

App.beforeSubmit(function () {
    $('#today_priorities').val(CKEDITOR.instances.today_priorities.getData());
    $('#today_bottleneck').val(CKEDITOR.instances.today_bottleneck.getData());
    $('#operation_topics').val(CKEDITOR.instances.operation_topics.getData());
    $('#middle_terms').val(CKEDITOR.instances.middle_terms.getData());
    $('#long_terms').val(CKEDITOR.instances.long_terms.getData());
    return true;
});

$(function () {
    $('#date').datepicker().on('changeDate', function (ev) {
        process = true;
        $.ajax({
            url: App.read_url,
            data: {
                date: $(this).val()
            },
            type: 'POST',
            dataType: "json",
            success: function (data) {
                $('#subject').val(data.title);
                CKEDITOR.instances.today_priorities.setData(data.today_priorities);
                CKEDITOR.instances.today_bottleneck.setData(data.today_bottleneck);
                CKEDITOR.instances.operation_topics.setData(data.operation_topics);
                CKEDITOR.instances.middle_terms.setData(data.middle_terms);
                CKEDITOR.instances.long_terms.setData(data.long_terms);
                process = false;
            }
        })
    });

    $('#table_file').dataTable({
        'sDom': '<"top"f>rt<"bottom"p><"clear">',
        // 'iDisplayLength': 20,
        // "order": [[1, "desc"]],
        /*"columnDefs": [
            {"targets": [0], "className": "text-center"},
        ]*/
    });

    $('#btn-sendmail').bind('click', function () {
        process = true;
        $.ajax({
            url: App.sendmail_url,
            data: {
                date: $('#date').val(),
                subject: $('#subject').val(),
                today_priorities: CKEDITOR.instances.today_priorities.getData(),
                today_bottleneck: CKEDITOR.instances.today_bottleneck.getData(),
                operation_topics: CKEDITOR.instances.operation_topics.getData(),
                middle_terms: CKEDITOR.instances.middle_terms.getData(),
                long_terms: CKEDITOR.instances.long_terms.getData(),
            },
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status !== 'OK') {
                    sweetAlert('Error', data.message, 'error');
                } else {
                    sweetAlert('Success', 'Email sent', 'success');
                }

                process = false;
            }
        });
    });

    $('a.excelfile').on('click', function (event) {
        event.preventDefault();

        if ($('#date').val() == '') {
            sweetAlert({
                title: 'Warning',
                text: 'Please select a date',
                type: 'warning'
            }, function () {
                $('#date').focus();
            });

            return false;
        }

        $('#view-excel').modal('show');

        $('#file-container').html('<i class="fa fa-2x fa-spinner fa-spin"></i> Loading');

        $.ajax({
            url: $(this).attr('href'),
            data: {'date': $('#date').val()},
            type: "POST",
            // dataType: "json",
            success: function (data) {
                $('#file-container').html(data);
            },
            error: function () {
                $('#view-excel').modal('hide');
                sweetAlert("Failed read!", "Failed read excel file", "error");
            }
        });

    });

    $('.collapse').collapse();

    $('a[data-toggle=collapse]').on('click', function () {
        var arrow = $(this).find('i');
        if ($($(this).attr('href')).hasClass('in')) {
            arrow.switchClass('fa-chevron-circle-up', 'fa-chevron-circle-down');
        } else {
            arrow.switchClass('fa-chevron-circle-down', 'fa-chevron-circle-up');
        }

    })
});
