<?php
require($_SERVER["DOCUMENT_ROOT"].'/includes/defines.php');

class Loader
{
	public function handle($name)
	{
		$fileName = __DIR__.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
 
		if (file_exists($fileName)) {
			require_once $fileName;
		}
	}
}

$loader = new Loader();
spl_autoload_register([$loader, 'handle']);
?>