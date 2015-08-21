<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'config.php' );

/** Since there is only one page, no need for router, call page controller directly*/
$objController = new HomeController();

$strAction = !$_REQUEST || !array_key_exists( 'action', $_REQUEST ) || !method_exists( $objController, $_REQUEST['action'] ) ? 'index' : $_REQUEST['action'];

$objController->$strAction();

$objController->render();

exit;