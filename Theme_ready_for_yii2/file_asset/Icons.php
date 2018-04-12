<?php
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
    public $basePath = '@webroot';
    public $baseUrl = '@web';
public $css = ['material_style.css',
 'animate_page.css',
 'extra_pages.css',
 'formlayout.css',
 'inbox.min.css',
 'pricing.css',
 'steps.css',
 'timeline.css',
 'typography.css',
 'plugins.min.css',
 'responsive.css',
 'style.css',
 'theme-color.css',
 'bootstrap.min.css',
 'bootstrap-colorpicker.css',
 'bootstrap-datepicker3.min.css',
 'bootstrap-datetimepicker.min.css',
 'bootstrap-editable.css',
 'address.css',
 'dataTables.bootstrap4.min.css',
 'dropzone.css',
 'font-awesome.min.css',
 'fullcalendar.css',
 'material-design-iconic-font.min.css',
 'blueimp-gallery.min.css',
 'jquery.fileupload-ui.css',
 'jquery.fileupload.css',
 'jquery-tags-input.css',
 'jquery.toast.min.css',
 'jqvmap.css',
 'lightgallery.css',
 'material.min.css',
 'bootstrap-material-datetimepicker.css',
 'morris.css',
 'owl.carousel.css',
 'owl.theme.css',
 'select2-bootstrap.min.css',
 'select2.css',
 'simple-line-icons.min.css',
 'summernote.css',
 'sweetalert.min.css',
];
}
public $js =[
'',
];
public $depends = [
        'yii\web\YiiAsset',
    ];
}
