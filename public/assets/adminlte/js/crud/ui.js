/**
 * Created by Dony Wahyu Isp (dna.extrim@gmail.com or http://github.com/dnaextrim) on 2/26/2016.
 */

if (!('App' in window)) window['App'] = {};
if (!('table' in window['App'])) window['App'].table = {};

App.table.action_column = true;

var columns;

$(function () {
    /**
     * DataTables
     */

    if (App.table.name != '') {
        var actions = [
            {
                "mData": "actions",
                "bSortable": false,
                "mRender": function (id, type, row) {
                    if (id == '') return '';


                    return '<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons"> \
                            <a class="btn-view text-success" href="#" onClick="return App.view(' + id + ')"> \
                                <i class="fa fa-eye fa-lg hvr-grow"></i> \
                            </a> \
                            <a class="btn-edit text-warning" href="#" onClick="return App.edit(' + id + ')"> \
                                <i class="fa fa-pencil-square-o fa-lg hvr-grow"></i> \
                            </a> \
                            <a class="btn-delete text-danger" href="#" onClick="return App.delete(' + id + ')"> \
                                <i class="fa fa-trash-o fa-lg hvr-grow"></i> \
                            </a> \
                        </div> \
                        <div class="visible-xs visible-sm hidden-md hidden-lg"> \
                            <div class="inline position-relative"> \
                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown"> \
                                    <i class="fa fa-caret-down icon-only fa-lg"></i> \
                                </button> \
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close"> \
                                    <li> \
                                        <a href="#" onClick="return App.view(' + id + ')" class="tooltip-success" data-rel="tooltip" title="View"> \
                                            <span class="btn-view text-success"> \
                                                <i class="fa fa-eye fa-lg hvr-grow"></i> \
                                            </span> \
                                        </a> \
                                    </li> \
                                    <li> \
                                        <a href="#" onClick="return App.edit(' + id + ')" class="tooltip-success" data-rel="tooltip" title="Edit"> \
                                            <span class="btn-edit text-warning"> \
                                                <i class="fa fa-pencil-square-o fa-lg hvr-grow"></i> \
                                            </span> \
                                        </a> \
                                    </li> \
                                    <li> \
                                        <a href="#" onClick="return App.delete(' + id + ')" class="tooltip-error" data-rel="tooltip" title="Delete"> \
                                            <span class="btn-delete text-danger"> \
                                                <i class="fa fa-trash-o fa-lg hvr-grow"></i> \
                                            </span> \
                                        </a> \
                                    </li> \
                                </ul> \
                            </div> \
                        </div>';
                }
            }
        ];

        if (App.table.action_column == true)
            columns = $.merge(actions, App.table.columns);
        else
            columns = App.table.columns;

        var oTable = $("#list-" + App.table.name).dataTable({
            //"bColReorder": true,
            "sAjaxSource": App.read_url,
            "sServerMethod": "POST",
            "bProcessing": true,
            "bAutoWidth": false,
            "bServerSide": true,
            "aoColumns": columns,
            "order": [[1, "asc"]],
            "columnDefs": [
                {"targets": [0], "className": "text-center"},
                //{"targets": [-1], "className": "text-right"},
                //{"targets": [0], "visible": false}
            ]
        });

        $('.dataTables_filter input').focus();
    }
    //---


    /**
     * Hide Form Feedback
     */
    $('.form-control-feedback').hide();
    //--


    /**
     * Marking Required Field
     */
    /*$('[required]').each(function(idx, el) {
     $(el).parents('.form-group').children().first().append('<span class="text-red">*<span>');
     });*/

    $("form [required]").on('change', function (e) {
        //$(this).trigger('blur');
    });

    $("form [required]").on('blur', function (e) {
        if ($(this).val() != '' && $(this).parents('.form-group').children('.form-control-feedback').length > 0) {
            return false;
        }

        var box = $(this).parents('.form-group');

        if ($(this).parent().is('td')) {
            box = $(this).parent();
        }

        if ($(this).val() == "" && $(this).text() == "") {
            box.addClass('has-error');
        } else {
            box.removeClass('has-error');
        }

    });
    //---


    /**
     * Generate View Modal
     */

    // Modal View
    App.boxView = '<div id="box-view" class="modal fade" role="dialog" aria-labelledby="viewLabel" \
                            aria-hidden="true" data-backdrop="static" data-keyboard="false"> \
                            <div class="modal-dialog"> \
                                <div class="modal-content"> \
                                    <div class="modal-header"> \
                                        <button type="button" class="close" data-dismiss="modal" \
                                        aria-hidden="true">×</button> \
                                        <h3 id="viewLabel">VIEW</h3> \
                                    </div> \
                                    \
                                    <div class="modal-body" style="height: 400px; overflow-y: auto;"> \
                                        <div class="well form-horizontal"> \
                                        \
                                        </div> \
                                    \
                                    </div> \
                                    \
                                    <div class="modal-footer"> \
                                        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button> \
                                    </div> \
                                </div> \
                            </div> \
                        \
                        </div>';
    if ($('#box-view').length <= 0) {
        $('body').append(App.boxView); // Append Modal View to body
    }

    /**
     * Default View Fields
     * @param el
     * @returns {string}
     */
    App.defaultViewField = function (el) {
        return '<div id="' + $(el).prop('name') + '" class="view form-control" \
                style="font-weight: bold;"></div>';
    };
    //---

    /**
     * Default View Fields for Checkbox
     * @param el
     * @returns {string}
     */
    App.defaultViewCheckboxField = function (el) {
        return '<div class="checkbox"> \
                                <label class="control-label"> \
                                     <input type="checkbox" id="' + $(el).prop('name') + '" class="view" disabled /> ' +
            $(el).parents('.checkbox .control-label').text().trim() + '\
                        </label> \
                     </div>';
    };
    //---

    /**
     * Default View Field for TextArea
     */
    App.defaultViewTextareaField = function (el) {
        return '<div id="' + $(el).prop('name') + '" class="view form-control" \
                style="font-weight: bold; height: 100%"></div>';
    };
    //---

    /**
     * Generate
     */
    $("form .form-control, form input").not('form input[type=hidden]').each(function (idx, el) {
        var form_group = $(el).parents('.form-group');
        form_group.children().first().find('span').remove();

        if ($(el).prop('name') == '') {
            return true;
        }

        // Marking Required Field
        if ($(el).attr('type') == 'hidden') {
            return true;
        }

        if ($(el).parent().is('td')) {
            return true;
        }

        if (form_group.children().first().find('label').length <= 0) {
            return true;
        }

        // Marking Required Field
        if ($(el).prop('required')) {
            form_group.children().first().append('<span class="text-red">*<span>');
        }

        // if input type is password continue to next fields
        if ($(el).attr('type') == 'password') return true;

        var field = '';


        // if type is checkbox
        if ($(el).is('input') && $(el).attr('type') == 'checkbox') {
            field = App.defaultViewCheckboxField(el);
        } else { // else not checkbox
            field = App.defaultViewField(el);
        }

        // if is textarea
        if ($(el).is('textarea')) {
            field = App.defaultViewTextareaField(el);
        }

        /**
         * Append View Field
         */
        $('#box-view .modal-body .form-horizontal').append('<div class="form-group"> \
            <label class="col-sm-4 control-label no-padding-right" \
            for="' + $(el).prop('name') + '">' + form_group.find('label').text() + '</label> \
            <div class="col-sm-8"> \
                ' + field + ' \
            </div> \
        </div>');
        //---

    });
    //---

    /**
     * Create Loading Modal
     */
    App.loadingModal = '<div id="loading" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> \
            <div class="modal-dialog"> \
                <div class="modal-content"> \
                    <div class="modal-header"> \
                    <h3 id="myModalLabel">In Progress.....</h3> \
                </div> \
                \
                <div class="modal-body"> \
                    <img src="' + App.loading_image + '" /> \
                    <b>Please Wait.....</b> \
                </div> \
            </div> \
        </div>';

    if ($('#loading').length <= 0) {
        $('body').append(App.loadingModal);
    }
    //---


    /**
     * jQuery Plugins
     */

    // Select2
    if (typeof $.fn.select2 !== 'undefined') {
        $(".select2").select2({'allowClear': true});
    }

    // Chosen
    if (typeof $.fn.chosen !== 'undefined') {
        $(".chosen").chosen();
    }

    // Textarea Autosize
    if (typeof autosize !== 'undefined') {
        autosize($('textarea.autosize'));
    }

    // Datepicker
    if (typeof $.fn.datepicker !== 'undefined') {
        $('.datepicker').each(function (idx, el) {
            $(el).datepicker({
                format: $(el).data("mask"),
                autoclose: true,
                todayHighlight: true
            });
        });


        $('.input-daterange').each(function(idx, el) {
            $(el).datepicker({
                format: $(el).data("mask"),
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function () {
                var input = $(this).find('input');

                input.each(function (key, el) {
                    if ($(el).val() == '') {
                        $(el).focus();
                        return;
                    }
                });
            });
        })


    }

    // Daterangepicker
    if (typeof $.fn.daterangepicker !== 'undefined') {
        $('.daterangepicker').daterangepicker({
                'applyClass': 'btn-sm btn-success',
                'cancelClass': 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel'
                }
            })
            .prev().on(ace.click_event, function () {
            $(this).next().focus();
        });
    }

    // Timepicker
    if (typeof $.fn.timepicker !== 'undefined') {
        $('.timepicker').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            disableFocus: true,
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
            }
        });
        /*.on('focus', function() {
         $(this).timepicker('showWidget');
         }).next().on(ace.click_event, function(){
         $(this).prev().focus();
         });*/
    }

    // DateTimepicker
    if (typeof $.fn.datetimepicker !== 'undefined') {
        $('.datetimepicker').each(function (idx, el) {
            $(el).datetimepicker({
                format: $(el).data("mask"),
                autoclose: true,
                todayHighlight: true
            });
        });
    }

    // Input Mask
    if (typeof $.fn.inputmask !== 'undefined') {
        $('input').each(function () {
            if (typeof $(this).data('mask') !== 'undefined') {
                $(this).inputmask($(this).data('mask'));
            }

            if (typeof $(this).data('mask-regex') !== 'undefined') {
                $(this).inputmask('Regex', {regex: $(this).data('mask-regex')});
            }
        });
    }

    // Markdown
    if (typeof $.fn.markdown !== 'undefined') {
        $("textarea.markdown").markdown({autofocus: false, savable: false});
    }

    // Colorpicker
    if (typeof $.fn.colorpicker !== 'undefined') {
        $('.colorpicker').colorpicker();
    }

    // Dropzone
    if (typeof $.fn.dropzone !== 'undefined') {
        $('input[type=file]').each(function () {
            //$(this).wrap('<div class="fallback"></div>');
            $(this).dropzone({url: $(this).data('post')});
        });
    }

    //---
});
