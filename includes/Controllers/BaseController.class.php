<?php
/**
 * BaseController
 * Extended by all controllers
 * 
 * @package mci
 * @author Zhehai He
 * @copyright 2015
 * @version 0.1
 * @access public
 */
class BaseController{
    public $blnIsAjax = false;
    public $blnSuccess = false;
    public $aryExtra = array();
    public $aryRequest = array();
    public $aryErrorMsgList = array();

    /**
     * Load Template
     * @param string $strTemplateName
     * @param boolean $echo
     * @return  string
     */
    public function loadTemplate( $strTemplateName = null, $echo = false ){
        ob_start();
        include ( INCLUDESPATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . ( $strTemplateName ? $strTemplateName : $this->strTemplateName ) . '.php');
        $html =  ob_get_clean();
        if( $echo )
            echo $html;
        return $html;
    }

    /**
     * Render Template
     * For requests from page actions
     * @param boolean $echo
     * @return string
     */
    public function render($echo = true){
        $html = $this->loadTemplate(false);
        if ( !$this->blnIsAjax ){
            if ($echo)
                echo $html;
            return $html;
        }

        $objExport = new stdClass();

        $objExport->html = $html;
        $objExport->success = $this->blnSuccess;

        if (is_array($this->aryExtra)) 
            foreach ($this->aryExtra as $strKey => $value)
                $objExport->$strKey = $value;

        if ($echo)
            echo json_encode($objExport);
        
        return json_encode($objExport);
    }

    /**
     * Get Request Data
     * @param string $strKey
     * @return mix data
     */
    public function getRequest( $strKey ){
        return array_key_exists( $strKey, $this->aryRequest ) ? $this->aryRequest[$strKey] : null;
    }
    
    /**
     * Get Error Message
     * @param string $strKey
     * @return string
     */
    public function getErrorMsg( $strKey ){
        return array_key_exists( $strKey, $this->aryErrorMsgList ) ? $this->aryErrorMsgList[$strKey] : null;
    }
}
