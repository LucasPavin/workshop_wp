<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 20/01/2020
 * Time: 16:19
 */

namespace Gosselink\Entity;

use Timber\Timber;

class GKBlock {

	/**
	 * Logical Name (like "TextImage")
	 * @var
	 */
	private $name;

	/**
	 * Display title (like "Text & Image")
	 * @var
	 */
	private $title;

	/**
	 * Standard block or wrapper
	 * @var
	 */
	private $type;

	/**
	 * Attach a unique ID for javascript manipulation
	 * @var
	 */
	private $id;

	public  $slug;
	public  $acf_id;
	private $path;
	private $abs_path;
	public  $category;
	private $description;
	private $icon;
	private $keywords;

	/**
	 * Custom data that will be added to the block context
	 * Set in the block class using a set_data function
	 * @var
	 */
	private $data;

	const TEMPLATE_FILE = "template.twig";

	public function __construct($name, $isChildBlock = false) {
		if (!function_exists("acf_register_block")) {
			return;
		}

		$this->isChildBlock = $isChildBlock;
		$this->name = $name;
		$this->id = uniqid('block_');
		$this->slug = "gk-" . sanitize_title($name);
		$this->acf_id = "acf/" . $this->slug;
		$this->path = "blocks" . DIRECTORY_SEPARATOR . sanitize_file_name($this->name);
		$this->abs_path = $this->isChildBlock ? get_stylesheet_directory()
 		. DIRECTORY_SEPARATOR . $this->path : get_template_directory() . DIRECTORY_SEPARATOR . $this->path;
		$this->data = array();

		if (file_exists($this->abs_path . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE)) {

			// Get infos from file
			$file_headers = get_file_data($this->abs_path . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE, [
				'title' => 'Title',
				'category' => 'Category',
				'description' => 'Description',
				'icon' => 'Icon',
				'keywords' => 'Keywords',
				'type' => 'Type',
			]);

			if (empty($file_headers['title'])) {
				die(_e('Ce bloc nécessite un "Title": ' . $this->name));
			}
			if (empty($file_headers['category'])) {
				die(_e('Ce bloc nécessite une "Category": ' . $this->name));
			}
			if (empty($file_headers['type'])) {
				$this->type = '';
			}else{
				$this->type = strtolower($file_headers['type']);
			}

			$this->title = $file_headers['title'];
			$this->category = array(
				'slug' => strtolower(sanitize_title($file_headers['category'])),
				'title' => $file_headers['category'],
			);
			$this->description = $file_headers['description'];
			$this->icon = $file_headers['icon'];
			$this->keywords = $file_headers['keywords'];

            // block_categories is deprecated since version 5.8
			if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
				add_filter('block_categories', array($this, 'register_category'), 10);
			} else {
				add_filter('block_categories_all', array($this, 'register_category'), 10);
			}
            add_action('init', array($this, 'register'), 10);
		} else {
			error_log("File " . $this->path . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE . " does not exist. Block " . $this->name . " cannot be created.");
		}
	}

	/**
	 * Register the block category
	 * @param $categories
	 * @param $post
	 * @return array
	 */
	public function register_category($categories) {

		$category_slugs = wp_list_pluck( $categories, 'slug' );

		if ( ! in_array( $this->category['slug'], $category_slugs, true ) ) {
			$categories = array_merge(
				$categories,
				array(
					array(
						'title' => $this->category['title'],
						'slug'  => $this->category['slug'],
						'icon'  => 'star-filled', // Slug of a WordPress Dashicon or custom SVG
					),
				)
			);
		}

		return $categories;
	}

	/**
	 * Register the block itself
	 */
	public function register() {

		// Register a new block
		$block_params = array(
			'name' => $this->slug,
			'title' => $this->title,
			'description' => $this->description,
			'category' => $this->category['slug'],
			'icon' => $this->icon,
			'mode' => 'edit',
			'align' => false,
			'keywords' => explode(' ', $this->keywords),
			'supports' => array('mode' => false),
			'post_types' => array(),
			'render_template' => '',
			'render_callback' => array($this, 'render'),
			'enqueue_style' => false,
			'enqueue_script' => false,
			'enqueue_assets' => false,
		);

		// Wrappers have special options
		if ($this->type === 'wrapper'){
			$block_params['mode'] = 'preview';
			$block_params['supports'] =  array(
				'align' => false,
				'mode' => false,
				'__experimental_jsx' => true
			);
		}

		acf_register_block_type($block_params);

		// Registering ACF Fields
		try {
			$classname = $this->isChildBlock ? "\\Gossechild\\Blocks\\{$this->name}\\{$this->name}" : "\\Gosselink\\Blocks\\{$this->name}\\{$this->name}";

			$block = new $classname($this);

			if (method_exists($block, 'set_data')){
				$this->data = $block->set_data();
			}

		} catch (\Exception $e) {
			error_log("Block " . $this->name . " : class not found => " . $classname);
		}
	}

	/**
	 * Render the block
	 * @param $block
	 */
	public function render($block) {
		$context = Timber::get_context();

		$context["block"] = $block;
		$context["data"] = $this->data;

        Timber::render(DIRECTORY_SEPARATOR.$this->path.DIRECTORY_SEPARATOR.self::TEMPLATE_FILE, $context);
	}
}
