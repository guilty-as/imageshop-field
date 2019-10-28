<?php


namespace Guilty\Imageshop\Fields;


use craft\base\Serializable;
use yii\base\BaseObject;

class ImageshopSelection extends BaseObject implements Serializable
{
    /**
     * @var string
     */
    protected $_json;

    /**
     * Constructor.
     *
     * @param string $hex hex color value, beginning with `#`. (Shorthand is not supported, e.g. `#f00`.)
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct(string $json, array $config = [])
    {
        $this->_json = json_decode($json, true);
        parent::__construct($config);
    }

    /**
     * Returns the object’s serialized value.
     *
     * @return mixed The serialized value
     */
    public function serialize()
    {
        return $this->_json;
    }


    public function getImage()
    {
        return $this->_json["image"]["file"];
    }

    public function getCode()
    {
        return $this->_json["code"];
    }

    public function getRaw()
    {
        return json_encode($this->_json);
    }

    public function getDocumentId()
    {
        return $this->_json["documentId"];
    }

    public function getTags($lang)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }


        if (!isset($this->_json["text"][$lang])) {
            return "";
        }

        return explode(" ", $this->_json["text"][$lang]["tags"]);

    }

    public function getTitle($lang)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }

        if (!isset($this->_json["text"][$lang])) {
            return "";
        }

        return $this->_json["text"][$lang]["title"];
    }

    public function getDescription($lang)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }

        if (!isset($this->_json["text"][$lang])) {
            return "";
        }

        return $this->_json["text"][$lang]["description"];
    }

    public function getRights($lang)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }

        if (!isset($this->_json["text"][$lang])) {
            return "";
        }

        return $this->_json["text"][$lang]["rights"];
    }

    public function getCredits($lang)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }

        if (!isset($this->_json["text"][$lang])) {
            return "";
        }

        return $this->_json["text"][$lang]["credits"];
    }
}