<?php
// Text
$_['text_title']           = 'Klarna konto';
$_['text_pay_month']       = 'Klarna konto - Betal fra %s/måned <span id="klarna_account_toc_link"></span><script text="javascript">$.getScript(\'http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js\', function(){ var terms = new Klarna.Terms.Account({ el: \'klarna_account_toc_link\', eid: \'%s\',   country: \'%s\'});})</script>';
$_['text_information']     = 'Klarna konto information';
$_['text_additional']      = 'Klarna konto kræver yderligere oplysninger før din ordre kan gennemføres.';
$_['text_wait']            = 'Vent venligst!';
$_['text_male']            = 'Mand';
$_['text_female']          = 'Kvinde';
$_['text_year']            = 'År';
$_['text_month']           = 'Måned';
$_['text_day']             = 'Dag';
$_['text_payment_option']  = 'Betalingsmulighed';
$_['text_single_payment']  = 'Enkelt betaling';
$_['text_monthly_payment'] = '%s - %s pr måned';
$_['text_comment']         = 'Klarna\'s faktura ID: %s\n%s/%s: %.4f';

// Entry
$_['entry_gender']         = 'Køb:';
$_['entry_pno']            = 'CPR-nr.:<br /><span class="help">Skriv venligst dit CPR-nr. i dette felt.</span>';
$_['entry_dob']            = 'Fødselsdato:';
$_['entry_phone_no']       = 'Mobilnummer:<br /><span class="help">Skriv venligst dit mobilnummer i dette felt.</span>';
$_['entry_street']         = 'Vejnavn:<br /><span class="help">Bemærk at det kun er til den adresse Klarna modtager, hvortil varen kan sendes.</span>';
$_['entry_house_no']       = 'Husnummer:<br /><span class="help">Skriv venligst dit husnummr i dette felt.</span>';
$_['entry_house_ext']      = 'Ekstra husnummer:<br /><span class="help">Skriv eventuelt en ekstra husnummer-linje her. Fx. 1. sal, til højre ...</span>';
$_['entry_company']        = 'CVR-nr.:<br /><span class="help">Skriv venligst din virksomheds CVR-nummer i dette felt.</span>';

// Error
$_['error_deu_terms']      = 'Du skal acceptér Klarnas privatlivspolitik';
$_['error_address_match']  = 'Forsendelses- og fakturaadresse skal være den samme for at benytte Klarna.';
$_['error_network']        = 'En fejl opstod under etablering af forbindelse til Klarna.';
?>
