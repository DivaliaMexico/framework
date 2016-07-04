/**
 * Created by Dony Wahyu Isp (dna.extrim@gmail.com or http://github.com/dnaextrim) on 2/26/2016.
 */

if (!('App' in window)) window['App'] = {};
if (!('table' in window['App'])) window['App'].table = {};

if (typeof App.debug === 'undefined') {
    App.debug = true;
}

var process = false;

$(function () {
    /**
     * Ajax
     */
    $.ajaxSetup({
        type: "POST"
    });

    $(document).ajaxStart(function () {
        if (process == true)
            $('#loading').modal('show');
    });

    $(document).ajaxStop(function () {
        if (process == true) process = false;
        $('#loading').modal('hide');
    });

    $(document).ajaxError(function (e, x, settings, exception) {
        if (process == true) process = false;
        $('#loading').modal('hide');

        var url = settings.url;
        var method = settings.type;
        var data = settings.data;
        //var dataType = settings.dataType;

        if (exception === "timeout") {
            sweetAlert("Request Timeout", "Your Connection is too slow", "error");
        } else {
            if (exception != '') {
                if (App.debug === true) {
                    sweetAlert({
                            title: "Oops...",
                            text: exception,
                            type: "error",
                            showCancelButton: true,
                            confirmButtonText: "Debug"
                        },
                        function () {
                            App.Debug(url, method, data);
                        });
                } else {
                    sweetAlert({
                        title: "Oops...",
                        text: exception,
                        type: "error",
                    });
                }
            }
        }
    });
    //---

    /**
     * Shortcut Keys
     */
    // CTRL+N for new Data
    $(document).bind('keydown', 'Ctrl+n', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('#btn-add').trigger('click');
        return false;
    });

    $('.dataTables_filter input').bind('keydown', 'Ctrl+n', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('#btn-add').trigger('click');
        return false;
    });
    //---

    // CTRL+S for save Data
    $('#box-form form .form-control').bind('keydown', 'Ctrl+s', function (evt) {
        if ($("#box-form").is(":visible")) {
            //the add function requires an argument, so make sure to provide one.
            $('#box-form form #btn-save').trigger('click');
            return false;
        }
    });


    // CTRL+F for find data in dataTable
    $(document).bind('keydown', 'Ctrl+f', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('.dataTables_filter input').focus();
        return false;
    });

    $('.dataTables_filter input').bind('keydown', 'Ctrl+f', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('.dataTables_filter input').focus();
        return false;
    });

    $('input#search-menu').bind('keydown', 'Ctrl+f', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('.dataTables_filter input').focus();
        return false;
    });
    //---

    // CTRL+G for search menu
    $(document).bind('keydown', 'Ctrl+g', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('input#search-menu').focus();
        return false;
    });

    $('.dataTables_filter input').bind('keydown', 'Ctrl+G', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('input#search-menu').focus();
        return false;
    });

    $('input#search-menu').bind('keydown', 'Ctrl+G', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('input#search-menu').focus();
        return false;
    });
    //---


    // ESC for cancel
    $(document).bind('keydown', 'esc', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('#btn-cancel').trigger('click');
        return false;
    });

    $('#box-form form .form-control').bind('keydown', 'esc', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('#btn-cancel').trigger('click');
        return false;
    });

    $('.select2').bind('keydown', 'esc', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('#btn-cancel').trigger('click');
        return false;
    });

    $('input').bind('keydown', 'esc', function (evt) {
        //the add function requires an argument, so make sure to provide one.
        $('#btn-cancel').trigger('click');
        return false;
    });
    //---

    //---


    /**
     * Button Action
     */
    $('#btn-add').click(function (e) {
        $('form').attr('action', App.create_url);
        $('#box-form').removeClass('hidden');
        $('#box-form form .form-control:first').focus();
    });

    $('#btn-cancel').click(function (e) {
        $('.form-group').each(function (idx, el) {
            $(this).removeClass("has-error");
            $(this).children('.form-control-feedback').hide();
        });

        $('input[name*=_old]').val('');
        $('input[name=hidden]').val('');
        $('form input[type=checkbox]:checked').attr('checked', false);
        $('#box-form').addClass('hidden');
        $('.dataTables_filter input').focus();
    });
    //---

    /**
     * Feedback
     */
    $('.has-feedback .form-control').on("change", function (e) {
        var edit_status = false;

        if ($(this).val() != "" || $(this).text() != "") {
            $('input[name*=_old]').each(function (idx, el) {
                if ($(el).val() != '') {
                    edit_status = true;
                    return false;
                }
            });

            if (edit_status == true) return false;

            var form_group = $(this).parents('.form-group');
            var data = {};
            $('.has-feedback .form-control').each(function(idx, el) {
                data[$(el).prop('name')] = $(el).val();
            });


            form_group.children('.form-control-feedback').removeClass('glyphicon glyphicon-remove');
            form_group.children('.form-control-feedback').children('i').remove();
            form_group.children('.form-control-feedback').append('<i class="fa fa-refresh fa-spin"></i>');
            form_group.children('.form-control-feedback').show();

            $.ajax({
                url: App.check_url,
                data: data,
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $('.has-feedback .form-control').each(function(idx, el) {
                        if (typeof data.status !== 'undefined' && data.status != "OK") {
                            $(el).parents('.form-group').removeClass("has-error");
                            $(el).parents('.form-group').children('.form-control-feedback').hide();
                        } else {
                            $(el).parents('.form-group').addClass("has-error");
                            $(el).parents('.form-group').children('.form-control-feedback').children('i').remove();
                            $(el).parents('.form-group').children('.form-control-feedback').addClass('glyphicon glyphicon-remove');
                            $(el).parents('.form-group').children('.form-control-feedback').show();
                        }
                    });
                }
            });
        }

    });
    //---

    /**
     * Form Submit
     */
    $('form').on("submit", function (event) {

        event.preventDefault();

        if ($.isFunction(App.beforeSubmit)) {
            if (App.beforeSubmit() === false) return false;
        }

        if ($('.form-group.has-error').length > 0) {
            sweetAlert({
                    title: "Kode/Data sudah ada!!!",
                    text: "Sudah Ada!!!",
                    type: "warning"
                },
                function () {
                    $('.form-group.has-error:first .form-control').focus();
                });

            return false;
        }

        process = true;

        var form = $(this);
        var submit_url = form.attr("action");
        var defered;

        if ("FormData" in window) {
            var fd = new FormData(form.get(0));

            upload_in_progress = true;
            defered = $.ajax({
                url: submit_url,
                type: form.attr("method"),
                processData: false,
                contentType: false,
                dataType: 'json',
                data: fd,
                xhr: function () {
                    var req = $.ajaxSettings.xhr();

                    if (req && req.upload) {
                        req.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                var done = e.loaded || e.position, total = e.total || e.totalSize;
                                var percent = parseInt((done / total) * 100) + '%';
                            }
                        }, false);
                    }

                    return req;
                },
                beforeSend: function () {

                },
                success: function () {

                }
            });
        } else {
            upload_in_progress = true;
            defered = new $.Deferred;

            var iframe_id = 'temporary-iframe-' + (new Date()).getTime() + '-' + (parseInt(Math.random() * 1000));
            form.after('<iframe id="' + iframe_id + '" name="' + iframe_id + '" frameborder="0" width="0" height="0" src="about:blank" style="position:absolute;z-index:-1;"></iframe>');
            form.append('<input type="hidden" name="temporary-iframe-id" value="' + iframe_id + '" />');
            form.next().data('deferrer', deferred);//save the deferred object to the iframe
            form.attr({
                'method': 'POST', 'enctype': 'multipart/form-data',
                'target': iframe_id, 'action': submit_url
            });

            form.get(0).submit();

            setTimeout(function () {
                var iframe = document.getElementById(iframe_id);
                if (iframe != null) {
                    iframe.src = "about:blank";
                    $(iframe).remove();

                    defered.reject({"status": "fail", "message": "Timeout!"});
                }
            }, 60000);
        }

        defered.done(function (result) {
            upload_in_progress = false;

            if (result != null && result.status == "OK") {
                $('#btn-cancel').trigger('click');
                $("form [required]").each(function (index, el) {
                    $(el).parents('.form-group').removeClass('has-error');
                });

                if (App.table.name != '') {
                    var oTable = $("#list-" + App.table.name).dataTable();
                    oTable.fnDraw();
                } else {

                    $.ajax({
                        url: App.read_url,
                        data: {},
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            var oTable = $("#list-" + App.table.name).dataTable();
                            oTable.fnClearTable();

                            if (data.data.length > 0) {
                                oTable.fnAddData(data.data);
                                oTable.fnDraw();
                            }
                        }
                    });
                }

            } else {
                SweetAlert("Oops...", result.error, "error");
            }

            if ($.isFunction(App.afterSubmit)) {
                if (App.afterSubmit() === false) return false;
            }

        }).fail(function (res) {
            upload_in_progress = false;
            sweetAlert("Oops...", res.error, "error");
        });

        defered.promise();
    });
    //---
});

/**
 * View
 * @param id
 * @constructor
 */
App.view = function (id) {
    process = true;

    if ($.isFunction(App.beforeView)) {
        if (App.beforeView() === false) return false;
    }

    $('#box-view input[type=checkbox]:checked.view').prop('checked', false);
    id.type = 'view';

    $.ajax({
        url: App.read_url,
        data: id,
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (typeof data.error === 'undefined') {
                $('form').attr('action', App.update_url);
                $.each(data, function (id) {
                    if (!$.isPlainObject(eval('data.' + id) + '.view')) {
                        if ($('#box-view #' + id + ".view").html() != undefined) {
                            $('#box-view #' + id + '.view').html(eval('data.' + id));
                        }

                        if (eval('data.' + id) != '' && $('#box-view input#' + id + '.view').attr('type') == 'radio') {
                            $('#box-view input#' + eval('data.' + id) + '.view').attr('checked', true);
                        } else if ($('#box-view input#' + id + '.view').prop('type') == 'checkbox') {
                            if (eval('data.' + id) == 1 || eval('data.' + id) == true)
                                $('#box-view input#' + id + '.view').prop('checked', true);
                        }
                    }
                });

                $('#box-view').modal('show');

                if ($.isFunction(App.afterView)) {
                    if (App.afterView(data) === false) return false;
                }
            }
        }
    });
};
//---


/**
 * Edit
 * @param id
 * @constructor
 */
App.edit = function (id) {
    process = true;

    if ($.isFunction(App.beforeEdit)) {
        if (App.beforeEdit() === false) return false;
    }

    id.type = 'edit';

    $.ajax({
        url: App.read_url,
        data: id,
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (typeof data.error === 'undefined') {

                $.each(data, function (id) {
                    if (!$.isPlainObject(eval('data.' + id))) {

                        if (eval('data.' + id) != '' && $('form input#' + id).attr('type') == 'radio')
                            $('form input#' + eval('data.' + id)).prop('checked', true);
                        else if ($('form input#' + id).attr('type') == 'checkbox') {
                            if (eval('data.' + id) == 1)
                                $('form input#' + id).prop('checked', true);
                        } else {
                            if ($('form #' + id).is('textarea')) {
                                if ($('form #' + id).text() != undefined)
                                    $('form #' + id).text(eval('data.' + id))

                                if ($('form .editor').html() != undefined)
                                    $('form .editor').html(eval('data.' + id));
                            } else {
                                if ($('form #' + id).val() != undefined)
                                    $('form #' + id).val(eval('data.' + id))
                            }

                            if ($('form #' + id + "_old").val() != undefined)
                                $('form #' + id + "_old").val(eval('data.' + id))
                        }

                    }
                });

                $('form').attr('action', App.update_url);
                $('#box-form').removeClass('hidden');

                if ($.isFunction(App.afterEdit)) {
                    if (App.afterEdit(data) === false) return false;
                }
            }
        }
    });
};
//---


/**
 * Delete
 * @param id
 * @constructor
 */
App.delete = function (id) {
    //process = true;
    $(function () {
        sweetAlert({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak akan dapat kembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                $.ajax({
                    url: App.delete_url,
                    data: id,
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        if (data != null && typeof data.error === 'undefined') {
                            if (App.table.name != '') {
                                var oTable = $('#list-' + App.table.name).dataTable();
                                oTable.fnDraw();
                            } else {

                                $.ajax({
                                    url: App.read_url,
                                    data: {},
                                    type: 'POST',
                                    dataType: 'json',
                                    success: function (data) {
                                        var oTable = $('#list-' + App.table.name).dataTable();
                                        oTable.fnClearTable();

                                        if (data.data.length > 0) {
                                            oTable.fnAddData(data.data);
                                            oTable.fnDraw();
                                        }
                                    }
                                });

                            }

                            sweetAlert("Berhasil", "Data telah berhasil dihapus", "success");
                        } else {
                            sweetAlert("Gagal!", "Data gagal dihapus!", "error");
                        }
                    }
                });

            });
    });
};
//---

/**
 * beforeSubmit
 * @param callback
 */
App.beforeSubmit = function (callback) {
    if (typeof callback !== 'undefined')
        App.beforeSubmit = callback;
    else
        App.beforeSubmit = true;
};
//---

/**
 * afterSubmit
 * @param callback
 */
App.afterSubmit = function (callback) {
    if (typeof callback !== 'undefined') {
        App.afterSubmit = callback;
    } else {
        App.afterSubmit = true;
    }
};
//---

App.beforeView = function (callback) {
    if (typeof callback !== 'undefined') {
        App.beforeView = callback;
    } else {
        App.beforeView = true;
    }
};

App.afterView = function (callback) {
    if (typeof callback !== 'undefined') {
        App.afterView = callback;
    } else {
        App.afterView = true;
    }
};

App.beforeEdit = function (callback) {
    if (typeof callback !== 'undefined') {
        App.beforeEdit = callback;
    } else {
        App.beforeEdit = true;
    }
};

App.afterEdit = function (callback) {
    if (typeof callback !== 'undefined') {
        App.afterEdit = callback;
    } else {
        App.afterEdit = true;
    }
};

App.beforeDelete = function (callback) {
    if (typeof callback !== 'undefined')
        App.beforeDelete = callback;
    else
        App.beforeDelete = true;
};

App.afterDelete = function (callback) {
    if (typeof callback !== 'undefined')
        App.afterDelete = callback;
    else
        App.afterDelete = true;
};

/**
 * Debug
 * @param url
 * @param method
 * @param params
 */
App.Debug = function debug(url, method, params) {
    var f = $("<form target='_blank' method='" + method + "' style='display:none;'></form>").attr({
        action: url
    }).appendTo(document.body);
    params = App.parseParams(params);

    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            $('<input type="hidden" />').attr({
                name: i,
                value: params[i]
            }).appendTo(f);
        }
    }

    f.submit();

    f.remove();
};

App.parseParams = function parseParams(str) {
    return str.split('&').reduce(function (params, param) {
        var paramSplit = param.split('=').map(function (value) {
            return decodeURIComponent(value.replace('+', ' '));
        });
        params[paramSplit[0]] = paramSplit[1];
        return params;
    }, {});
};
//---