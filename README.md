## Acaldeira Simple Shipping

Magento 2 Acaldeira Simple Shipping Module

Description
-----------
This module is a skeleton for building a Magento 2 shipment module. 

Compatibility
-------------
- Magento >= 2.0

This library aims to support and is tested against the following PHP
implementations:

* PHP 7.0

Installation Instructions
-------------------------
Install using composer by adding to your composer file using commands:

1. create a folder at magento's root folder called "acmodules"
2. extract the extension inside the folder "acmodules/simpleShipping"
3. update Magento's composer.json file with the following
 
    2.1 add require 
    
        "acaldeira/simpleShipping": "*"
    
    2.2 add repositories 
    
        {
            "type": "path",
            "url": "acmodules/simpleShipping"
        }
    
4. composer update
5. bin/magento setup:upgrade

Support
-------

Credits
---------

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

License
-------
Respect the [Magento][] OSL license, which is included in this codebase.

[magento]: Magento2_LICENSE.md

Copyright
---------
Copyright (c) 2017 Acaldeira.