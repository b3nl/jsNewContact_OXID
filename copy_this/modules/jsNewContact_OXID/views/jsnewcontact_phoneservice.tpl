[{oxstyle include=$oViewConf->getModuleUrl('jsNewContact_OXID','out/css/contact.css')}]
[{oxscript include=$oViewConf->getModuleUrl('jsNewContact_OXID','out/js/jsnewcontactphoneservice.js')}]
<div style="display:none;" id="dialog-form" title="[{ oxmultilang ident="JS_NEWCONTACT_PHONE_HEADER"}]">
<section js data-stage="prepare">
    <p>Nennen Sie und Ihre Telefonnummer und Ihren Namen, wir rufen Sie gerne an.</p>

    <p>Pflichangangaben sind mit einem * gekennzeichnet.</p>
    [{oxscript include="js/widgets/oxinputvalidator.js" priority=10 }]
    [{oxscript add="$('form.js-oxValidate').oxInputValidator();"}]
    <form class="js-oxValidate" name="Kontakt" action="[{ $oViewConf->getSslSelfLink() }]" method="post">
        <div>
            [{ $oViewConf->getHiddenSid() }]
            <input type="hidden" name="fnc" value="send_email"/>
            <input type="hidden" name="cl" value="contact"/>
            <input type="hidden" name="view" value="[{ $oViewConf->getActiveClassName() }]"/>
        </div>
        <fieldset>
            <li [{if $aErrors.oxuser__oxfon}]class="oxInValid" [{/if}]>
                <label class="req" for="phone">[{ oxmultilang ident="JS_NEWCONTACT_LABEL_FOR_PHONE" suffix="COLON"
                    }]*</label>
                <input type="text" class="phone js-oxValidate js-oxValidate_notEmpty" size="40"
                       maxlength="[{$edit->oxuser__oxfon->fldmax_length}]" name="editval[oxuser__oxfon]"
                       value="[{if $oxcmp_user && !$editval.oxuser__oxfon}][{$oxcmp_user->oxuser__oxfon->value}][{else}][{$editval.oxuser__oxfon}][{/if}]">

                <p class="oxValidateError errorPhone">
                    <span class="js-oxError_notEmpty">[{ oxmultilang ident="ERROR_MESSAGE_INPUT_NOTALLFIELDS" }]</span>
                </p>
            </li>
            <li [{if $aErrors.oxuser__oxfname}]class="oxInValid" [{/if}]>
                <label class="req" for="name">[{ oxmultilang ident="JS_NEWCONTACT_FIRST_AND_LAST_NAME" suffix="COLON"
                    }]*</label>
                <input type="text" size="40" maxlength="40"
                       name="editval[oxuser_oxfnameandlname]"
                       value="[{if $oxcmp_user && !$editval.oxuser__oxfname && !$editval.oxuser__oxlname}][{$oxcmp_user->oxuser__oxfname->value}] [{$oxcmp_user->oxuser__oxlname->value}][{else}][{$editval.oxuser__oxfname && $editval.oxuser__oxlname}][{/if}]"
                       class="phone js-oxValidate js-oxValidate_notEmpty">

                <p class="oxValidateError errorPhone">
                    <span class="js-oxError_notEmpty">[{ oxmultilang ident="ERROR_MESSAGE_INPUT_NOTALLFIELDS" }]</span>
                </p>
            </li>
            <li>
                <label class="req" for="returnCall">[{ oxmultilang ident="JS_NEWCONTACT_LABEL_FOR_RETURNCALL"}]</label>
                <input type="text" size="40" maxlength="40"
                       name="c_callback" }]" value="So schnell wie möglich"
                class="phone">
            </li>
            <!— Allow form submission with keyboard without duplicating the dialog button —>
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</section>
<section js data-stage="send" class="loading">
    <p>Ihre Eingaben werden übertragen, bitte gedulden Sie sich einen Augenblick ...</p></br>
    <img src="../modules/jsNewContact_OXID/out/img/ajax-loader.gif" alt="loading-image">
</section>
<section js data-stage="exit" style="display: none;">
    <!-- Ajax return status messages -->
    [{assign var="_statusMessageSpam" value="JS_NEWCONTACT_SPAM_MESSAGE"|oxmultilangassign:$oxcmp_shop->oxshops__oxname->value}]
    [{assign var="_statusMessageSuccess" value="THANK_YOU_MESSAGE"|oxmultilangassign:$oxcmp_shop->oxshops__oxname->value}]
    [{assign var="_statusMessageError" value="JS_NEWCONTACT_ERROR_MESSAGE"|oxmultilangassign:$oxcmp_shop->oxshops__oxname->value}]
	<span class="ajax_callback_messages">
            <div class="status error corners hidden" data-on-ajax="spam_detected">
                <p>[{ $_statusMessageSpam }]</p>
            </div>
         <div class="top" data-on-ajax="spam_detected">
             <p>Bitte schicken Sie keine Spam-Nachrichten</br>Danke!</p>
         </div>

        <div class="goodStatus corners hidden" data-on-ajax="success_detected">
            <p>[{ $_statusMessageSuccess }]</p>
        </div>

        <div class="top" data-on-ajax="success_detected">
            <p>Vielen Dank für Ihre Anfrage!<p>
            <p>Ihre Rückrufanforderung ist gerade bei uns eingegangen.</p>
            <p>Wir rufen Sie gerne zurück.</p>
        </div>

            <div class="status error corners hidden" data-on-ajax="communication_error">
                <p>[{ $_statusMessageError }]</p>
            </div>
        </span>
</section>
</div>
