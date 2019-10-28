<?php


namespace Guilty\Imageshop\Fields;


use craft\base\Serializable;
use yii\base\BaseObject;

class ImageshopSelection extends BaseObject implements Serializable
{
    /**
     * @var array
     */
    protected $_json;

    public function __construct($json, $config = [])
    {
        $this->_json = json_decode($json, true);
        parent::__construct($config);
    }

    public function getWidth()
    {
        if (isset($this->_json["image"])) {
            return $this->_json["image"]["width"];
        }

        return null;
    }

    public function getHeight()
    {
        if (isset($this->_json["image"])) {
            return $this->_json["image"]["height"];
        }

        return null;
    }

    public function getUrl()
    {
        return $this->getImage();
    }

    public function getImage()
    {
        if (isset($this->_json["image"])) {
            $base = $this->_json["image"]["file"];
            $filename = $this->getFilename();

            return $base . "/" . $filename;
        }

        return null;
    }

    public function getFilename()
    {
        if (isset($this->_json["image"])) {
            $url = $this->_json["image"]["file"];
            $path = parse_url($url, PHP_URL_PATH);

            return trim($path, "/") . ".jpg";
        }

        return null;
    }

    public function getCode()
    {
        if (isset($this->_json["code"])) {
            return $this->_json["code"];
        }

        return null;
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
        if (isset($this->_json["documentId"])) {
            return $this->_json["documentId"];
        }

        return null;
    }

    protected function getLang($lang = null)
    {
        if (!in_array($lang, ["no", "en", "sv"])) {
            $lang = "no";
        }

        return $lang;
    }

    public function getTags($lang = null)
    {
        $tags = $this->getTextInfo("tags", $lang);

        if (is_string($tags)) {
            return explode(" ", $tags);
        }

        // No tags
        return [];
    }

    public function getTitle($lang = null)
    {
        return $this->getTextInfo("title", $lang);
    }

    public function getDescription($lang = null)
    {
        return $this->getTextInfo("description", $lang);;
    }

    public function getRights($lang = null)
    {
        return $this->getTextInfo("rights", $lang);
    }

    public function getCredits($lang = null)
    {
        return $this->getTextInfo("credits", $lang);;
    }

    protected function getTextInfo($key, $lang = null)
    {
        $lang = $this->getLang($lang);

        if (!isset ($this->_json["text"][$lang])) {
            return null;
        }

        if (!isset ($this->_json["text"][$lang][$key])) {
            return null;
        }

        return $this->_json["text"][$lang][$key];
    }

    /**
     * Returns the object’s serialized value.
     *
     * @return mixed The serialized value
     */
    public function serialize()
    {
        return json_encode($this->_json);
    }


    public function __toString()
    {
        return $this->getUrl() ?? "";
    }
}