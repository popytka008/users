/**
 * Created by Андрей on 14.09.2015.
 */
if (typeof LSS === 'undefined') {
    LSS = new Object();
}

if (typeof LSS.Utils === 'undefined') {
    LSS.Utils = new Object();
}

LSS.Utils.limitText = function(element, maxLength) {
    if (element.value.length > maxLength) {
        element.value = element.value.substr(0, maxLength);
    }
    return true;
};

LSS.Utils.onlyDigits = function(element) {
    element.value = element.value.replace(/\D/g, '');
    return true;
};

LSS.Utils.onlyFloats = function(element) {
    element.value = element.value.replace(/,/g, '.');
    element.value = element.value.replace(/[^\d.]/g, '');
    return true;
};

LSS.escape = function(text) {
    return $('<i></i>').text(text).html();
};