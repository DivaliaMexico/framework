/**
 * Created by DWIsprananda on 5/25/2016.
 */
var migrate_status = false;

$(function () {
    $('#btn-migrate').bind('click', function (event) {
        $.ajax({
            url: App.migrate_url,
            data: {
                month: $('#month').val(),
                year: $('#year').val()
            },
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                getProgress(data.session_id);
            }
        })
    });
    
    function getProgress(sid) {

        setTimeout(function() {
            $.ajax({
                url: App.migrate_progress_url,
                data: {

                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    if (migrate_status) {
                        getProgress(sid);
                    }

                    if (data.progress >= 100) {
                        migrate_status = false;
                    }
                }
            });
        }, 1000);

    }


});
