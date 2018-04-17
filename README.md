# Store Picker example extension
Used for the talk _Understand and Improve Your Magento 2 Store Caching and Performance_ at Magento Imagine 2018, by [Renato Cason](https://github.com/renatocason).

## Introduction
This extension is meant to be a proof of concept and a sandbox for understanding the explained concepts.
It is not meant to be actually used in a real Magento shop.

The module is a simple extension with an entity, stored in the database and managed via the admin, that represent the link between a country and a store.
For example, you might want to direct US and GB users to the EN (English) store view, Spanish and Argentinian users to the ES (Spanish) store view, and so on.
The frontend block just outputs a select, where the option values are populated with the configured store Urls, and the values are the country name.
No other interaction has been developed for the proof of concept, but for instance the user could be automatically redirected when the selected value in the option changes.

## Usage
The module should be installed via composer and enabled with the Magento CLI tool.
On _setup:upgrade_, all the avilable countries will be used to populate the _storepicker_location_ database table.

### Configuration
For a better result, all store views should have different base Urls. This can be easily done by setting _Add Store Code to Urls_ to _Yes_.
The links between country and store view can be edited, added and removed via the admin, under _Stores > Store Picker Locations_.

### Frontend
The frontend block is added to the main page content on the default layout handle, right before the footer.

## Branches
Different branches show different improvements implemented in the module.

### master
The complete, final, example.

### S1_Base
The base example, with no optimisation.

Expected behaviour:
* Frontend block is not cached
* Each change to the entities will appear immediately in the frontend

### S2_BlockCache
Added block cache.

Expected behaviour:
* Frontend block is cached
* Each change to the entities will not appear in the frontend until the block html cache is cleaned

### S3_TagInvalidation
Implemented block cache invalidation via tag.

Expected behaviour:
* Frontend block is cached
* Each change to the entities will appear immediately in the frontend

### S4_CustomCacheType
Implemented custom cache type.
