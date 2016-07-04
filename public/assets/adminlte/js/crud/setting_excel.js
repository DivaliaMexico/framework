/**
 * Created by DWIsprananda on 5/23/2016.
 */

$(function () {
    App.afterView = function(data) {
        var container = $('#box-view').find('.modal-body').find('.well');
        if (container.find('#column-set').length > 0) {
            container.find('#column-set').remove();
        }
        container.append(data.detail);
    };
});