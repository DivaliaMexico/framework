<?php
/**
 * Whoops Debugger
 * Uncomment this if you want use whoops debuger
 */

use Whoops\Handler\PrettyPageHandler;

// use Whoops\Handler\JsonResponseHandler;

$WhoopsRun     = new Whoops\Run;
$WhoopsHandler = new PrettyPageHandler;

// Add some custom tables with relevant info about your application,
// that could prove useful in the error page:
// $WhoopsHandler->addDataTable('Killer App Details', array(
//   "Important Data" => $myApp->getImportantData(),
//   "Thingamajig-id" => $someId
// ));

// Set the title of the error page:
$WhoopsHandler->setPageTitle( "Whoops! There was a problem." );

$WhoopsRun->pushHandler( $WhoopsHandler );

// Add a special handler to deal with AJAX requests with an
// equally-informative JSON response. Since this handler is
// first in the stack, it will be executed before the error
// page handler, and will have a chance to decide if anything
// needs to be done.
// $WhoopsRun->pushHandler(new JsonResponseHandler);

// Register the handler with PHP, and you're set!
$WhoopsRun->register();
