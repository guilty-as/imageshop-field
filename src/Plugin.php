<?php

namespace Guilty\Imageshop;

use craft\base\Plugin as BasePlugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use Guilty\Imageshop\Fields\ImageShopField;
use Guilty\Imageshop\Models\Settings;
use yii\base\Event;

class Plugin extends BasePlugin
{
    public $hasCpSettings = true;


    public function init()
    {
        parent::init();

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ImageShopField::class;
            });
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }


    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('craft-imageshop-field/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}