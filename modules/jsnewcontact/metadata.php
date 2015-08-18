<?php
    /**
     * Module-Metadata for the JS New Contact.
     * @author     jschuster <juliana.schuster@pixolith.de>
     * @category   modules
     * @package    js_jsnewcontact
     * @subpackage oxAutoload
     * @version    SVN: $Id$
     */

    $sMetadataVersion = '1.0';

    $aModule = array(
        'author'      => 'Juliana Schuster',
        'description' => array(
            'de' => 'neues Kontaktformular für den Oxid eshop',
            'en' => 'new contact form for the oxid eshop'
        ),
        'email'       => 'juliana.schuster@pixolith.de',
        'title'       => 'JS New Contact',
        'version'     => '1.0',
        'id'          => 'jsnewcontact',
        'extend'      => array(
            'contact' => 'jsnewcontact/controller/jsnewcontactcontroller',
        ),
        'templates'   => array(
            'jsnewcontact_contact.tpl'      => 'jsnewcontact/views/jsnewcontact_contact.tpl',
            'jsnewcontact_info_contact.tpl' => 'jsnewcontact/views/jsnewcontact_info_contact.tpl',
            'jsnewcontact_notice.tpl'       => 'jsnewcontact/views/jsnewcontact_notice.tpl',
            'jsnewcontact_spam.tpl'         => 'jsnewcontact/views/jsnewcontact_spam.tpl',
            'jsnewcontact_phoneservice.tpl' => 'jsnewcontact/views/jsnewcontact_phoneservice.tpl'
        ),
        'files'       => array(
            'jsnewcontacthandledatabase' => 'jsnewcontact/controller/jsnewcontacthandledatabase.php'
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
