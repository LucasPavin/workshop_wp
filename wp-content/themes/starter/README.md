# RD_00000011_Starter_Theme_WP

## Requirement

* PHP 7.1
* WP 5.5
* ACF Pro 5.9

For a full PHP 5.6 compatibility, you can downgrade Twig to v1.

## Install

`composer install`

`npm install`

### SASS-SCSS

Install Globally Dart-Sass
https://github.com/sass/dart-sass

## Use

`npm run watch` : watches for changes in js and scss files

`npm run build` : compile assets for production & update theme version

### Settings

#### Theme

Theme settings can be set in `inc/Gosselink/GKSite.php` : 

* Theme support (post formats, etc.)
* WooCommerce activated or not

It's important to change the *SECURITY_KEY* constant for each project, as it is used for WordPress nonces.

##### Templates

Page templates like `template-page-xxx.php` should have their twig counterpart in `templates/pages/template-page-xxx.twig`.

It's mandatory when one page mode is enabled. 

##### Flexible content blocks (Gutenberg)

Each block has its own Javascript, Sass file and Twig template and must be added to the `blocks/ directory`.

The new block Javascript must be added to `src/js/lib/blocks.js` in order to be imported into the main app.js.

In addition, it also have a class file for adding its own ACF fields (add_acf_fields method) and data (set_data optionnal method).

If Gutenberg blocks are not shown on admin side, be sure to update "Options techniques" to save selection of "Blocs Gutenberg".

To register a block just add another folder in /themes/{theme-name}/blocks with his 4 files (PHP, twig, scss and JS) and check this newly created block in "Options technique > Blocs Gutenberg" on admin.

##### WooCommerce support

See https://github.com/MINDKomm/timber-integration-woocommerce for implementation

##### One page

One page settings can be set directly from WP Admin panel.

In One page mode, a page content can be open in a popup by adding the `open-popup` css class on a html element and the id of the page to open in `data-post-id`.

ex :
```
<div class="open-popup" data-post-id="3">Open Privacy page</div>
```

Les champs ACF sont stockés dans le context avec la variable "data". Voir GKPageSection pour plus de précision sur son fonctionnement.

#### Hot reload

**24/11/2021** - **Doesn't work for the moment** - Problem to serve assets files via dev server (Url not replaced)

`npm run serve` : hot reload on a temp server & watch 

Proxy can be changed in webpack.config.js


#### Functions

`post_link( $slug, $type = 'page', $lang = null )` 

Return the link for the page with slug = $slug.
If using polylang, $lang can also be set.

`gk_image($path, $alt = "", $class = "", $responsive = true, $sizes = "100vw", $background = false)` 

Return a lazy loaded image
    
  - $path : path or uri to the image
  - $alt : Replacement text
  - $classes : Additional classes
  - $responsive : Will generate different sizes of the image automatically (in the theme cache/ directory)
  - $sizes : sets the size of the loaded image in the viewport
  - $background : Image will be loaded as a background image

#### Filters

`image|watermark($watermark_image=null, $position='bottom right', $force=false)`

Automatically add a watermark on an image
    
  - $watermark_image : Optionnal. Path to the watermark image (relative to the theme directory). Defaults to 'static/images/watermark.png')
  - $position : Optionnal. Position for the watermark ('center center', bottom right', 'top left', ...)
  - $force : Optionnal. Will overwrite the previously generated image.

## Starter Child Theme

The Starter Theme can work with a starter child theme.
Few things are mandatories :
- for blocks, if new blocks are created in the starter child theme, you need to add them in the  $custom_blocks_names lists (inc/Service/BlockService.php).
- in webpack, change the path to the starter child theme (starter_child_entry)

## Font Icon

If the project needs it, you can installed Line Awesome a free library font icon :
https://github.com/icons8/line-awesome