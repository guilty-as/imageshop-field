<?php

namespace Guilty\Imageshop\Models;

use craft\base\Model;

class Settings extends Model
{
    /**
     * @var string
     */
    public $apiKey = '';

    /**
     * @var string
     */
    public $storeId = null;

    /**
     * @var string
     */
    public $statusProcessed = null;

    /**
     * @var string
     */
    public $statusShipped = null;

    /**
     * @var bool|null
     */
    public $enableSync;

    public function rules()
    {
        return [
            ['apiKey', 'required'],
            ['apiKey', 'string'],

            ['storeId', 'string'],

            ['statusProcessed', 'string'],
            ['statusShipped', 'string'],
        ];
    }
}