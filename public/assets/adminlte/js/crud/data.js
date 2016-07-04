/**
 * Created by DWIsprananda on 4/22/2016.
 */

$(function () {
    var uom_ready = false;
    var form_data_global = '';

    /*$.ajax({
        url: App.get_prev_data_url,
        data: {
            category_idx: 0,
            group_idx: 0,
            actual_idx: 0,
            kpi: $('#kpi:first').val()
        },
        type: 'POST',
        success: function (data) {
            $('.box-category').find('tr').find("button[data-toggle=popover]").popover({
                html: true,
                trigger: 'focus',
                content: function () {
                    return data;
                }
            });
        }
    });*/

    /**
     * Before Submit
     * @returns {boolean}
     */
    App.beforeSubmit = function () {
        process = true;
        var data = {};

        data.report_id_old = $('#report_id_old').val();
        data.date = $('#date').val();
        data.department_id = $('#department_id').val();
        data.category = [];
        $('form').find('.box-category').each(function (idx, el) {
            data.category[idx] = {};
            data.category[idx].report_category_id = $(el).find('.box-header').find('#report_category_id').val();
            data.category[idx].category_id = $(el).find('.box-header').find('#category_id').val();
            data.category[idx].group = [];

            $(el).find('.box-group').each(function (idx2, el2) {
                data.category[idx].group[idx2] = {};
                data.category[idx].group[idx2].report_group_id = $(el2).find('.box-header').find('#report_group_id').val();
                data.category[idx].group[idx2].title = $(el2).find('.box-header').find('.input-group-title').val();
                data.category[idx].group[idx2].data = [];

                $(el2).find('tbody').find('tr').each(function (idx3, el3) {
                    if (typeof $(el3).find('#kpi').val() === 'undefined') return false;

                    data.category[idx].group[idx2].data[idx3] = {};
                    data.category[idx].group[idx2].data[idx3].report_detail_id = $(el3).find('#report_detail_id').val();
                    data.category[idx].group[idx2].data[idx3].kpi = $(el3).find('#kpi').val();
                    data.category[idx].group[idx2].data[idx3].uom_id = $(el3).find('#uom_id').val();
                    data.category[idx].group[idx2].data[idx3].target = $(el3).find('#target').val();
                    data.category[idx].group[idx2].data[idx3].actual = $(el3).find('#actual').val();
                    data.category[idx].group[idx2].data[idx3].variance_explanation = $(el3).find('#variance_explanation').val();
                });

            });

        });

        $.ajax({
            url: $('form').attr('action'),
            data: {
                top_priorities_title1: $('#top_priorities_title1').val(),
                top_priorities_description1: $('#top_priorities_description1').val(),
                top_priorities_title2: $('#top_priorities_title2').val(),
                top_priorities_description2: $('#top_priorities_description2').val(),
                top_priorities_title3: $('#top_priorities_title3').val(),
                top_priorities_description3: $('#top_priorities_description3').val(),
                data: data
            },
            type: $('form').attr('method'),
            dataType: 'json',
            success: function (data) {
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

                process = false;
            }
        });

        return false;
    }

    /**
     * Apply Template
     */
    function applyTemplate() {
        var department_id = $('#department_id').val();
        process = true;
        $.ajax({
            url: App.get_template_url,
            data: {
                department_id: department_id
            },
            type: 'POST',
            dataType: 'json',
            success: function (data) {

                var form = $('#form-template');

                $(data).each(function (idx, row) {
                    $(row.ReportTemplateCategory).each(function (idx2, row2) {
                        var form_category = form;

                        if (idx2 > 0) {
                            form_category = addCategoryForm(form.find('.btn-add_category'), function(el) {
                                form_category.find('#report_category_id').val(row2.report_category_id);
                                form_category.find('#category_id').val(row2.category_id);
                            });
                        }

                        $(row2.ReportTemplateGroup).each(function (idx3, row3) {
                            var form_group = form_category;
                            if (idx3 > 0) {
                                form_group = addGroupForm(form_category.find('.btn-add_group'));
                            }

                            form_group.find('#report_group_id').val(row3.report_group_id);
                            form_group.find('.input-group-title').val(row3.title);
                            form_group.find('.input-group-title').trigger('keyup');

                            $(row3.ReportTemplateDetail).each(function (idx4, row4) {

                                if (idx4 == 0) {
                                    form_group.find('#report_detail_id').val(row4.report_detail_id);
                                    form_group.find('#kpi').val(row4.kpi);
                                    form_group.find('#uom_id').val(row4.uom_id);
                                    form_group.find('#target').val(parseFloat(row4.target).toFixed(2));
                                    var actual = form_group.find('#actual');
                                    actual.val(parseFloat(row4.actual).toFixed(2));
                                    form_group.find('#variance_explanation').val(row4.variance_explanation);
                                    actual.trigger('keyup');

                                    var uom = form_group.find('select[name="uom_id[]"]');
                                    getUOM(uom, row4.uom_id);

                                    var box_group = actual.parents('.box-group');
                                    var category_idx = box_group.parents('.box-category').index()-2;
                                    var group_idx = box_group.index();
                                    var actual_idx = actual.parents('tr').index();
                                    var kpi = row4.kpi;

                                    actual.parents('tr').find("button[data-toggle=popover]").popover('destroy');
                                    $.ajax({
                                        url: App.get_prev_data_url,
                                        data: {
                                            department_id: department_id,
                                            category_idx: category_idx,
                                            group_idx: group_idx,
                                            actual_idx: actual_idx,
                                            kpi: kpi
                                        },
                                        type: 'POST',
                                        success: function (data) {
                                            actual.parents('tr').find("button[data-toggle=popover]").popover({
                                                html: true,
                                                trigger: 'focus',
                                                content: function () {
                                                    return data;
                                                }
                                            });
                                        }
                                    });

                                    return;
                                }

                                var value = {
                                    report_detail_id: row4.report_detail_id,
                                    kpi: row4.kpi,
                                    uom_id: row4.uom_id,
                                    target: row4.target,
                                    actual: row4.actual,
                                    variance_explanation: row4.variance_explanation
                                }
                                addDataForm(form_group.find('.btn-add_data'), value);

                            });

                        });

                    });

                    return false;
                });
            }
        });
    }

    /**
     * Button Add Click
     */
    $('#btn-add').bind('click', function () {
        applyTemplate();
    });

    /**
     * Button Cancel Click
     */
    $('#btn-cancel').bind('click', function () {
        App.resetForm();
    });

    /**
     * Reset Form
     */
    App.resetForm = function () {
        uom_ready = false;

        $('.btn_remove_category').each(function (idx, el) {
            if (idx == 0) return;

            $(el).trigger('click');
        });

        $('.btn_remove_group').each(function (idx, el) {
            if (idx == 0) return;

            $(el).trigger('click');
        });

        $('.btn-del_data').each(function (idx, el) {
            if (idx == 0) return;

            deleteDataForm($(this), false);
            $(this).parents('tr').find('#actual').trigger('keyup');
        });

        $($('.btn-del_data').get(0)).parents('tr').find('#actual').trigger('keyup');
    }

    /**
     * After Edit
     * @param data
     */
    App.afterEdit = function (data) {

        App.resetForm();

        var form = $('#form-template');

        $(data).each(function (idx, row) {
            $(row.ReportTemplateCategory).each(function (idx2, row2) {
                var form_category = form;

                if (idx2 > 0) {
                    form_category = addCategoryForm(form.find('.btn-add_category'), function (el) {
                        $(el).val(row2.category_id);
                    });
                } else {
                    refreshCategory(form_category.find('select[name="category_id[]"]'), $('#department_id').val(), function (el) {
                        $(el).val(row2.category_id);
                    });
                }

                form_category.find('#report_category_id').val(row2.report_category_id);

                $(row2.ReportTemplateGroup).each(function (idx3, row3) {
                    var form_group = form_category;
                    if (idx3 > 0) {
                        form_group = addGroupForm(form_category.find('.btn-add_group'));
                    }

                    form_group.find('#report_group_id').val(row3.report_group_id);
                    form_group.find('.input-group-title').val(row3.title);
                    form_group.find('.input-group-title').trigger('keyup');

                    $(row3.ReportTemplateDetail).each(function (idx4, row4) {
                        if (idx4 == 0) {
                            form_group.find('#report_detail_id').val(row4.report_detail_id);
                            form_group.find('#kpi').val(row4.kpi);
                            form_group.find('#uom_id').val(row4.uom_id);
                            form_group.find('#target').val(parseFloat(row4.target).toFixed(2));
                            form_group.find('#actual').val(parseFloat(row4.actual).toFixed(2));
                            form_group.find('#variance_explanation').val(row4.variance_explanation);

                            return;
                        }

                        var value = {
                            report_detail_id: row4.report_detail_id,
                            kpi: row4.kpi,
                            uom_id: row4.uom_id,
                            target: row4.target,
                            actual: row4.actual,
                            variance_explanation: row4.variance_explanation
                        }
                        addDataForm(form_group.find('.btn-add_data'), value);

                    });

                });

            });

            return false;
        });

        if (typeof data.TopPriorities !== 'undefined' && data.TopPriorities.length > 0) {
            $(data.TopPriorities).each(function(idx, row) {
                $('#top_priorities_title'+row.idx).val(row.title);
                $('#top_priorities_description'+row.idx).val(row.title);
            });
        }
    }


    /**
     * Function for UOM
     * @param el
     */
    function getUOM(el, value) {
        $(el).find('option').remove();
        $.ajax({
            url: App.get_uom_url,
            data: {},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $.each(data, function (idx, row) {
                        $(el).append('<option value="' + row.uom_id + '">' + row.uom + '</option>');
                    });
                }

                if (value) {
                    $(el).val(value);
                }
            }
        });
    }

    /**
     * Event while first button category click
     */
    $('.btn-add_category').bind('click', function () {
        addCategoryForm($(this))
    });
    function addCategoryForm(el, callback) {
        var form_data = $(App.category_form).insertBefore($(el).parents('.form-group'));
        addDataForm(form_data.find($('.btn-add_data')));
        form_data = $(form_data);
        var category = form_data.find('select[name="category_id[]"]');
        var btnRemoveCategory = form_data.find('.btn_remove_category');
        var btnRemoveGroup = form_data.find('.btn_remove_group');
        var title = form_data.find('.input-group-title');
        var btnGroupAdd = form_data.find('.btn-add_group');
        var btnAdd = form_data.find('.btn-add_data');
        var btnDel = form_data.find('.btn-del_data');
        var uom = form_data.find('select[name="uom_id[]"]');
        var actual = form_data.find($('input[name="actual[]"]'));

        // getUOM(uom);
        refreshCategory(category, $('#department_id').val(), callback);
        addRemoveCategoryEvent(btnRemoveCategory);
        addRemoveGroupEvent(btnRemoveGroup);
        addGroupTitleEvent(title);
        addGroupEvent(btnGroupAdd);
        addDataEvent(btnAdd);
        addDeleteEvent(btnDel);
        reInitRequiredEvent();
        addCalculationEvent(actual);

        $.AdminLTE.boxWidget.activate();

        return form_data;
    }

    /**
     * Event on Department Change Value
     */
    $('#department_id').bind('change', function () {
        var value = $(this).val();
        refreshCategory($('select[name="category_id[]"]'), $(this).val());
        App.resetForm();
        applyTemplate();
        // $('form').find('input, select, textarea').val('');
        $(this).val(value);
    });

    /**
     * Refresh Category Combobox while Add Category
     * @param el
     * @param department_id
     */
    function refreshCategory(el, department_id, callback) {
        $(el).find('option').remove();
        $.ajax({
            url: App.get_category_url,
            data: {department_id: department_id},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    $.each(data, function (idx, row) {
                        $(el).append('<option value="' + row.category_id + '">' + row.category + '</option>');
                    });
                }

                if ($.isFunction(callback)) {
                    callback($(el));
                }
            }
        });
    }

    refreshCategory($('select[name="category_id[]"]'), $('#department_id').val());
    //---

    /**
     * Add Remove Group Click Event on Button Remove Group
     * @param btnRemove
     */
    function addRemoveGroupEvent(btnRemove) {
        $(btnRemove).bind('click', function (e) {
            if ($(this).parents('.box-category').find('.box-group').length <= 1) {
                sweetAlert("Information", "Can't remove this group, cause is must have one or more group", "info");
            } else {
                $(this).parents('.box-group').remove();
            }
        });
    }

    addRemoveGroupEvent($('.btn_remove_group'));
    //---

    /**
     * Add Remove Category Click Event on Button Remove Category
     * @param btnRemove
     */
    function addRemoveCategoryEvent(btnRemove) {
        $(btnRemove).bind('click', function (e) {
            if ($(this).parents('.box-category').parent().find('.box-category').length <= 1) {
                sweetAlert("Information", "Can't remove this category, cause is must have one or more category", "info");
            } else {
                $(this).parents('.box-category').remove();
            }
        });
    }

    addRemoveCategoryEvent($('.btn_remove_category'));
    //---

    /**
     * Add Event Keyup on Group Title Input
     * @param title
     */
    function addGroupTitleEvent(title) {
        $(title).bind('keyup', function () {
            if ($(this).val() != '') {
                $(this).parents('.form-group-sm').find('.group-title').html(' ' + $(this).val());
            } else {
                $(this).parents('.form-group-sm').find('.group-title').html('');
            }
        });
    }

    addGroupTitleEvent($('.input-group-title'));
    //---

    /**
     * Add Click Event on Button Add Group
     * @param btnAddGroup
     */
    function addGroupEvent(btnAddGroup) {
        $(btnAddGroup).bind('click', function () {
            addGroupForm($(this));
        });
    }

    addGroupEvent($('.btn-add_group'));
    //---

    /**
     * Add Group Form
     * @param btnAddGroup
     * @param value
     */
    function addGroupForm(btnAddGroup) {
        var parent = $(btnAddGroup).parents('.form-group');
        var group_form = $(App.group_form).insertBefore(parent);
        group_form = $(group_form);
        var btnRemoveGroup = group_form.find('.btn_remove_group');
        var title = group_form.find('.input-group-title');
        var btnAdd = group_form.find('.btn-add_data');
        var btnDel = group_form.find('.btn-del_data');
        // var uom = group_form.find('select[name="uom_id[]"]');
        // var actual = group_form.find($('input[name="actual[]"]'));

        // getUOM(uom);
        addRemoveGroupEvent(btnRemoveGroup);
        addGroupTitleEvent(title);
        addDataEvent(btnAdd);
        addDeleteEvent(btnDel);
        // reInitRequiredEvent();
        // addCalculationEvent(actual);

        $.AdminLTE.boxWidget.activate();

        /*if ($.isFunction(callback)) {
            callback($(el));
        }*/

        addDataForm(btnAdd);
        return group_form;
    }

    /**
     * Add Click Event on Button Add Data Form
     * @param btnAddData
     */
    function addDataEvent(btnAddData) {
        $(btnAddData).bind('click', function () {
            addDataForm($(this));
        });
    }

    addDataEvent($('.btn-add_data'));
    //---

    function isFloat(x) {
        return !!(x % 1);
    }

    /**
     * Add one data form or add row
     * @param input
     * @param value
     */
    function addDataForm(input, value) {

        if (uom_ready == false && $(input).parents('tbody').find('tr:first').find('#uom_id').find('option').length > 0) {
            form_data_global = '<tr>' + $(input).parents('tbody').find('tr:first').html() + '</tr>';
            uom_ready = true;
        } else if (form_data_global == '') {
            form_data_global = App.data_form;
        }

        form_data = $(form_data_global).insertBefore($(input).parents('tr'));

        $(form_data).find('td.has-error').each(function (idx, el) {
            $(el).removeClass('has-error');
        });
        var btn_del = $(form_data).find('.btn-del_data');
        addDeleteEvent(btn_del);


        $(form_data).find('input, select, textarea').each(function (idx, el) {
            var id = $(el).attr('id');

            if (value) {
                if (id == 'uom_id' && uom_ready == false) {
                    getUOM(el, eval('value.' + id));
                } else {
                    $(el).val(eval('value.' + id));

                    if (id == 'report_detail_id') return;

                    if (!$(el).is('select') && $.isNumeric(eval('value.' + id))) {
                        $(el).val(parseFloat($(el).val()).toFixed(2));
                    }
                }
            } else if (uom_ready == false) {
                if (id == 'uom_id')
                    getUOM(el);
            }
        });

        var actual = form_data.find($('input[name="actual[]"]'));
        addCalculationEvent(actual);
        actual.trigger('keyup');
        var box_group = actual.parents('.box-group');
        var category_idx = box_group.parents('.box-category').index()-2;
        var group_idx = box_group.index();
        var actual_idx = actual.parents('tr').index();
        var kpi = actual.parents('tr').find('#kpi').val();
        actual.parents('tr').find("button[data-toggle=popover]").popover('destroy');
        
        $.ajax({
            url: App.get_prev_data_url,
            data: {
                department_id: $('#department_id').val(),
                category_idx: category_idx,
                group_idx: group_idx,
                actual_idx: actual_idx,
                kpi: kpi
            },
            type: 'POST',
            success: function (data) {
                actual.parents('tr').find("button[data-toggle=popover]").popover({
                    html: true,
                    trigger: 'focus',
                    content: function () {
                        return data;
                    }
                });
            }
        });

        reInitRequiredEvent();

        return form_data;
    }

    /**
     * Re Initialize required input
     */
    function reInitRequiredEvent() {
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
    }

    /**
     * Add Delete Event for btn delete in data form or row
     * @param btnDel
     */
    function addDeleteEvent(btnDel) {
        $(btnDel).bind('click', function () {
            deleteDataForm($(this), true);
        });
    }

    addDeleteEvent($('.btn-del_data'));
    //---

    function deleteDataForm(el, confirm) {
        if ($(el).parents('tbody').find('.btn-del_data').length > 1) {
            var form_data = $($(this).parents('tbody'));
            var tr = $(el).parents('tr');
            var state = true;
            tr.find('input,textarea').each(function (idx, el) {
                if (state == false) return;

                if (confirm !== false) {

                    if ($(el).val() != '' && parseInt($(el).val()) != 0) {
                        sweetAlert({
                            title: 'Are you sure?',
                            text: 'In this section, have some data.<br /> So if you delete this some data will be lost!',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: "Yes, delete it!",
                            html: true
                        }, function () {
                            tr.remove();
                            state = true;
                            var actual = form_data.find('input[name="actual[]"]');
                            actual.trigger('keyup');
                        });

                        state = false;
                        return;
                    }
                }

            });

            if (state) {
                tr.remove();
            }

        } else {
            sweetAlert("Information", "Can't remove this form", "info");
        }
    }

    /**
     * Add Calculation Event on actual input
     * @param input
     */
    function addCalculationEvent(input) {
        $(input).bind('keyup', function () {
            var value = 0.0;

            $(this).parents('tbody').find('input[name="actual[]"]').each(function (idx, el) {
                if ($.isNumeric($(el).val())) {
                    value += parseFloat($(el).val());
                }
            });

            var totalData = $(this).parents('.box-group').find('.total_group');
            $(totalData).html(value.toFixed(2));

            totalCategory($(this).parents('.box-body').find('.total_group'), $(this).parents('.box-category').find('.total_category'));
        });
    }

    addCalculationEvent($('input[name="actual[]"]'));

    /**
     * Function for Calculate Total from All Group in Category
     * @param input
     * @param output
     */
    function totalCategory(input, output) {
        var total = 0.0;
        input.each(function (idx, el) {
            total += parseFloat($(el).html());
        });

        output.html(total.toFixed(2));
    }
});

App.afterView = function (data) {
    if ($('#box-view .modal-dialog .modal-content .modal-header').find('h3').length > 0) {
        $('#box-view .modal-dialog .modal-content .modal-header').find('h3').remove();
    }
    
    if ($('#box-view').find('.modal-body').find('div:last').find('table').length > 0) {
        $('#box-view').find('.modal-body').find('div:last').remove();
    }

    $('#box-view').find('.modal-body').append(data.detail);
    $('#box-view').find('.modal-body').css('height', '550px');
}

/**
 * Template of Data Form
 * @type {string}
 */
App.data_form = '\
<tr>\
    <td width="20px" class="hidden">\
        <button type="button" class="btn-del_data btn btn-sm btn-danger">\
            <i class="fa fa-minus"></i>\
        </button>\
    </td>\
    <td>\
        <input type="hidden" name="report_detail_id[]" id="report_detail_id" value="0" />\
        <input type="text" name="kpi[]" required class="form-control input-sm" id="kpi" />\
    </td>\
    <td>\
        <select name="uom_id[]" required class="form-control input-sm" id="uom_id">\
        </select>\
    </td>\
    <td>\
        <input type="text" name="target[]" class="text-right form-control input-sm" id="target" />\
    </td>\
    <td>\
        <div class="input-group">\
            <input type="text" name="actual[]" required class="text-right form-control input-sm" id="actual" value="0.00" />\
            <div class="input-group-btn">\
                <button type="button" class="btn btn-default btn-sm" data-placement="right" data-toggle="popover" title="<strong>Previous Actual</strong>">\
                    <i class="fa fa-exchange"></i>\
                </button>\
            </div>\
        </div>\
    </td>\
    <td>\
        <textarea name="variance_explanation[]" class="form-control input-sm" id="variance_explanation" style="height: 30px; resize: vertical"></textarea>\
    </td>\
</tr>';

/**
 * Template of Group Form
 * @type {string}
 */
App.group_form = '\
<div class="box-group box box-primary box-solid" style = "padding-bottom: 0px;">\
    <div class="box-header">\
        <div class="form-group-sm">\
            <div class="col-sm-7">\
                <input type="hidden" name="report_group_id" id="report_group_id" value="0" />\
                <input type="text" class="input-group-title form-control" style="height: 20px;" placeholder="Please insert the Title" readonly />\
            </div>\
            <div class="col-sm-5">\
                <strong>Total<span class="group-title"></span>: <span class="total_group">0.00</span></strong>\
            </div>\
        </div>\
        <div class="box-tools pull-right">\
            <button type="button" class="btn btn-box-tool" data-widget="collapse">\
                <i class="fa fa-minus"></i>\
            </button>\
            <button type="button" class="hidden btn_remove_group btn btn-box-tool">\
                <i class="fa fa-times"></i>\
            </button>\
        </div>\
    </div>\
    <div class="box-body" style="padding: 0px; margin: 0px;">\
        <table class="input-sm table table-striped table-hover table-bordered" style="margin: 0px;">\
            <thead>\
            <tr>\
                <!--<th>&nbsp;</th>-->\
                <th>\
                    <label for="field" class="control-label">KPI<span class="text-red">*</span></label>\
                </th>\
                <th>\
                    <label for="field" class="control-label">UOM <span class="text-red">*</span></label>\
                </th>\
                <th class="col-sm-2">\
                    <label for="field" class="control-label">Target</label>\
                </th>\
                <th class="col-sm-2">\
                    <label for="field" class="control-label">Actual<span class="text-red">*</span></label>\
                </th>\
                <th>\
                    <label for="field" class="control-label">Variance Explanation</label>\
                </th>\
            </tr>\
            </thead>\
            <tbody id="box_form_data">\
            <tr class="hidden">\
                <td colspan="6">\
                    <button type="button" class="btn-add_data btn btn-default btn-block btn-sm">\
                        <i class="fa fa-plus"></i><strong> Add</strong>\
                    </button>\
                </td>\
            </tr>\
            </tbody>\
        </table>\
    </div>\
</div>';
//---

/**
 * Template of Category Form
 * @type {string}
 */
App.category_form = '\
<div class="box-category box box-default box-solid" style="padding-bottom: 0px;">\
    <div class="box-header with-border" >\
        <div class="form-group-sm">\
            <div class="col-sm-7">\
                <input type="hidden" name="report_category_id[]" id="report_category_id" value="0" />\
                <select name = "category_id[]" required class="form-control input-sm" id = "category_id">\
                </select>\
            </div>\
        </div>\
        <div class="col-sm-5">\
            <strong>Total: <span class="total_category">0.00</span></strong>\
        </div>\
        <div class="box-tools pull-right">\
            <button type = "button" class="btn btn-box-tool" data-widget="collapse">\
                <i class="fa fa-minus"></i>\
            </button>\
            <button type="button" class="hidden btn_remove_category btn btn-box-tool">\
                <i class="fa fa-times"></i>\
            </button>\
        </div>\
    </div>\
    <div class="box-body" style="padding-bottom: 0px; margin-bottom: 0px; padding-top: 5px;">'
    + App.group_form +
    '<div class="form-group">\
        <div class="col-sm-12 hidden">\
            <button type="button" class="btn-add_group btn btn-warning btn-block btn-sm">\
                <i class="fa fa-plus"></i> <strong>Add Group</strong>\
            </button>\
        </div>\
    </div>\
</div>\
</div>';
//---