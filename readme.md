# Imageshop Field for Craft CMS

This plugin integrates [Imageshop](https://www.imageshop.no/) with Craft CMS by exposing 
their image selector as a popup that saves the selected image data in a field so the selection 
can be used in twig templates.

 
 
 ![Screenshot](./screenshot.png)


# Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

```` 
cd /path/to/project
````

2. Then tell Composer to load the plugin:

```
composer require guilty/craft-imageshop-field
```
        
3. In the Control Panel, go to Settings → Plugins and click the “Install” button for 'Imageshop'.

OR do it via the command line

```
php craft install/plugin craft-imageshop-field
```
         

4. You will now have "Imageshop selector" available as a choice in the Field type dropdown on the field creation page.

 
  
## Templating:

### Using Imager

```twig
<h2>Image Single</h2>
{% set transforms = craft.imager.transformImage(
    entry.imageshopField.url,
    [{ width: 200 }, { width: 800 }]
) %}

<img src="{{ transforms.0.url }}" width="{{  transforms.0.width }}" style="width: auto!important;">
<img src="{{ transforms.1.url }}" width="{{  transforms.1.width }}" style="width: auto!important;">
```
 
 
### Available variables

```imageshopField``` is the name of the field in these examples.

 ```twig
Code:           {{ entry.imageshopField.code }}
Image:          {{ entry.imageshopField.image }}
Tags:           {{ entry.imageshopField.tags("no") | join(", ") }}
Title:          {{ entry.imageshopField.title }}
Rights:         {{ entry.imageshopField.rights }}
Description:    {{ entry.imageshopField.description }}
Credit:         {{ entry.imageshopField.credits }}
DocumentId:     {{ entry.imageshopField.documentId }}
Raw:            {{ entry.imageshopField.json | json_encode(constant("JSON_PRETTY_PRINT")) }}
```


