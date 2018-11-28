<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 24/11/2561
 * Time: 15:28
 */
namespace homer\tagsinput;
/**
 * Asset bundle for tagsinput Widget
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
class TagsinputAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/bootstrap-tagsinput/dist';
    public $css = [
        'bootstrap-tagsinput.css',
    ];
    public $js = [
        'bootstrap-tagsinput.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}