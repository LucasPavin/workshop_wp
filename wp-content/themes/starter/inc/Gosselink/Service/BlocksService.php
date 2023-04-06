<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 20/01/2020
 * Time: 14:20
 */

namespace Gosselink\Service;

use Gosselink\Entity\GKBlock;

class BlocksService
{
    private $custom_blocks;
    private $allowed_blocks;

    function __construct()
    {

        // Declare our own blocks here
        // Just add the directory name, and the theme will do the rest
        $custom_blocks_names = array(
            "Download",
            "Link",
            "AccordionTabs",
            "Highlights",
            "SliderPage",
            "Timeline",
            "Separator",
            "Wrapper",
            "EcoVideo",
            "TempBlockChild" // Used for demo. to be deleted
        );

        // Register custom blocks
        foreach ($custom_blocks_names as $block_name) {
            $block = new GKBlock($block_name);
            $this->custom_blocks[] = $block->acf_id;
        }

        // Select which WP blocks we need or not here
        $this->allowed_blocks = array(
            'core/image',
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/quote',
            'core/audio',
            'core/cover',
            'core/file',
            'core/html',
            'core/buttons',
            'core/columns',
            'core/media-text',
            'core/shortcode',
            'core/embed', // Needed for all embeds like YT, Viméo, etc. see admin.js for allowed embeds.
            /*
            'core/gallery',
            'core/video',
            'core/text-columns',
            */
        );

        // Then remove all WP blocks except those needed
        // allowed_block_types is deprecated since version 5.8
		if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
			add_filter( 'allowed_block_types', array($this, 'allowed_block_types') );
		} else {
			add_filter( 'allowed_block_types_all', array($this, 'allowed_block_types') );
		}
    }

    /**
     * Keep only needed blocks
     * See https://rudrastyh.com/gutenberg/remove-default-blocks.html
     * @param $allowed_blocks
     * @return array
     */
    function allowed_block_types($allowed_blocks)
    {
        return array_merge(
            $this->custom_blocks,
            $this->allowed_blocks
        );
    }


}
