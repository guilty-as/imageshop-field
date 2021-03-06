<?php

namespace Guilty\Imageshop\AssetBundles;

use craft\web\AssetBundle;
use craft\helpers\FileHelper;
use craft\web\assets\cp\CpAsset;

class ImageshopAssetBundle extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = FileHelper::normalizePath(__DIR__ . '/dist');

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'ImageshopAssetBundle.js',
        ];

        parent::init();
    }
}
