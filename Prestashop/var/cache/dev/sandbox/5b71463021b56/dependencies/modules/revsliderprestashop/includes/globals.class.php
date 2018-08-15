<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */
 
class RevSliderGlobals{

	const SLIDER_REVISION = '5.4.7.4';
	const TABLE_SLIDERS_NAME = "revslider_sliders";
	const TABLE_SLIDES_NAME = "revslider_slides";
	const TABLE_STATIC_SLIDES_NAME = "revslider_static_slides";
	const TABLE_SETTINGS_NAME = "revslider_settings";
	const TABLE_CSS_NAME = "revslider_css";
	const TABLE_LAYER_ANIMS_NAME = "revslider_layer_animations";
	const TABLE_NAVIGATION_NAME = "revslider_navigations";
        const TABLE_ATTACHMENT_IMAGES = "revslider_attachment_images";
        const TABLE_ATTACHMENT_IMAGES_LANG = "revslider_attachment_images_lang";
        const TABLE_REVSLIDER_OPTIONS_NAME = "revslider_options";
	const FIELDS_SLIDE = "slider_id,slide_order,params,layers";
	const FIELDS_SLIDER = "title,alias,params,type";
        
	const YOUTUBE_EXAMPLE_ID = "iyuxFo-WBiU";
	const DEFAULT_YOUTUBE_ARGUMENTS = "hd=1&amp;wmode=opaque&amp;showinfo=0&amp;rel=0;";
	const DEFAULT_VIMEO_ARGUMENTS = "title=0&amp;byline=0&amp;portrait=0&amp;api=1";
	const LINK_HELP_SLIDERS = "https://www.themepunch.com/revslider-doc/slider-revolution-documentation/?rev=rsb";
	const LINK_HELP_SLIDER = "https://www.themepunch.com/revslider-doc/slider-settings/?rev=rsb#generalsettings";
	const LINK_HELP_SLIDE_LIST = "https://www.themepunch.com/revslider-doc/individual-slide-settings/?rev=rsb";
	const LINK_HELP_SLIDE = "https://www.themepunch.com/revslider-doc/individual-slide-settings/?rev=rsb";

        const SHOW_DEBUG = false; 
		const IMAGE_SIZE_THUMBNAIL = 150;
		const IMAGE_SIZE_THUMBNAIL_H = 100;
		const IMAGE_SIZE_MEDIUM = 300;
		const IMAGE_SIZE_MEDIUM_H = 200;
		const IMAGE_SIZE_LARGE = 1024;
		const IMAGE_SIZE_LARGE_H = 750; 

	public static $table_sliders;
	public static $table_slides;
	public static $table_static_slides;
        public static $table_attachment_images;
        public static $table_attachment_images_lang;
	public static $table_settings;
	public static $table_css;
	public static $table_layer_anims;
	public static $table_navigation;
	public static $filepath_backup;
	public static $filepath_captions;
	public static $filepath_dynamic_captions;
	public static $filepath_captions_original;
	public static $urlCaptionsCSS;
	public static $uploadsUrlExportZip;
	public static $isNewVersion;
        public static $table_revslider_options_name;
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class GlobalsRevSlider extends RevSliderGlobals {}
?>