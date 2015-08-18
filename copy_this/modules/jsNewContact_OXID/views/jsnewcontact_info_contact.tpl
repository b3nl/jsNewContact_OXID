[{oxstyle include=$oViewConf->getModuleUrl('jsNewContact_OXID','out/css/contact.css')}]
[{oxscript include=$oViewConf->getModuleUrl('jsNewContact_OXID','out/js/jsnewcontactphoneservice.js')}]
[{capture append="oxidBlock_content"}]
[{assign var='oConfig'  value=$oViewConf->getConfig()}]
[{assign var='bOpening' value=$oConfig->getConfigParam('bJsShowOpeningTime')}]
[{if $oView->getContactSendStatus() && !$oView->getSpamStatus()}]
    [{assign var="_statusMessage" value="THANK_YOU_MESSAGE"|oxmultilangassign:$oxcmp_shop->oxshops__oxname->value}]
    [{include file="jsnewcontact_notice.tpl" statusMessage=$_statusMessage}]
    [{/if}]
[{if $oView->getSpamStatus() }]
    [{assign var="_statusMessage" value="JS_NEWCONTACT_SPAM_MESSAGE"|oxmultilangassign:$oxcmp_shop->oxshops__oxname->value}]
    [{include file="jsnewcontact_spam.tpl" statusMessage=$_statusMessage}]
    [{/if}]

    <h1 class="pageHead">[{$oView->getTitle()}]</h1>
    <ul class="left">
        <li>[{ $oxcmp_shop->oxshops__oxstreet->value }]</li>
        <li>[{ $oxcmp_shop->oxshops__oxzip->value }]&nbsp;[{ $oxcmp_shop->oxshops__oxcity->value }]</li>
        <li>[{ $oxcmp_shop->oxshops__oxcountry->value }]</li>
        [{if $oxcmp_shop->oxshops__oxtelefon->value}]
        <li>[{ oxmultilang ident="PHONE" suffix="COLON" }] [{ $oxcmp_shop->oxshops__oxtelefon->value }]</li>
        [{/if}]
        [{if $oxcmp_shop->oxshops__oxtelefax->value}]
        <li>[{ oxmultilang ident="FAX" suffix="COLON" }] [{ $oxcmp_shop->oxshops__oxtelefax->value }]</li>
        [{/if}]
        [{if $oxcmp_shop->oxshops__oxinfoemail->value}]
        <li class="snippet">[{ oxmultilang ident="EMAIL" suffix="COLON" }]
            [{oxmailto address=$oxcmp_shop->oxshops__oxinfoemail->value encode="javascript"}]
        </li>
        [{/if}]
        [{if $bOpening}]
        [{oxcontent ident="openingHours"}]
        [{/if}]

        [{assign var='oConfig'  value=$oViewConf->getConfig()}]
        [{if $oConfig->getConfigParam('bJsShowReturnCall')}]
        <button id="jsPhone">kostenloser Rückrufservice</button>
        [{include file="jsnewcontact_phoneservice.tpl"}]
        [{/if}]
    </ul>

    [{include file="jsnewcontact_contact.tpl"}]

    [{/capture}]

[{include file="layout/page.tpl" sidebar="Left"}]