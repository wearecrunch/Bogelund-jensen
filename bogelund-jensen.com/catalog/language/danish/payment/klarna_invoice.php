<?php
// Text
$_['text_title']       = 'Klarna faktura';
$_['text_fee']         = 'Klarna faktura - Betal inden for 14 dage <span id="klarna_invoice_toc_link"></span> (+%s)<script text="javascript\">$.getScript(\'http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js\', function(){ var terms = new Klarna.Terms.Invoice({ el: \'klarna_invoice_toc_link\', eid: \'%s\', country: \'%s\', charge: %s});})</script>';
$_['text_no_fee']      = 'Klarna faktura - Betal inden for 14 dage <span id="klarna_invoice_toc_link"></span><script text="javascript">$.getScript(\'http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js\', function(){ var terms = new Klarna.Terms.Invoice({ el: \'klarna_invoice_toc_link\', eid: \'%s\', country: \'%s\'});})</script>';
$_['text_additional']  = 'Klarna kræver yderligere oplysninger for de kan behandle din ordre.';
$_['text_wait']        = 'Vent venligst!';
$_['text_male']        = 'Mand';
$_['text_female']      = 'Kvinde';
$_['text_year']        = 'Year';
$_['text_month']       = 'Month';
$_['text_day']         = 'Day';
$_['text_comment']     = 'Klarna\'s Invoice ID: %s\n%s/%s: %.4f';

// Entry
$_['entry_gender']     = 'Køn:';
$_['entry_pno']        = 'Fødselsdag:<span class="help">(DDMMÅÅÅÅ)</span>';
$_['entry_dob']        = 'Fødselsdato:';
$_['entry_phone_no']   = 'Telefonnr.:<br /><span class="help">Please enter your phone number.</span>';
$_['entry_street']     = 'Vejnavn:<br /><span class="help">Please note that delivery can only take place to the registered address when paying with Klarna.</span>';
$_['entry_house_no']   = 'Husnr.:';
$_['entry_house_ext']  = 'Ekstra husnr.:';
$_['entry_cellno']     = 'Mobiltelefon:';

// Error
$_['error_deu_terms']      = 'Du skal acceptér Klarnas privatlivspolitik';
$_['error_address_match']  = 'Forsendelses- og fakturaadresse skal være den samme for at benytte Klarna.';
$_['error_network']        = 'En fejl opstod under etablering af forbindelse til Klarna.';
?>