var dataCategory = $('#dataCategory');
var consent = $('#consent');
var privacyPolicy = $('#privacyPolicy');
var privacyPolicyAttributes = $('#privacyPolicyAttributes');
var consentAgreement = $('#consentAgreement');
var legalGround = $('#legalGround');
var legalGroundSpecialCategory = $('#legalGroundSpecialCategory');

$('#legalGroundSpecialCategoryContainer').hide();
$('#consentNotRequired').hide();
consentAgreement.hide();
privacyPolicyAttributes.hide();

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

privacyPolicy.change(function() {
    if ($(this).val() == 'true') {
        privacyPolicyAttributes.show();
    } else {
        privacyPolicyAttributes.hide();
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