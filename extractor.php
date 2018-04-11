<?php 

function scanDirectoryJs($directory) {

    $files = glob($directory . '/*');

    $data = array();
    foreach ($files as $file) {
        if (is_dir($file)) {
            $data = array_merge($data, scanDirectoryJs($file));
        } else if (substr($file,-3) == '.js') {
            $data[] = $file;
        }
    }

    return $data;
}

function scanDirectoryCss($directory) {

    $files = glob($directory . '/*');

    $data = array();
    foreach ($files as $file) {
        if (is_dir($file)) {
            $data = array_merge($data, scanDirectoryCss($file));
        } else if (substr($file,-4) == '.css') {
            $data[] = $file;
        }
    }

    return $data;
}


$startDirectory = realpath('C:\Users\avisentin\Documents\Cestino_download_mio\CCC\ad\radixtouch.in\templates\admin\hotel\source');
$data_js = scanDirectoryJs($startDirectory);
$data_css = scanDirectoryCss($startDirectory);



$js_file_asset = fopen($startDirectory."js.txt", "w");
$css_file_asset = fopen($startDirectory."css.txt", "w");
$page_js_order = fopen($startDirectory."page_js.txt", "w");


foreach ($data_js as $key => $value) {
	$explode_js = explode('/', $value);
	$js_asset = "'".end($explode_js)."'".",". PHP_EOL;
	fwrite($js_file_asset, $js_asset);
	echo(".");
}

foreach ($data_css as $key => $value) {
	$explode_css = explode('/', $value);
	$css_asset = "'".end($explode_css)."'".",". PHP_EOL;
	fwrite($css_file_asset, $css_asset);
	echo("*");
}

foreach (glob($startDirectory."\\*.html") as $key => $value) {
	
	$explode_path = explode('\\', $value);

	$domd = new DOMDocument();
	libxml_use_internal_errors(true);
	$domd->loadHTML(file_get_contents($value));
	libxml_use_internal_errors(false);
	$items = $domd->getElementsByTagName('script');


	$title = end($explode_path). PHP_EOL;
	fwrite($page_js_order, $title);
	$blank_space = PHP_EOL;
	fwrite($page_js_order, $blank_space);

		foreach($items as $item) {

			$explode_src = explode('/', $item->getAttribute('src'));
			$txt = end($explode_src). PHP_EOL;	
			fwrite($page_js_order, $txt);	
			echo("|");
			
		}

	$blank_space = PHP_EOL;
	fwrite($page_js_order, $blank_space);
}