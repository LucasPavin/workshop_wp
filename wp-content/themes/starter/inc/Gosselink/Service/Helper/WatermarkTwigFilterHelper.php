<?php

namespace Gosselink\Service\Helper;

/*
 * Watermark an image with a (preferably transparent) watermark-image.
 *
 */
use Timber\ImageHelper;

class WatermarkTwigFilterHelper {


	/**
	 * @param null $filename_or_object source image
	 * @param null $watermark_image watermark image (relative to the theme directory)
	 * @param string $position position for the watermark ('top right', 'bottom left' , 'bottom center'...)
	 * @param bool $force Will not use the cached image
	 * @return mixed|null|string|void
	 */
	public static function watermark($filename_or_object=null, $watermark_image=null, $position='bottom right', $force=false ) {
		// make sure the image exists, prepare the output, etc.

		if (is_null( $filename_or_object )) {
			return $filename_or_object;
		}

		if (is_null( $watermark_image )) {
			$watermark_image = apply_filters( 'gosselink/watermark/image', 'static/images/watermark.png' );
		}

		if (!file_exists( $watermark_image )) {
			$watermark_image = get_theme_file_path( $watermark_image );
		}

		$load_filename = null;
		if ( is_object( $filename_or_object ) && method_exists( $filename_or_object, 'src') ) {
			$load_filename = $filename_or_object->src();
		}

		if ( is_string( $filename_or_object ) ) {
			$load_filename = $filename_or_object;
		}

		if (is_null( $load_filename ) ) {
			return $filename_or_object;
		}

		$subfolder = null;
		if ( \Timber\URLHelper::is_url($load_filename) ) {
			$load_filename = \Timber\URLHelper::url_to_file_system($load_filename);
			$subfolder = dirname( $load_filename );
		}

		if (is_null($subfolder)) {
			return $filename_or_object;

		}

		if (pathinfo($load_filename, PATHINFO_EXTENSION) == '') {
			return $filename_or_object;
		}

		// Caching
		$save_filename = $subfolder . '/' . sprintf('%s.%s',
			sprintf('%s_%s',
				substr(md5($load_filename), 0, 10),
				substr(md5_file($watermark_image), 0, 10)
			),
			pathinfo($load_filename, PATHINFO_EXTENSION)
		);
		$save_filename = apply_filters('timber/image/new_path', $save_filename);

		if ( $force == false && file_exists( $save_filename) ) {
			return \Timber\URLHelper::file_system_to_url($save_filename);
		}

		// Load the stamp and the photo to apply the watermark to
		$source = self::get_image($load_filename);
		$watermark = self::get_image($watermark_image);

		$wp_image = wp_get_image_editor( $load_filename );

		$quality = $wp_image->get_quality();

		// Set the margins for the stamp and get the height/width of the stamp image
		$margin_x = apply_filters( 'gosselink/watermark/margin_x', 10 );
		$margin_y = apply_filters( 'gosselink/watermark/margin_y', 10 );

		$sx = imagesx($source);
		$sy = imagesy($source);

		$wx = imagesx($watermark);
		$wy = imagesy($watermark);


		// too big?
		if ($wy + $margin_y > $sy || $wx + $margin_x > $sx) {
			return $filename_or_object;
		}

		// Position
		$destx = $sx / 2 - $wx / 2 - $margin_x / 2;
		if (strpos($position, 'left') !== false){
			$destx = $margin_x;
		}elseif (strpos($position, 'right') !== false){
			$destx = $sx - $wx - $margin_x;
		}

		$desty = $sy / 2 - $wy / 2 - $margin_y / 2;
		if (strpos($position, 'bottom') !== false){
			$desty = $sy - $wy - $margin_y;
		}elseif (strpos($position, 'top') !== false){
			$desty = 0 + $margin_y;
		}

		// Copy the stamp image onto our photo using the margin offsets and the photo
		// width to calculate positioning of the stamp.
		imagecopy(
			$source,
			$watermark,
			$destx,
			$desty,
			0,
			0,
			$wx,
			$wy
		);

		$result = self::save_image($source, $save_filename, $quality);
		return \Timber\URLHelper::file_system_to_url($save_filename);
	}

	static function get_image($src) {
		$func = 'imagecreatefromjpeg';
		$ext = pathinfo($src, PATHINFO_EXTENSION);
		if ( $ext == 'gif' ) {
			$func = 'imagecreatefromgif';
		} else if ( $ext == 'png' ) {
			$func = 'imagecreatefrompng';
		}
		return $func($src);
	}

	static function save_image($imageObj, $filename, $quality=90) {
		$save_func = 'imagejpeg';
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ( $ext == 'gif' ) {
			$save_func = 'imagegif';
		} else if ( $ext == 'png' ) {
			$save_func = 'imagepng';
			if ( $quality > 9 ) {
				$quality = $quality / 10;
				$quality = round(10 - $quality);
			}
		}

		if ( $save_func === 'imagegif' ) {
			return $save_func($imageObj, $filename);
		}
		return $save_func($imageObj, $filename, $quality);
	}
}
