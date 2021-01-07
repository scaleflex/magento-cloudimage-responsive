# CLOUDIMAGE RESPONSIVE PLUGIN FOR MAGENTO2 DOCUMENTATION

Thank you for using the "CloudImage Responsive plugin for Magento2".

## Description

Cloudimage will solve your challenges with image resizing, transformation, 
and acceleration in the Cloud.

## Install CloudImage Responsive plugin for Magento 2

### Prerequisites

CloudImage_Responsive supports Magento2 Open Source, Commerce Edition from version 2.0.

You will need to signup for a free account with [cloudimage.io](https://www.cloudimage.io/en/registration) 
in order to use the module. Once your account has been created, you will get a token. The token will be required
to configure the module and start a new experience with CloudImage.

If you have a question or need assistance, feel free to contact our [support](https://www.cloudimage.io/en/contact-us).

### Install module by Composer

To be able to install the module by Composer, you might need to get a copy of the  module on the Magento Marketplace, or directly on our github.
 

```shell
composer require cloudimage/responsive --sort-packages
```

Enable and install module(s) in Magento:

```shell
php bin/magento module:enable CloudImage_Responsive
php bin/magento setup:upgrade
```

### Configuration

You need to complete the requirements first. 

Then, once the module is installed on your Magento, you will be able to enter the API token 
into the CloudImage Responsive module.   

To enter the API token, open a browser and log in to the admin section of the Magento server. 
Navigate to:

```
Stores > Configuration > CloudImage By Scaleflex > CloudImage Responsive
```

![CloudImage Responsive Plugin Configuration](doc/images/cloudimage_responsive_plugin_config.png "CloudImage Responsive Configuration Page")

Expand the 'General' section then select Yes in "CloudImage Responsive Active" dropdown.

Once you've selected Yes in the dropdown, the "API token" textbox will appear. Enter your token in it.

Click on "Save Button" and you will be asked to flush the cache.

## Features

The module allows you to activate/deactivate the following options:

**Use origin URL:** If enabled, the plugin will only add query parameters to the image source URL, avoiding double CDNization in some cases, like if you have aliases configured.

**Ignore Image Size Node:** Can be useful for improving compatibility with some themes.

**Ignore Image Size Style:** Can be useful for improving compatibility with some themes.

**Lazy Loading:** If enabled, only images close to the current viewpoint will be loaded.
