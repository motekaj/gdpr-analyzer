var processingLog = $('#processingLog');

$('#logAttributes').hide();

processingLog.change(function() {
    if ($(this).val() == 'true') {
        $('#logAttributes').show();
    } else {
        $('#logAttributes').hide();
    }
});