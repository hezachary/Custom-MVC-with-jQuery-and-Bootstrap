<?php
/**
 * Db
 * 
 * @package mci
 * @author Zhehai He
 * @copyright 2015
 * @version 0.1
 * @access public
 */
class Db {
    
    private $_dbh;
    
    /**
     * __construct
     * Establish db connection via PDO
     */
    public function __construct(){
        try {
            $this->_dbh = new PDO( DB_PDO, DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    
    /**
     * Insert data into DB
     * @param string $strTable
     * @param array $aryData, Associative Array
     * @return string, insert Id
     **/
    public function insert( $strTable, $aryData ){
        $strQuery = sprintf( 'INSERT INTO `' . $strTable . '` ( `%s` ) VALUES ( %s )', implode( '`,`', array_keys( $aryData ) ), implode( ', ', array_fill( 0, sizeof( $aryData ), '?' ) ) );
        $sth = $this->_dbh->prepare( $strQuery );
        $sth->execute( array_values( $aryData ) );
        return $this->_dbh->lastInsertId();
    }
    
    /**
     * Send Email to Admin
     * @param string $strName
     * @param array $aryData, Associative Array
     * @return boolean
     **/
    public function emailLog( $strName, $aryData ){
        //recipients
        $strTo  = ADMIN_EMAIL;

        // subject
        $strSubject = sprintf( CONTACT_EMAIL_SUBJECT, $strName );

        // message
        $objController = new BaseController();
        $objController->strTemplateName = 'email_log';
        $objController->aryRequest = $aryData;
        $strMessage = $objController->loadTemplate();

        // To send HTML mail, the Content-type header must be set
        $strHeaders  = 'MIME-Version: 1.0' . "\r\n";
        $strHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        //debug: print_r( array( $strTo, $strSubject, $strMessage, $strHeaders ) ) ;die();
        
        // Mail it
        return mail( $strTo, $strSubject, $strMessage, $strHeaders );
    }
}