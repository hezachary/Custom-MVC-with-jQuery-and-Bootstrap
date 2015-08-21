<?php
/**
 * HomeController
 * 
 * @package mci
 * @author Zhehai He
 * @copyright 2015
 * @version 0.1
 * @access public
 */
class HomeController extends BaseController{
    /**
     * HomeController::filter()
     * The filters group for form validation
     * @param array $aryData
     * @param string $strField 
     * @param string $strSubField 
     * @return array( $success, $aryMsg, $aryResultData )
     **/
    public function filter($aryData, $strField, $strSubField = null){
        $strField = array_pop(explode('::', $strField));
        $aryControlFilterList = array(
            'index' => array(
                'firstname' => array(
                    array(
                    'call_func' => array('DataValidateExt','clear_html_string'),
                    ),
                    array(
                    'filter'    => FILTER_SANITIZE_STRING,
                    'options'   => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW,
                    ),
                    array(
                    'filter'    => FILTER_VALIDATE_REGEXP,
                    'options'   => array('regexp' => '/^(\w+){3,30}$/'),
                    'msg'       => 'Name is not valid, 3 more charactors required',
                    ),
                    'msg'   => 'Name is not valid, a-z, 0-9, _, 5 ~ 30 charactors only',
                ),
                'lastname' => array(
                    array(
                    'call_func' => array('DataValidateExt','clear_html_string'),
                    ),
                    array(
                    'filter'    => FILTER_SANITIZE_STRING,
                    'options'   => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW,
                    ),
                    array(
                    'filter'    => FILTER_VALIDATE_REGEXP,
                    'options'   => array('regexp' => '/^(\w+){2,30}$/'),
                    'msg'       => 'Name is not valid, 2 more charactors required',
                    ),
                    'msg'   => 'Name is not valid, a-z, 0-9, _, 2 ~ 30 charactors only',
                ),
                'dob' => array(
                    array(
                    'options'   => 'date::{-100 years,,today}',
                    ),
                    'msg'   => 'Date of Birth is not valid',
                ),
                'email' => array(
                    array(
                    'filter'    => FILTER_SANITIZE_EMAIL,
                    ),
                    array(
                    'filter'    => FILTER_VALIDATE_EMAIL,
                    ),
                    'msg'   => 'Email is not valid',
                ),
                'comments' => array(
                    array(
                    'call_func' => array('DataValidateExt','clear_html_string'),
                    ),
                    array(
                    'filter'    => FILTER_SANITIZE_STRING,
                    'options'   => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW,
                    ),
                    array(
                    'options'   => 'text::{1,,8000}',
                    ),
                    'msg'   => 'Comment is not valid, 1 ~ 8000 charactors only',
                ),
            ),
        );
        
        if( $strSubField ){
            if( array_key_exists( $strSubField, $aryControlFilterList[$strField] ) )
                return DataValidateExt::validate($aryData, array( $strSubField => $aryControlFilterList[$strField][$strSubField] ) );
            else
                return array( false, array(), array() );
        }
        
        return DataValidateExt::validate($aryData, $aryControlFilterList[$strField]);
    }
        
    /**
     * index, default action
     **/
    public function index(){
        $this->strTemplateName = 'home';
        if( $_POST && $_POST['mode'] == 'submit' ){
            $_POST['dob'] = sprintf( '%s-%02s-%02s', (int)$_POST['dob-yyyy'] ? $_POST['dob-yyyy'] : '', (int)$_POST['dob-mm'] ? $_POST['dob-mm'] : '', (int)$_POST['dob-dd'] ? $_POST['dob-dd'] : '' );
            //die($_POST['dob']);
            list($this->blnSuccess, $this->aryErrorMsgList, $this->aryRequest) = $this->filter( $_POST, __METHOD__ );
            if( $this->blnSuccess ){
                $objContactUs = new ContactUs( $this->aryRequest );
                list( $intContactUsID, $blnSendEmail) = $objContactUs->save();
                if ( $intContactUsID && $blnSendEmail ){
                    header('Location: ?action=thankyou');
                    exit;
                }
            }else{
                $this->_setBackDob($_POST);
            }
        }
    }
    
    /**
     * ajax, accept POST only
     * for validate individual form field
     **/
    public function ajax(){
        if( !$_POST || !array_key_exists('field', $_POST) || !array_key_exists('value', $_POST) )
            return;
        
        $this->blnIsAjax = true;
        
        $aryData = array( $_POST['field'] => $_POST['value'] );
        if( $_POST['field'] == 'dob' ){
            $aryData[ $_POST['field'] ] = sprintf( '%s-%02s-%02s', (int)$_POST['value'][0] ? $_POST['value'][0] : '', (int)$_POST['value'][1] ? $_POST['value'][1] : '', (int)$_POST['value'][2] ? $_POST['value'][2] : '' );
        }
        
        list($this->blnSuccess, $this->aryErrorMsgList, $this->aryRequest) = $this->filter( $aryData, 'index', $_POST['field'] );
        
        $_POST['dob-yyyy'] = $_POST['value'][0];
        $_POST['dob-mm'] = $_POST['value'][1];
        $_POST['dob-dd'] = $_POST['value'][2];
        
        $this->_setBackDob($_POST);
        
        $this->strTemplateName = 'home.' . key( $this->aryRequest );
    }
    
    public $blnFormSuccess = false;
    
    /**
     * thankyou page, load after success form submit
     **/
    public function thankyou(){
        $this->strTemplateName = 'home';
        $this->blnFormSuccess = true;
    }
    
    /**
     * Set Date string back to three $this->aryRequest fields (year, month, date)
     **/
    private function _setBackDob($aryPost){
        if( array_key_exists('dob', $this->aryErrorMsgList) ){
            $this->aryRequest['dob-yyyy'] = (int)$aryPost['dob-yyyy'] ? $aryPost['dob-yyyy'] : '';
            $this->aryRequest['dob-mm'] = (int)$aryPost['dob-mm'] ? $aryPost['dob-mm'] : '';
            $this->aryRequest['dob-dd'] = (int)$aryPost['dob-dd'] ? $aryPost['dob-dd'] : '';
        }elseif( array_key_exists('dob', $this->aryRequest) ){
            $intDOB = strtotime( $this->aryRequest['dob'] );
            $this->aryRequest['dob-yyyy'] = date( 'Y', $intDOB );
            $this->aryRequest['dob-mm'] = date( 'm', $intDOB );
            $this->aryRequest['dob-dd'] = date( 'd', $intDOB );
        }
    }
}