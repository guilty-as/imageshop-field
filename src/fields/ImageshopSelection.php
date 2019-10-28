<?php


namespace Guilty\Imageshop\Fields;


use yii\base\BaseObject;

class ImageshopSelection extends BaseObject
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

    public function getJson()
    {
        return $this->_json;
    }

    public function getDocumentId()
    {
        return $this->_json["documentId"];
    }

    protected function getLang($lang)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }

        return $lang;
    }

    public function getTags($lang)
    {
        return explode(" ", $this->_json["text"][$this->getLang($lang)]["tags"]);
    }

    public function getTitle($lang)
    {
        return $this->_json["text"][$this->getLang($lang)]["title"];
    }

    public function getDescription($lang)
    {
        return $this->_json["text"][$this->getLang($lang)]["description"];
    }

    public function getRights($lang)
    {
        return $this->_json["text"][$this->getLang($lang)]["rights"];
    }

    public function getCredits($lang)
    {
        return $this->_json["text"][$this->getLang($lang)]["credits"];
    }
}