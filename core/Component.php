<?PHP

class Component {

	public static function render ($v0738238615_name, $arguments = []) {
		ob_start();
		if(is_array($arguments)){
			extract($arguments);
		}
		// The name variable was prefixed because extract could override it
		include('themes/components/'.$v0738238615_name.'.phtml');
		return ob_get_clean();
	}

}
?>
