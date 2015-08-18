<?php

    /**
     * Main controller for the snippet
     */
    class jsnewcontacthandledatabase
    {
        /**
         * Module activation script: executes the sql to create the snippet.
         */
        public static function onActivate()
        {
            jsnewcontacthandledatabase::onDeactivate();
            $oDb = oxDb::getDb();

            $create_sql = "INSERT INTO `oxcontents` (`OXID`, `OXLOADID`, `OXSHOPID`, `OXSNIPPET`, `OXTYPE`, `OXACTIVE`, `OXACTIVE_1`, `OXPOSITION`, `OXTITLE`, `OXCONTENT`, `OXTITLE_1`, `OXCONTENT_1`, `OXACTIVE_2`, `OXTITLE_2`, `OXCONTENT_2`, `OXACTIVE_3`, `OXTITLE_3`, `OXCONTENT_3`, `OXCATID`, `OXFOLDER`, `OXTERMVERSION`) VALUES
                        ('5138685f66ec2613ff84b8e0b073c712', 'openingHours', 'oxbaseshop', 1, 0, 1, 0, '', 'Öffnungszeiten im Kontaktformular', '<b>Ihre Öffnungszeiten<b>', '', '', 0, '', '', 0, '', '', '943a9ba3050e78b443c16e043ae60ef3', '', '')";

            $oDb->execute($create_sql);
            return true;
        }

        /**
         * Module deactivation script: executes the sql to delte the snippet.
         */
        public static function onDeactivate()
        {
            $oDb = oxDb::getDb();

            $delete_sql = "DELETE FROM `oxcontents` WHERE `OXLOADID` = 'openingHours'";
            $oDb->execute($delete_sql);
            return true;
        }

    }
