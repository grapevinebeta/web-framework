<?php

/**
 * FreshBooks Callbacks Class
 *
 *
 * @package    FreshBooks
 * @copyright  Milan Rukavina, rukavinamilan@gmail.com
 * @author     Andrew Greenstreet, andrew@gstreetmedia.com   
 * @version    1.0
 */
include_once 'ElementAction.php';
include_once 'Element/Interface.php';
include_once 'ElementAction/Interface.php';

/**
 * Class representing task API 
 */
class FreshBooks_Callback extends FreshBooks_ElementAction implements FreshBooks_Element_Interface, FreshBooks_ElementAction_Interface {

    protected $_elementName = "callback";
    public $callback_id = "";
    public $uri = "";
    public $event = "";
    public $verified = "";
    public $verifier = "";

    /**
     * return XML string
     */
    public function asXML() {
        $content =
                $this->_getTagXML("callback_id", $this->callback_id) .
                $this->_getTagXML("uri", $this->uri) .
                $this->_getTagXML("event", $this->event) .
                $this->_getTagXML("verified", $this->verified) .
                $this->_getTagXML("verifier", $this->verifier);

        return $this->_getTagXML("callback", $content);
    }

    /**
     * load obect properties from SimpleXML object
     */
    protected function _internalLoadXML(&$XMLObject) {
        $this->callback_id = (string) $XMLObject->callback_id;
        $this->uri = (string) $XMLObject->uri;
        $this->event = (string) $XMLObject->event;
        $this->verified = (string) $XMLObject->verified;
        //Note verifier is never part of any freshbooks response, and thus does
        //and this does not need parsing
    }

    /**
     * prepare XML string request for CREATE server method
     */
    protected function _internalPrepareCreate(&$content) {
        $content = $this->asXML();
    }

    /**
     * process XML string response from CREATE server method
     */
    protected function _internalCreate($responseStatus, &$XMLObject) {
        if ($responseStatus) {
            $this->callback_id = (string) $XMLObject->callback_id;
        }
    }

    /**
     * prepare XML string request for UPDATE server method
     */
    protected function _internalPrepareUpdate(&$content) {
        $content = $this->asXML();
    }

    /**
     * process XML string response from UPDATE server method
     */
    protected function _internalUpdate($responseStatus, &$XMLObject) {
        //
    }

    /**
     * prepare XML string request for GET server method
     */
    protected function _internalPrepareGet($id, &$content) {
        $content = $this->_getTagXML("callback_id", $id);
    }

    /**
     * process XML string response from GET server method
     */
    protected function _internalGet($responseStatus, &$XMLObject) {
        if ($responseStatus)
            $this->_internalLoadXML($XMLObject->callback_id);
    }

    /**
     * prepare XML string request for DELETE server method
     */
    protected function _internalPrepareDelete(&$content) {
        $content = $this->_getTagXML("callback_id", $this->callback_id);
    }

    /**
     * process XML string response from DELETE server method
     */
    protected function _internalDelete($responseStatus, &$XMLObject) {
        if ($responseStatus) {
            unset($this->callback_id);
            unset($this->uri);
            unset($this->event);
            unset($this->verified);
        }
    }

    public function verify() {
        $this->_internalPrepareVerify($content);
        $responseXML = $this->_sendRequest($content, "verify");
        $responseStatus = $this->_processResponse($responseXML);
        $this->_internalVerify($responseStatus, $responseXML);
        return $responseStatus;
    }

    protected function _internalPrepareVerify(&$content) {
        $content = $this->asXML();
    }

    protected function _internalVerify($responseStatus, &$XMLObject) {
        if ($responseStatus)
            $this->_internalLoadXML($XMLObject->callback_id);
    }

    public function resendToken() {
        $this->_internalPrepareVerify($content);
        $responseXML = $this->_sendRequest($content, "verify");
        $responseStatus = $this->_processResponse($responseXML);
        $this->_internalVerify($responseStatus, $responseXML);
        return $responseStatus;
    }

    protected function _internalPrepareResendToken(&$content) {
        $content = $this->_getTagXML("callback_id", $this->callback_id);
    }

    protected function _internalResendToken($responseStatus, &$XMLObject) {

    }

    /**
     * prepare XML string request for LIST server method
     */
    protected function _internalPrepareListing($filters, &$content) {
        if (is_array($filters) && count($filters)) {
            $content .= $this->_getTagXML("project_id", $filters['projectId']);
        }
    }

    /**
     * process XML string response from LIST server method
     */
    protected function _internalListing($responseStatus, &$XMLObject, &$rows, &$resultInfo) {
        $rows = array();
        $resultInfo = array();
        $callbacks = $XMLObject->callbacks;
        $resultInfo['page'] = (string) $callbacks['page'];
        $resultInfo['perPage'] = (string) $callbacks['per_page'];
        $resultInfo['pages'] = (string) $callbacks['pages'];
        $resultInfo['total'] = (string) $callbacks['total'];

        foreach ($callbacks->children() as $key => $currXML) {
            $thisCallbacks = new FreshBooks_Callback();
            $thisCallbacks->_internalLoadXML($currXML);
            $rows[] = $thisCallbacks;
        }
    }

}
