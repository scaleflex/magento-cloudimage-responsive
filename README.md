# Cloudimage Responsive Images module for Magento 2

## Introduction

Cloudimage is a scalable image CDN and proxy for transforming and optimizing images on-the-fly and accelerating them via rocket-fast Content Delivery Networks all around the world. 

The [Cloudimage Responsive Images Plugin](https://scaleflex.github.io/js-cloudimage-responsive) is a JS lib for implementing Cloudimage in your frontend code automatically and enabling responsive images on any web or mobile application. 

This Magento 2 module implements the Cloudimage Responsive Images Plugin on Magento 2 shops and accelerate your shop's landing page, category and product pages.


## Install Cloudimage Responsive module for Magento 2

### Prerequisites

Cloudimage supports Magento Open Source and Commerce Edition from version 2 onwards.

To use the module, please sign up for a free account with [Cloudimage](https://www.cloudimage.io/en/registration) and get your Cloudimage token.
This token is required to configure the Cloudimage plugin inside Magento.

If you have a question or need assistance, feel free to contact our [support](https://www.cloudimage.io/en/contact-us).

### Install module by Composer

To be able to install the module by Composer, you need to get a copy of the module on the Magento Marketplace, or directly from Github.
 

```shell
composer require cloudimage/responsive --sort-packages
```

Enable and install following modules in Magento:

```shell
php bin/magento module:enable CloudImage_Responsive
php bin/magento setup:upgrade
```

### Configuration

Once the steps listed above are completed enter your Cloudimage token into the CloudImage Responsive module configuration the Magento admin interface:

```
Stores > Configuration > CloudImage By Scaleflex > CloudImage Responsive
```

![CloudImage Responsive Plugin Configuration](doc/images/cloudimage_responsive_plugin_config.png "CloudImage Responsive Configuration Page")

Expand the `General` section and activate the module by selecting `Yes` in the `CloudImage Responsive Active` dropdown. Enter your Cloudimage token and configure the Options.

After saving the configuration, you will be asked to flush your Magento cache.

## Options

Following options are available: 

**Use origin URL:** If enabled, the module will only add query parameters to the image source URL without prefixing it with `{token}.cloudimg.io`. This is required if you use a dedicated subdomain for delivering your images (media) in Magento. You will need to complete the steps for enabling a custom CNAME in Cloudimage documented here.

**Ignore Image Size Node:** useful for improving compatibility with some themes.

**Ignore Image Size Style:** useful for improving compatibility with some themes.

**Lazy Loading:** if enabled, images will be lazy-loaded for better loading times and user experience.
