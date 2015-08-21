<?php
/**
 * ContactUs
 * 
 * @package mci
 * @author Zhehai He
 * @copyright 2015
 * @version 0.1
 * @access public
 */
class ContactUs {
    const STR_TABLE = 'contact';
    public $aryData = array();
    
    /**
     * __construct
     * @param array $aryData
     */
    public function __construct( $aryData = array() ){
        if( $aryData && is_array( $aryData ) && sizeof( $aryData ) ){
            $this->aryData = $aryData;
        }
    }
    
    /**
     * save into db and send email
     * @return array, array( int - insert id, boolean - send email )
     */
    public function save(){
        //1. save to db
        $this->aryData = array(
            'firstname' => $this->aryData['firstname'],
            'lastname' => $this->aryData['lastname'],
            'dob' => $this->aryData['dob'],
            'email' => $this->aryData['email'],
            'comments' => $this->aryData['comments'],
            'timestamp' => time(),
            'ip' => ToolsExt::retrieveUserIp(),
        );
        
        $objDb = new Db();
        $id = $objDb->insert( self::STR_TABLE, $this->aryData );
        
        //2. send email
        $blnSendEmail = false;
        if( $id ){
            $this->aryData['timestamp'] = date( 'Y-m-d H:i:s', $this->aryData['timestamp'] );
            $blnSendEmail = $objDb->emailLog( $this->aryData['firstname'] . ' ' . $this->aryData['lastname'], $this->aryData );
        }
        
        //3. return id
        return array( $id, $blnSendEmail);
    }
}