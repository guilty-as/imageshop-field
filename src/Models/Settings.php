<?php

namespace Guilty\Imageshop\Models;

use craft\base\Model;

class Settings extends Model
{
    /**
     * Imageshop access token
     *
     * @var string
     */
    public $token = '';

    /**
     * Imageshop private key
     *
     * @var string
     */
    public $key = '';

    /**
     * Imageshop language
     *
     * @var string
     */
    public $language = 'no';

    public function rules()
    {
        return [
            [['token', 'key', 'language'], 'required'],
            ['token', 'string'],
            ['key', 'string'],
            ['language', 'string']
        ];
    }
}
