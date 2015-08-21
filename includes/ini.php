<?php
/**
 * Use closure to load class files
 * **/
spl_autoload_register( function($strClassName){
    $aryClassNameList = preg_split('/(?=[A-Z])/',$strClassName);
    $strFileName = INCLUDESPATH . DIRECTORY_SEPARATOR ;
    switch( $aryClassNameList[ sizeof( $aryClassNameList ) - 1 ] ){
        case 'Controller':
            $strFileName .= 'Controllers' . DIRECTORY_SEPARATOR . $strClassName . '.class.php';
            break;
        case 'Ext':
            $strFileName .= 'Extensions' . DIRECTORY_SEPARATOR . $strClassName . '.php';
            break;
        default:
            $strFileName .= 'Models' . DIRECTORY_SEPARATOR . $strClassName . '.class.php';
            break;
    }
    require_once( $strFileName );
});


