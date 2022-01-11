<?PHP

class Page{

	public static function render($name, $layout='layout', $arguments = []) {
		// Catch the page results and send them to the main portal
		Portal::sendStart();
		if(is_array($arguments)){
			extract($arguments);
		}
		include('themes/pages/'.$name.'.phtml');
		Portal::sendEnd('main');

		// Include the layout
		include('themes/'.$layout.'.phtml');
	}

}
?>