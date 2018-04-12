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

function printHeadFileAsset(){


	$head = "<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public ".'$basePath'." = '@webroot';
    public ".'$baseUrl'." = '@web';". PHP_EOL;

	return $head;

}


function printEndFileAsset(){


	$end = "public ".'$depends'." = [
        'yii\web\YiiAsset',
    ];
}" . PHP_EOL;

	return $end;

}

function printFileCss($all_css){


	$end = "public ".'$css'." = [";
        
    $nd_footer = "];
}" . PHP_EOL;

	$css_depends = $end.implode(' ',$all_css).$nd_footer;

	return $css_depends;

}


$startDirectory = realpath('path_theme_folder_where_is_css_js_file_of_plugin_and_other');
$data_js = scanDirectoryJs($startDirectory);
$data_css = scanDirectoryCss($startDirectory);
$destination_folder_file_js_css_pagejs = realpath('path_destination_folder_where_create_file_with_css_js_and_report_of_theme_filename_with_page_link');
$destination_folder_file_asset = realpath('path_destination_folder_where_create_file_php_asset_with_js_css_depend_of_yii2_link_to_html_page_of_theme');



$js_file_asset = fopen($destination_folder_file_js_css_pagejs."/"."js.txt", "w");
$css_file_asset = fopen($destination_folder_file_js_css_pagejs."/"."css.txt", "w");
$page_js_order = fopen($destination_folder_file_js_css_pagejs."/"."page_js.txt", "w");


foreach ($data_js as $key => $value) {
	$explode_js = explode('/', $value);
	$js_asset = "'".end($explode_js)."'".",". PHP_EOL;
	fwrite($js_file_asset, $js_asset);
	echo(".");
}

$css_file_all = [];
foreach ($data_css as $key => $value) {
	$explode_css = explode('/', $value);
	$css_asset = "'".end($explode_css)."'".",". PHP_EOL;
	$css_file_all[] = "'".end($explode_css)."'".",". PHP_EOL;
	fwrite($css_file_asset, $css_asset);
	echo("*");
}

$script_all_page = [];
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
			$script_all_page[end($explode_path)][] = end($explode_src);
			$txt = end($explode_src). PHP_EOL;	
			fwrite($page_js_order, $txt);	
			echo("|");
			
		}

	
	$blank_space = PHP_EOL;
	fwrite($page_js_order, $blank_space);
	
}

$js = [];
foreach ($script_all_page as $key => $value) {

	 $explode_title_file = explode('.', $key);

	 $page_asset = fopen($destination_folder_file_asset."/".ucfirst(reset($explode_title_file)).".php", "w");

	 $middle = "public ".'$js'." =[". PHP_EOL;
	
	foreach ($value as $valore) {
            $js[$key][] = "'".$valore."'".","."\n";
     }

    $intest = printHeadFileAsset();
    $fine = printEndFileAsset();
	$end_middle = "];". PHP_EOL;
	$css_print = printFileCss($css_file_all);
	
	fwrite($page_asset, $intest);
	fwrite($page_asset, $css_print);
	fwrite($page_asset, $middle);
	fwrite($page_asset, implode(" ",$js[$key]));
	fwrite($page_asset, $end_middle);
	fwrite($page_asset, $fine);
	echo("@");

}
