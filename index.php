<?PHP
// Include app classes
include('core/Route.php');
include('core/Page.php');
include('core/Portal.php');
include('core/Component.php');




// Define base route
Route::get('/', function () {
	Page::render('home');
});


Route::get('/oferta', function () {
	Page::render('oferta');
});

Route::get('/galeria', function () {
	Page::render('galeria');
});

Route::get('/kontakt', function () {
	Page::render('kontakt');
});


Route::get('/polityka-prywatnosci', function () {
	Page::render('polityka-prywatnosci');
});


Route::get('/admin', function () {
	include('./themes/pages/panel-login.phtml');
});


Route::match('GET|POST', '/adminLog/?', function () {
	 include('./api/adminLog.php');
});


Route::match('GET|POST', '/email/?', function () {
	 include('./api/email.php');
});

Route::match('GET|POST', '/cms/?', function () {
	include('./api/cms.php');
});


// Error pages
Route::set404(function () {
	Page::render('404');
	header("HTTP/1.0 404 Not Found");
});


// Run the router
Route::run();

?>
