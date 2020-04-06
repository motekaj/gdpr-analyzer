var dataCategory = $('#dataCategory');
var consent = $('#consent');
var consentAgreement = $('#consentAgreement');
var purpose = $('#purpose');
var specialPurpose = $('#specialPurpose');

$('#specialPurposeContainer').hide();
$('#consentNotRequired').hide();
consentAgreement.hide();

dataCategory.change(function() {
    if ($(this).val() == 'general') {
        $('#specialPurposeContainer').hide();
        $('#purposeContainer').show();
    } else {
        $('#specialPurposeContainer').show();
        $('#purposeContainer').hide();
    }
});

consent.change(function() {
    if ($(this).val() == 'true') {
        consentAgreement.show();
    } else {
        consentAgreement.hide();
    }
});

purpose.change(function() {
    if ($(this).val() !== 'general') {
        $('#consentNotRequired').show();
        $('#consentWrapper').hide();
    } else {
        $('#consentNotRequired').hide();
        $('#consentWrapper').show();
    }
});

specialPurpose.change(function() {
    if ($(this).val() !== 'general') {
        $('#consentNotRequired').show();
        $('#consentWrapper').hide();
    } else {
        $('#consentNotRequired').hide();
        $('#consentWrapper').show();
    }
});