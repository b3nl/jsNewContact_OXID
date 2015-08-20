<?php

    /**
     * Module-Metadata for the jsNewContact_OXID.
     * @author     jschuster <juliana.schuster@pixolith.de>
     * @category   modules
     * @package    jsNewContact_OXID
     * @subpackage oxAutoload
     * @version    SVN: $Id$
     */

    $sMetadataVersion = '1.0';

    $aModule = array(
        'author'      => 'Juliana Schuster',
        'description' => array(
            'de' => 'Neues Kontaktformular für den OXID eShop',
            'en' => 'New contact form for the OXID eShop'
        ),
        'email'       => 'juliana.schuster@pixolith.de',
        'title'       => 'OXID jsNewContact',
        'version'     => '1.0',
        'thumbnail'   => 'js_logo.png',
        'id'          => 'jsNewContact_OXID',
        'extend'      => array(
            'contact' => 'jsNewContact_OXID/controller/jsnewcontactcontroller',
        ),
        'templates'   => array(
            'jsnewcontact_contact.tpl'      => 'jsNewContact_OXID/views/jsnewcontact_contact.tpl',
            'jsnewcontact_info_contact.tpl' => 'jsNewContact_OXID/views/jsnewcontact_info_contact.tpl',
            'jsnewcontact_notice.tpl'       => 'jsNewContact_OXID/views/jsnewcontact_notice.tpl',
            'jsnewcontact_spam.tpl'         => 'jsNewContact_OXID/views/jsnewcontact_spam.tpl',
            'jsnewcontact_phoneservice.tpl' => 'jsNewContact_OXID/views/jsnewcontact_phoneservice.tpl'
        ),
        'files'       => array(
            'jsnewcontacthandledatabase' => 'jsNewContact_OXID/controller/jsnewcontacthandledatabase.php'
        ),
        'events'      => array(
            'onActivate'   => 'jsnewcontacthandledatabase::onActivate',
            'onDeactivate' => 'jsnewcontacthandledatabase::onDeactivate',
        ),
        'settings'    => array(
            array(
                'group' => 'JS_Newcontact_OpeningTime',
                'name'  => 'bJsShowOpeningTime',
                'type'  => 'bool',
                'value' => true
            ),
            array(
                'group' => 'JS_Newcontact_Spam',
                'name'  => 'aJsSpamProtection',
                'type'  => 'arr',
                'value' => array('')
            ),
            array(
                'group' => 'JS_Newcontact_Callback',
                'name'  => 'bJsShowReturnCall',
                'type'  => 'bool',
                'value' => true
            ),
            array(
                'group' => 'JS_Newcontact_Callback',
                'name'  => 'bJsMailForReturnCall',
                'type'  => 'str',
                'value' => 'info@myoxideshop.com'
            ),
        )
    );
