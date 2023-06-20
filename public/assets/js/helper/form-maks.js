$(document).ready(function () {
    // Apply input masking for numeric inputs with format 99.99
    $('.numericInput').inputmask('99.99');

    // Apply input masking for numeric inputs with format 9.99
    $('.numericInputSingle').inputmask('9.99');

    // Apply input masking for a 13-digit number
    $('.numericInputPhone').inputmask('999-999-9999');

    // Apply input masking for a 13-digit number
    $('.numericInputHid').inputmask('9 9999 99999 99 9');

    // Apply input masking for numeric input
    $('.numericInputInt').inputmask('9{1,}', { "placeholder": "" });

});
