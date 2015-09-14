/**
 * Created by Андрей on 14.09.2015.
 */
if (typeof LSS === 'undefined') {
    LSS = new Object();
}

if (typeof LSS.Form === 'undefined') {
    LSS.Form = new Object();
}

LSS.Form.loadingMsg = 'Идёт обработка данных ...';
LSS.Form.error500Msg = '<div><p>Произошла ошибка. Пожалуйста, повторите попытку позже или обратитесь в службу поддержки сайта.</p><div class="btn btn-mini" onclick="$.unblockUI()">OK</div></div>';

LSS.Form.fillFields = function(target, fields, fillSeoUrl) {
    if (typeof fields === 'object' && null !== fields) {
        var target$ = $(target),
            form$ = target$.closest('form'),
            values = {};

        $.each(form$.serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });

        form$.block({'message': LSS.Form.loadingMsg});
        $.ajax(fillSeoUrl, {
            'type': 'POST',
            'dataType': 'json',
            'cache': false,
            'data': values,
            'success': function(result) {
                if (result.status == 'success') {
                    var fieldValues = result.data.fields;
                    $.each(fields, function(i, field) {
                        if (typeof fieldValues[field] != 'undefined') {
                            $('#' + field).val(fieldValues[field]);
                        }
                    });
                    form$.unblock();
                } else {
                    form$.unblock();
                    $.blockUI({
                        'message': '<div><p>' + result.data.errorMsg + '</p><div class="btn btn-mini" onclick="$.unblockUI()">OK</div></div>',
                        'css': {
                            'width': '275px'
                        }
                    });
                }
            },
            'error': function() {
                form$.unblock();
                $.blockUI({
                    'message': LSS.Form.error500Msg,
                    'css': {
                        'width': '275px'
                    }
                });
            }
        });
    } else {
        return false;
    }
};