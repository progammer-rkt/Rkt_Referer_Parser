<?php
/**
 * Setting up a development environment.
 *
 * You can comment out this section if you dont want to get see the errors.
 */
ini_set('display_errors', 1);
umask(0);

/**
 * Required files.
 *
 * Code requires composer autoloader and also require the real referer php class
 * to be included for proper working.
 *
 * As per your usage of this code, the location of these require statements should be
 * adjusted in such a way that they will be loaded before the referer get invoked in
 * the application. The given code will work if this cod is used from the root directory
 * of your application.
 */
require __DIR__ . '/vendor/autoload.php';


/**
 * Initiating referer instance.
 * @var Rkt\Referer
 */
$refer = new Rkt\Referer();

/**
 * Below is an illustration of how we can get the output.
 */
if ($refer->exists()) {
	echo $refer->getMedium(); //shows the medium of reference. ex: search, email
	echo $refer->getSource(); //shows the source of reference. ex: google, facebook
	echo $refer->getSearchTerm(); //show the search term if the medium of reference if search.
} else {
	echo $refer->getRequestUri(); //gives the refere uri
	echo $refer->getTargetUri(); //gives the target uri
}
