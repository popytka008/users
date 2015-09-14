/**
 * Created by Андрей on 14.09.2015.
 */
if (typeof LSS === 'undefined') {
    LSS = new Object();
}

if (typeof LSS.Grid === 'undefined') {
    LSS.Grid = new Object();
}

if ('uk' == LSS.currentLang) {
    LSS.gridTranslation = {
        'm1': "Скасувати",
        'm2': "Видалити",
        'm3': "Операція видалення запису",
        'm4': "Буде виконана операція видалення запису з бази з усіма зв'язаними з нею даними в інших таблицях (якщо такі є). Ви впевнені, що бажаєте продовжити?",
        'm5': "Перепроведення платежу",
        'm6': "При перепроведенні платежу обов'язково дочекайтеся завершення операції. Перепроведення платежу може займати доволі багато часу (до 5 хвилин). Перевірити статус платежу Ви можете за номером особового рахунку з таблиці.",
        'm7': "Перепровести"
    };
} else {
    LSS.gridTranslation = {
        'm1': "Отмена",
        'm2': "Удалить",
        'm3': "Операция удаления записи",
        'm4': "Будет выполнена операция удаления записи из базы со всеми связанными с ней данными в других таблицах (если таковые имеются). Вы уверены, что хотите продолжить?",
        'm5': "Перепроведение платежа",
        'm6': "При перепроведении платежа обязательно дождитесь завершения операции. Перепроведение платежа может занимать довольно много времени (до 5 минут). Перепроверить статус платежа Вы можете по номеру лицевого счёта из таблицы.",
        'm7': "Перепровести"
    };
}

LSS.Grid.deleteActionHandler = function(target, recordId) {
    var deleteAlertId = 'deleteAlert_' + recordId,
        target$ = $(target);

    $('#' + deleteAlertId).remove();

    var html = '<div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>' + LSS.gridTranslation.m3 + '</h3></div>';
    html += '<div class="modal-body" style="min-width: 300px;"><p class="alert alert-error">' + LSS.gridTranslation.m4 + '</p></div>';
    html += '<div class="modal-footer"><a class="btn btn-danger" onclick=\'window.location = "' + encodeURI(target$.attr('href')) + '";\'><i class="icon-ok icon-white"></i> ' + LSS.gridTranslation.m2 + '</a><a class="btn" data-dismiss="modal">' + LSS.gridTranslation.m1 + '</a></div>';

    $(document.body).append('<div id="' + deleteAlertId + '" class="modal hide fade">' + html + '</div>');

    $('#' + deleteAlertId).modal({
        'show': true
    });
};

LSS.Grid.resendActionHandler = function(target) {
    var target$ = $(target),
        recordId = target$.attr('data-id'),
        resendAlertId = 'resendAlert_' + recordId;

    $('#' + resendAlertId).remove();

    var html = '<div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>' + LSS.gridTranslation.m5 + '</h3></div>';
    html += '<div class="modal-body" style="min-width: 300px;"><p class="alert alert-warning">' + LSS.gridTranslation.m6 + '</p></div>';
    html += '<div class="modal-footer"><a class="btn btn-warning" onclick=\'window.location = "' + encodeURI(target$.attr('href')) + '";\'><i class="icon-ok icon-white"></i> ' + LSS.gridTranslation.m7 + '</a><a class="btn" data-dismiss="modal">' + LSS.gridTranslation.m1 + '</a></div>';

    $(document.body).append('<div id="' + resendAlertId + '" class="modal hide fade">' + html + '</div>');

    $('#' + resendAlertId).modal({
        'show': true
    });
};

;(function($) {
    $(document).on('click', '.grid_filters .filter_action', function(event) {
        event.preventDefault();
        var this$ = $(this),
            filterFields$ = this$.closest('tr').find(':input'),
            values = {},
            protocol = window.location.protocol,
            host = window.location.host,
            pathname = window.location.pathname,
            query = window.location.search;
        filterFields$.each(function() {
            var this$ = $(this);
            if (this$.closest('.chosen-container').length === 1) {
                return;
            }
            var filterValue = this$.val();
            if (typeof filterValue == "undefined" || filterValue == null) {
                filterValue = '';
            }
            var replacement = (filterValue != '') ? this.name + '/' + ($.isArray(filterValue) ? filterValue.join('-') : filterValue) + '/' : '',
                regexp = new RegExp(this.name + '/[^/?]*/?');
            if (pathname.match(regexp)) {
                pathname = pathname.replace(regexp, replacement);
            } else {
                pathname += (pathname.slice(-1) != '/' ? '/' : '') + replacement;
            }
            values[this.name] = $(this).val();
        });
        var newUrl = protocol + '//' + host + pathname + query;
        window.location = newUrl;
    });
    $(document).on('keypress', '.grid_filters input', function(event) {
        if (event.which == 13) {
            var this$ = $(this),
                filterButton$ = this$.closest('tr').find('.filter_action');
            filterButton$.trigger('click');
        }
    });
})(jQuery);