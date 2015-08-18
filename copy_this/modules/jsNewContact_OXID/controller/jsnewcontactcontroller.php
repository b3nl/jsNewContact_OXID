<?php

    /**
     * Main controller for the contactform
     */
    class jsnewcontactcontroller extends jsnewcontactcontroller_parent
    {
        /**
         * Entered user data.
         *
         * @var array
         */
        protected $_aUserData = null;

        /**
         * Entered contact subject.
         *
         * @var string
         */
        protected $_sContactSubject = null;

        /**
         * Entered time for the callback.
         *
         * @var string
         */
        protected $_sCallbackTime = null;

        /**
         * Entered conatct message.
         *
         * @var string
         */
        protected $_sContactMessage = null;

        /**
         * Contact email send status.
         *
         * @var object
         */
        protected $_blContactSendStatus = null;

        /**
         * Contact email spam status.
         *
         * @var object
         */
        protected $_blSpamStatus = null;

        /**
         * Current class template name.
         *
         * @var string
         */
        protected $_sThisTemplate = 'jsnewcontact_info_contact.tpl';

        /**
         * Current view search engine indexing state
         *
         * @var int
         */
        protected $_iViewIndexState = VIEW_INDEXSTATE_NOINDEXNOFOLLOW;

        /**
         * Whether or not json output has already taken place
         *
         * @var bool
         */
        protected $_blJsonOut = false;

        /**
         * Composes and sends user written message, returns false if some parameters
         * are missing.
         *
         * @return bool
         */
        public function send()
        {
            $aParams = oxRegistry::getConfig()->getRequestParameter('editval');

            // checking email address
            if (!oxRegistry::getUtils()->isValidEmail($aParams['oxuser__oxusername'])) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay('ERROR_MESSAGE_INPUT_NOVALIDEMAIL');

                return false;
            }

            $sSubject = oxRegistry::getConfig()->getRequestParameter('c_subject');
            if (!$aParams['oxuser_oxfnameandlname'] || !$aParams['oxuser__oxusername'] || !$sSubject) {
                // even if there is no exception, use this as a default display method
                oxRegistry::get("oxUtilsView")->addErrorToDisplay('ERROR_MESSAGE_INPUT_NOTALLFIELDS');

                return false;
            }

            $oLang    = oxRegistry::getLang();
            $sMessage = $oLang->translateString('MESSAGE_FROM') . " " .
                $oLang->translateString($aParams['oxuser__oxsal']) . " " .
                $aParams['oxuser_oxfnameandlname'] . " " .
                $aParams['oxuser__oxlname'] . " " . $aParams['oxuser__oxcompany'] . " (" . $aParams['oxuser__oxusername'] . ")<br /><br />" .
                $sOnlyMessage = nl2br(oxRegistry::getConfig()->getRequestParameter('c_message'));

            $aSpamwords = $this->getConfig()->getConfigParam('aJsSpamProtection');
            if($aSpamwords == 0) {
                foreach ($aSpamwords as $sSpamword) {
                    $sSpamwordToLower = strtolower($sSpamword);
                    if (strpos(strtolower($sSubject),
                            $sSpamwordToLower) !== false || strpos(strtolower($aParams['oxuser__oxusername']),
                            $sSpamwordToLower) !== false || strpos(strtolower($aParams['oxuser_oxfnameandlname']),
                            $sSpamwordToLower) !== false || strpos(strtolower($aParams['oxuser__oxcompany']),
                            $sSpamwordToLower) !== false || strpos(strtolower($sOnlyMessage),
                            $sSpamwordToLower) !== false
                    ) {
                        $this->_blSpamStatus = 1;
                        return false;
                    }
                }
            }
            $oEmail = oxNew('oxemail');
            if ($oEmail->sendContactMail($aParams['oxuser__oxusername'], $sSubject, $sMessage)) {
                $this->_blContactSendStatus = 1;
            } else {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay('ERROR_MESSAGE_CHECK_EMAIL');
            }
        }

        /**
         * Template variable getter. Returns entered user data
         *
         * @return object
         */
        public function getUserData()
        {
            if ($this->_oUserData === null) {
                $this->_oUserData = oxRegistry::getConfig()->getRequestParameter('editval');
            }

            return $this->_oUserData;
        }

        /**
         * Template variable getter. Returns entered contact subject
         *
         * @return object
         */
        public function getContactSubject()
        {
            if ($this->_sContactSubject === null) {
                $this->_sContactSubject = oxRegistry::getConfig()->getRequestParameter('c_subject');
            }

            return $this->_sContactSubject;
        }

        /**
         * Template variable getter. Returns entered time for the callback
         *
         * @return object
         */
        public function getCallBackTime()
        {
            if ($this->_sCallbackTime === null) {
                $this->_sCallbackTime = oxRegistry::getConfig()->getRequestParameter('c_callback');
            }

            return $this->_sCallbackTime;
        }

        /**
         * Template variable getter. Returns entered message
         *
         * @return object
         */
        public function getContactMessage()
        {
            if ($this->_sContactMessage === null) {
                $this->_sContactMessage = oxRegistry::getConfig()->getRequestParameter('c_message');
            }

            return $this->_sContactMessage;
        }

        /**
         * Template variable getter. Returns status if email was send succesfull
         *
         * @return object
         */
        public function getContactSendStatus()
        {
            return $this->_blContactSendStatus;
        }

        /**
         * Template variable getter. Returns status if in the email is a spam word
         *
         * @return object
         */
        public function getSpamStatus()
        {
            return $this->_blSpamStatus;
        }

        /**
         * Returns Bread Crumb - you are here page1/page2/page3...
         *
         * @return array
         */
        public function getBreadCrumb()
        {
            $aPaths = array();
            $aPath  = array();

            $aPath['title'] = oxRegistry::getLang()
                ->translateString('CONTACT', oxRegistry::getLang()->getBaseLanguage(),
                    false);
            $aPath['link']  = $this->getLink();
            $aPaths[]       = $aPath;

            return $aPaths;
        }

        /**
         * Page title
         *
         * @return string
         */
        public function getTitle()
        {
            return $this->getConfig()->getActiveShop()->oxshops__oxcompany->value;
        }

        /**
         * Deactivates the openigHours Snippet
         *
         * @return bool
         */
        public function deactivateOpeningHours()
        {
            $oDb = oxDb::getDb();

            $sql = "UPDATE `oxcontents` SET `OXACTIVE` = '0' WHERE `OXLOADID` = 'openingHours'";
            $oDb->execute($sql);
        }

        /**
         * Activates the openigHours Snippet
         *
         * @return bool
         */
        public function activateOpeningHours()
        {
            $oDb = oxDb::getDb();

            $sql = "UPDATE `oxcontents` SET `OXACTIVE` = '1' WHERE `OXLOADID` = 'openingHours'";
            $oDb->execute($sql);
        }

        public function send_email()
        {
            $aParams    = oxRegistry::getConfig()->getRequestParameter('editval');
            $sCallback  = oxRegistry::getConfig()->getRequestParameter('c_callback');
            $aSpamwords = $this->getConfig()->getConfigParam('aJsSpamProtection');
            $sMail      = $this->getConfig()->getConfigParam('bJsMailForReturnCall');
            $activeView = oxRegistry::getConfig()->getRequestParameter('view');
            $sNoContent = "Keine Angabe";

            // Testing
	    sleep(2);

            if ($sCallback) {
                $sCallbackTime = $sCallback;
            } else {
                $sCallbackTime = $sNoContent;
            }
            if($aSpamwords == 0) {
                foreach ($aSpamwords as $sSpamword) {
                    $sSpamwordToLower = strtolower($sSpamword);
                    if (strpos(strtolower($sCallback),
                            $sSpamwordToLower) !== false || strpos(strtolower($aParams['oxuser__oxfon']),
                            $sSpamwordToLower) !== false || strpos(strtolower($aParams['oxuser_oxfnameandlname']),
                            $sSpamwordToLower) !== false
                    ) {
                        $this->return_json(["success" => 0, "spam" => 1]);
                        return false;
                    }
                }
            }

            $callbackMessage = "Es wurde ein Rückruf angefordert von: " . "\n" . "\n" .
                "Telefonnummer : " . $aParams['oxuser__oxfon'] . "\n" .
                "Name : " . $aParams['oxuser_oxfnameandlname'] . "\n" .
                "Wann sollen wir Sie zurückrufen? : " . $sCallbackTime . "\n" .
                "Die Anfrage wurde von dieser Seite aus gesendet : " . $activeView;

            $bSuccess = mail($sMail, 'Rückrufanfrage von ' . $aParams['oxuser_oxfnameandlname'], $callbackMessage ,"Mime-Version: 1.0\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: quoted-printable");
            $this->return_json(["success" => $bSuccess, "spam" => 0]);
        }

        protected function return_json($aParam)
        {
            if ($this->_blJsonOut) {
                return false;
            }

            ini_set('display_errors', 0);
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: text/json");

            // Flag json out
            $this->_blJsonOut     = true;
            $this->_sThisTemplate = "";

            echo json_encode($aParam);
        }
    }
