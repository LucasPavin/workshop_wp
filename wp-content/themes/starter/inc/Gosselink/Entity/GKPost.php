<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 17/10/2018
 * Time: 09:36
 */

namespace Gosselink\Entity;

use Timber\Post;
use Timber\Timber;

class GKPost
{

	/**
	 * @var Post $post
	 */
	protected $post;

	/**
	 * @var array $templates
	 */
	protected $templates = array();

	/**
	 * @var array $context
	 */
	protected $context = array();

	/**
	 * GKPost constructor.
	 */
	public function __construct()
	{
		$this->post = new Post();

		$this->templates = array(
			'single-' . $this->post->ID . '.twig',
			'single-' . $this->post->post_type . '.twig',
			'single.twig'
		);

		$this->context = Timber::get_context();

		$this->add_to_context( 'post', $this->post );
	}

	public function __toString()
	{
		return Timber::compile($this->templates, $this->context) ?: '';
	}

	public function render(){
        Timber::render( $this->templates, $this->context );
	}

	/**
	 * @return Post
	 */
	public function get_post()
	{
		return $this->post;
	}

	/**
	 * @param Post $post
	 */
	public function set_post($post)
	{
		$this->post = $post;
	}

	/**
	 * @return array
	 */
	public function get_templates()
	{
		return $this->templates;
	}

	/**
	 * @param array $template
	 */
	public function add_template($template)
	{
		$this->templates[] = $template;
	}

	/**
	 * @return array
	 */
	public function get_context()
	{
		return $this->context;
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function add_to_context($key, $value)
	{
		$this->context[$key] = $value;
	}


}