<?php

// działamy w srodowisku deweloperskim
define('APPLICATION_ENV', 'development');

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once '/../../library/Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$loader = Zend_Loader_Autoloader::getInstance();
$loader->pushAutoloader(array('Noodle_Crons_checkTheTests', 'checkthetests'));

$application->getBootstrap()->bootstrap('checkthetests');

$checkTheTests = new Noodle_Crons_checkTheTests();
$checkTheTests->checkthetests();
