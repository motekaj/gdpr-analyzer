var dataCategory = $('#dataCategory');
var consent = $('#consent');
var consentAgreement = $('#consentAgreement');
var legalGround = $('#legalGround');
var legalGroundSpecialCategory = $('#legalGroundSpecialCategory');

$('#legalGroundSpecialCategoryContainer').hide();
$('#consentNotRequired').hide();
consentAgreement.hide();

dataCategory.change(function() {
    if ($(this).val() == 'general') {
        $('#legalGroundSpecialCategoryContainer').hide();
        $('#legalGroundContainer').show();
    } else {
        $('#legalGroundSpecialCategoryContainer').show();
        $('#legalGroundContainer').hide();
    }
});

consent.change(function() {
    if ($(this).val() == 'true') {
        consentAgreement.show();
    } else {
        consentAgreement.hide();
    }
});

legalGround.change(function() {
    if ($(this).val() == 'unspecified' || $(this).val() == 'consent') {
        $('#consentNotRequired').hide();
        $('#consentWrapper').show();
    } else {
        $('#consentNotRequired').show();
        $('#consentWrapper').hide();
    }
});

legalGroundSpecialCategory.change(function() {
    if ($(this).val() == 'unspecified' || $(this).val() == 'consent') {
        $('#consentNotRequired').hide();
        $('#consentWrapper').show();
    } else {
        $('#consentNotRequired').show();
        $('#consentWrapper').hide();
    }
});