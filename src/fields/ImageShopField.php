<?php

namespace Guilty\Imageshop\Fields;

use Craft;
use yii\db\Schema;
use craft\base\Field;
use Guilty\Imageshop\Imageshop;
use craft\base\ElementInterface;
use Guilty\Imageshop\AssetBundles\ImageshopAssetBundle;

class ImageShopField extends Field
{
    public $token = "";
    public $key = "";
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

    private function getTempToken() {
        $token = Imageshop::$plugin->soap->getTemporaryToken();
        return $token->GetTemporaryTokenResponse->GetTemporaryTokenResult;
    }

    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $query = http_build_query([
            "IMAGESHOPTOKEN" => (string)$this->getTempToken(),
            "SHOWSIZEDIALOGUE" => (string)$this->showSizeDialogue,
            "SHOWCROPDIALOGUE" => (string)$this->showCropDialogue,
            "IMAGESHOPSIZES" => "Normal;1920x0",
            "FORMAT" => "json",
            "SETDOMAIN" => "false",
        ]);

        $url = sprintf("%s?%s", "https://client.imageshop.no/insertimage2.aspx", trim($query, "&"));

        // Figure out what that ID is going to look like once it has been namespaced
        $namespacedId = Craft::$app->view->namespaceInputId('');

        if ($namespacedId == 'fields-') {
            $namespacedId = 'fields-' . uniqid() . '-';
        }

        $view = Craft::$app->getView();
        $view->registerAssetBundle(ImageshopAssetBundle::class);
        $view->registerJs("new Craft.ImageshopField('{$namespacedId}imageshop', '{$url}');");

        return $view->renderTemplate('imageshop-field/input', [
            'name' => $this->handle,
            'value' => $value,
            'field' => $this,
            'namespaced' => $namespacedId,
        ]);
    }

    public function getSettingsHtml()
    {
        $settings = Imageshop::$plugin->settings;

        return Craft::$app->getView()->renderTemplate('imageshop-field/field', [
            'field' => $this,
            'token' => $settings->token,
            'key' => $settings->key,
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
