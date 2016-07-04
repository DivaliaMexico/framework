/**
 * Created by DWIsprananda on 5/24/2016.
 */
$(function () {
    $('#btn_get_users').bind('click', function () {
        process = true;

        $.ajax({
            url: App.get_users_url,
            type: "POST",
            success: function(data) {
                $('#user_list').html(data);
                $('#box-user_list').modal('show');
                process = false;
            }
        });

    });
});