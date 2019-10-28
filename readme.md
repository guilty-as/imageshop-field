# Imageshop Field for Craft CMS

This plugin uses Imageshop's image selector (in a popup) and saves the result as a field for
developers to pull out in templates, it includes a simple preview of the selected image, 
works well with [Imager](https://github.com/aelvan/Imager-Craft), check the example section 
for information on how to use this plugin..
 
 
 ![Screenshot](./screenshot.png)

 
 
 
 
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


