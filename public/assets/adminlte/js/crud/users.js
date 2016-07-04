/**
 * Created by DWIsprananda on 5/4/2016.
 */

$(function () {

    App.beforeSubmit = function() {
        if ($('#password').val() != $('#conf_password').val()) {
            sweetAlert("Passwords do not matched", "Password and Confirm Password is not same", "warning");

            return false;
        }
    }

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
})