# Cloudimage Responsive Images module for Magento 2

## Introduction

Cloudimage is a scalable image CDN and proxy for transforming and optimizing images on-the-fly and accelerating them via rocket-fast Content Delivery Networks all around the world. 

The [Cloudimage Responsive Images Plugin](https://scaleflex.github.io/js-cloudimage-responsive) is a JS plugin for implementing Cloudimage in your code automatically and enabling responsive images on any web or mobile application. 

This Magento 2 module implements the Cloudimage Responsive Images Plugin on Magento 2 shops and accelerates your shop's landing page, category and product pages. 

There are 2 steps for enabling the plugin on your Magento 2 shop:
1. Install Cloudimage Responsive module for Magento 2
2. Adapt the Magento templates to enable Cloudimage (on-the-fly or manually)

### Warning

This version integrate changes in the Module's name and we therefore recommend a complete un-installation and re-installation to avoid any issue with your website if you are currently using a version below 1.1.0
Below the step by step guide to perform a smooth update:
1. Remove the Cloudimage Responsive plugin from the package
2. Remove all manual templates integration and all module references
3. Once the package is modified, deploy it
4. Remove the Cloudimage module row in the setup_module table with the following SQL request: ``` DELETE FROM setup_module WHERE module = 'CloudImage_Responsive' ```
5. Install this latest version in the package (standard new installation as described below)
6. Make all tests required
7. Once the package is ready, deploy it

It will briefly stop optimizing images through Cloudimage, but no broken image will be visible as a result of the update.
You also can skip the steps 1 to 3 in order to perform a faster update, but the images will be broken until the new version is fully deployed.

## 1. Install Cloudimage Responsive module for Magento 2

### Prerequisites

Cloudimage supports Magento Open Source and Commerce Edition from version 2 onwards.

To use the module, please sign up for a free account with [Cloudimage](https://www.cloudimage.io/en/registration?utm_source=magento-plugin&utm_medium=website&utm_campaign=magento-campaign) and get your Cloudimage token.
This token is required to configure the Magento plugin.

If you have a question or need assistance, feel free to contact our [support](https://www.cloudimage.io/en/contact-us).

### Install module by Composer

To be able to install the module by Composer, you need to get a copy of the module on the Magento Marketplace, or directly from Github.
 

```shell
composer config repositories.cloudimage vcs https://github.com/scaleflex/magento-cloudimage-responsive
composer require cloudimage/module-responsive-plugin --sort-packages
```

Enable and install following modules in Magento:

```shell
php bin/magento module:enable Cloudimage_Responsive
php bin/magento setup:upgrade
```

### Configuration

Once the steps listed above are completed enter your Cloudimage token into the Cloudimage Responsive module configuration the Magento admin interface:

```
Stores > Configuration > Cloudimage By Scaleflex > Cloudimage Responsive
```

![Cloudimage Responsive Plugin Configuration](doc/images/cloudimage_responsive_plugin_config.png "Cloudimage Responsive Configuration Page")

Expand the `General` section and activate the module by selecting `Yes` in the `Cloudimage Responsive Active` dropdown. Enter your Cloudimage token and configure the Options.

After saving the configuration, you will be asked to flush your Magento cache.

## Options

Following options are available: 

**Use origin URL:** If enabled, the module will only add query parameters to the image source URL without prefixing it with `{token}.cloudimg.io`. This is required if you use a dedicated subdomain for delivering your images (media) in Magento. You will need to complete the steps for enabling a custom CNAME in Cloudimage documented here.

**Ignore Image Size Node:** useful for improving compatibility with some themes.

**Ignore Image Size Style:** useful for improving compatibility with some themes.

**Lazy Loading:** if enabled, images will be lazy-loaded for better loading times and user experience.

## Advanced Configuration [Optional]

This setting is for advanced users only and allows to inject a custom JS function into the Magento templates in order to support some specific Magento templates. Feel free to contact us in order to get the custom JS function to inject to address issues with your specific template.

**Inject Custom JS function:** If enabled, you will be able to customize the JS function used dynamically to get the DOM information.

**Custom js function:** The js function to customize Cloudimage library.

## 2. Integration "on-the-fly" in Magento templates

Once activated, the Cloudimage Responsive module will replace "on the fly" your template's classic image tag elements. Specifically, all image tags detected with a src attribute will be replaced with a ci-src attribute and will therefore be processed through the Cloudimage infrastructure, allowing transformations and CDN caching.

### Compatibility

This functionality is 100% compatible with the Magento Luma theme.

### Templates customization

In case you are using customized templates and some of them would be built in Javascript, you will most probably have to do a manual integration (see below). It means that if some blocks are modified by a javascript after the DOM load, the "on-the-fly" functionnality will not anymore be able to integrate them automatically.

## 3. Manual integration in Magento templates (Magento server access required)

In the case of a personalized template, to be able to benefit from fast and responsive images you might need to modify the PHP templates, to replace the `<img src="" />` element by `<img ci-src="" />`.

Any Magento template file (.phtml) injecting images in your Magento shop via an `<img src>` HTML attribute should be modified as shown below in order to deliver responsive images wih Cloudimage.

### Example

As an example, the Magento product catalog page template `image_with_borders.phtml` can be found under `product/` folder on your Magento server. 

1. Copy Magento original template in your theme: `app/design/frontend/<your-theme>/default/Magento_Catalog/templates/product/image_with_borders.phtml`

2. Replace the src line `src="<?= $block->(...)"` by `ci-src="<?= $block->(...)"`

Here is an example using Cloudimage helper to modify the image element only if the Responsive plugin is activated:

Template : `app/design/frontend/<your-theme>/default/Magento_Catalog/templates/product/image_with_borders.phtml`

```
<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
?>

<?php
$cloudImageHelper = $this->helper(\Cloudimage\Responsive\Helper\Config::class);
?>

<span class="product-image-container" style="width:<?= $block->escapeHtmlAttr($block->getWidth()) ?>px;">
    <span class="product-image-wrapper" style="padding-bottom: <?= ($block->getRatio() * 100) ?>%;">
        <img class="<?= $block->escapeHtmlAttr($block->getClass()) ?>"
            <?= $block->escapeHtmlAttr($block->getCustomAttributes()) ?>
            
            <?php if ($cloudImageHelper->isActive()): ?>
                ci-src="<?= $block->escapeUrl($block->getImageUrl()) ?>"
            <?php else: ?>
                src="<?= $block->escapeUrl($block->getImageUrl()) ?>"
            <?php endif; ?>
            
            max-width="<?= $block->escapeHtmlAttr($block->getWidth()) ?>"
            max-height="<?= $block->escapeHtmlAttr($block->getHeight()) ?>"
            alt="<?= /* @noEscape */ $block->stripTags($block->getLabel(), null, true) ?>"
            />
     </span>
</span>
```

If you have any issue with the modification your template files, feel free to contact our [support](https://www.cloudimage.io/en/contact-us).
