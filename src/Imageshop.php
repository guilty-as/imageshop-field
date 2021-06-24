<?php

namespace Guilty\Imageshop;

use Craft;
use Guilty\Imageshop\Models\Settings;
use yii\base\Event;
use craft\base\Plugin;
use craft\services\Fields;
use craft\services\Plugins;
use craft\helpers\UrlHelper;
use craft\events\PluginEvent;
use Guilty\Imageshop\Fields\ImageShopField;
use craft\events\RegisterComponentTypesEvent;

class Imageshop extends Plugin
{
    /**
     * Static property that can be accessed via
     * Imageshop::$plugin
     *
     * @var Imageshop
     */
    public static $plugin;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ImageShopField::class;
            }
        );

        Event::on(Plugins::class, Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    $request = Craft::$app->getRequest();

                    if ($request->isCpRequest) {
                        Craft::$app->getResponse()->redirect(UrlHelper::cpUrl(
                            'settings/plugins/imageshop-field'
                        ))->send();
                    }
                }
            }
        );
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'imageshop-field/templates/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
