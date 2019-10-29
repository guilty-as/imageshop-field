<?php

namespace Guilty\Imageshop\Fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use Guilty\Imageshop\AssetBundles\ImageshopAssetBundle;
use yii\db\Schema;

class ImageShopField extends Field
{
    public $token = "";
    public $culture = "en-US";
    public $showCropDialogue = false;
    public $showSizeDialogue = false;
    public $buttonText = "Velg bilde";


    public function normalizeValue($value, ElementInterface $element = null)
    {
        return new ImageshopSelection($value);
    }


    public static function displayName(): string
    {
        return "Imageshop";
    }

    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    public static function valueType(): string
    {
        return ImageshopSelection::class . "|null";
    }


    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $query = build_query_string([
            "IMAGESHOPTOKEN" => (string)$this->token,
            "SHOWSIZEDIALOGUE" => (string)$this->showSizeDialogue,
            "SHOWCROPDIALOGUE" => (string)$this->showCropDialogue,
            "IMAGESHOPSIZES" => "Normal;1920x0",
            "FORMAT" => "json",
            "SETDOMAIN" => "false",
        ]);

        $url = sprintf("%s?%s", "https://client.imageshop.no/insertimage2.aspx", trim($query, "&"));


        $view = Craft::$app->getView();
        $view->registerAssetBundle(ImageshopAssetBundle::class);
        $view->registerJs("new Craft.ImageshopField('imageshop-{$this->id}', '{$url}');");


        return $view->renderTemplate('imageshop-field/input', [
            'name' => $this->handle,
            'value' => $value,
            'field' => $this,
        ]);
    }


    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('imageshop-field/field', [
            'field' => $this,
            'cultures' => [
                [
                    "label" => "English",
                    "value" => "en-US",
                ],
                [
                    "label" => "Norwegian",
                    "value" => "nb-NO",
                ],
            ],
        ]);
    }
}