<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class RevSliderFront extends RevSliderBaseFront{
	
	/**
	 * 
	 * the constructor
	 */
	public function __construct(){
		
		parent::__construct($this);
		
		//set table names
		RevSliderGlobals::$table_sliders = self::$table_prefix.RevSliderGlobals::TABLE_SLIDERS_NAME;
		RevSliderGlobals::$table_slides = self::$table_prefix.RevSliderGlobals::TABLE_SLIDES_NAME;
		RevSliderGlobals::$table_static_slides = self::$table_prefix.RevSliderGlobals::TABLE_STATIC_SLIDES_NAME;
		RevSliderGlobals::$table_settings = self::$table_prefix.RevSliderGlobals::TABLE_SETTINGS_NAME;
		RevSliderGlobals::$table_css = self::$table_prefix.RevSliderGlobals::TABLE_CSS_NAME;
		RevSliderGlobals::$table_layer_anims = self::$table_prefix.RevSliderGlobals::TABLE_LAYER_ANIMS_NAME;
		RevSliderGlobals::$table_navigation = self::$table_prefix.RevSliderGlobals::TABLE_NAVIGATION_NAME;
                RevSliderGlobals::$table_attachment_images = self::$table_prefix . RevSliderGlobals::TABLE_ATTACHMENT_IMAGES;
        RevSliderGlobals::$table_attachment_images_lang =self::$table_prefix .RevSliderGlobals::TABLE_ATTACHMENT_IMAGES_LANG;
                
	//	add_filter('punchfonts_modify_url', array('RevSliderFront', 'modify_punch_url'));
		
		//add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
                
               // var_dump(RevSliderBase::$front_scripts);die();
                if(!is_admin()){
                    RevLoader::loadActiveAddons();
                 }
                 do_action('wp_enqueue_styles');
                 do_action('wp_enqueue_scripts');
                 
	}
	
        public function loadFrontScripts(){
            wp_enqueue_style('setting', RS_PLUGIN_URL .'public/assets/css/settings.css' );
            wp_enqueue_style('font_1_css', RS_PLUGIN_URL .'public/assets/fonts/font-awesome/css/font-awesome.css?rev=5.4.1' );
            wp_enqueue_style('font_2_css', RS_PLUGIN_URL .'public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css?' );
            wp_enqueue_style('font_3_css', '//fonts.googleapis.com/css?family=Open+Sans%3A400%2C300%2C700%2C600%2C800&#038;ver=4.7.3' ); 
        }
        
        public static function rev_head_front(){
            foreach(RevLoader::$front_styles as $style){
              
                echo "<link rel='stylesheet' href='{$style}' type='text/css' media='all'>";
            }
            foreach(RevLoader::$front_scripts as $script){
                  echo "<script type='text/javascript' src='{$script}'></script>";
            }
        }
        
        
	public function displayOutput($article){
            
                self::loadFrontScripts();
                rev_head();
		preg_match_all('/\[rev_slider alias="(.*?)"\]/',$article->text, $matches);

		foreach($matches[1] as $wparam ) {

			$pattern = '/\[rev_slider alias="(.*?)"\]/';

			$alias = $wparam; 
                        $RevSliderSlider = new RevSliderSlider();
			$slide_array = $RevSliderSlider->initByMixed($alias);
			$slide_html = ''; 
                        $current_lang_id = RevSliderWpml::getCurrentLangid();
			if(isset($slide_array['id'])){
                               $slide_html = RevSliderOutput::putSlider($slide_array['id'], '',array(),array(),array(),$current_lang_id);
			}

			$article->text = preg_replace($pattern, $slide_html, $article->text);
		}
                return $article->text;
        }
	
	/**
	 * 
	 * a must function. you can not use it, but the function must stay there!
	 */		
	public static function onAddScripts(){
		global $wp_version;
		//die('from onAddScripts');
		$slver = apply_filters('revslider_remove_version', RevSliderGlobals::SLIDER_REVISION);
		
		$style_pre = '';
		$style_post = '';
		if($wp_version < 3.7){
			$style_pre = '<style type="text/css">';
			$style_post = '</style>';
		}
		
		$operations = new RevSliderOperations();
		$arrValues = $operations->getGeneralSettingsValues();
		
		$includesGlobally = RevSliderFunctions::getVal($arrValues, "includes_globally","on");
		$includesFooter = RevSliderFunctions::getVal($arrValues, "js_to_footer","off");
		$load_all_javascript = RevSliderFunctions::getVal($arrValues, "load_all_javascript","off");
		$strPutIn = RevSliderFunctions::getVal($arrValues, "pages_for_includes");
		$isPutIn = RevSliderOutput::isPutIn($strPutIn,true);
		
		$do_inclusion = apply_filters('revslider_include_libraries', false);
		
		//put the includes only on pages with active widget or shortcode
		// if the put in match, then include them always (ignore this if)			
		if($isPutIn == false && $includesGlobally == "off" && $do_inclusion == false){
			$isWidgetActive = is_active_widget( false, false, "rev-slider-widget", true );
			$hasShortcode = RevSliderFunctionsWP::hasShortcode("rev_slider");
			
			if($isWidgetActive == false && $hasShortcode == false)
				return(false);
		}
		
		wp_enqueue_style('rs-plugin-settings', RS_PLUGIN_URL .'public/assets/css/settings.css', array(), $slver);
		
		$custom_css = RevSliderOperations::getStaticCss();
		$custom_css = RevSliderCssParser::compress_css($custom_css);
		
		if(trim($custom_css) == '') $custom_css = '#rs-demo-id {}';
		
		//wp_add_inline_style( 'rs-plugin-settings', $style_pre.$custom_css.$style_post );
		
		$setBase = (is_ssl()) ? "https://" : "http://";
		
		//wp_enqueue_script(array('jquery'));
		
		$waitfor = array('jquery');
		
		$enable_logs = RevSliderFunctions::getVal($arrValues, "enable_logs",'off');
		if($enable_logs == 'on'){
			wp_enqueue_script('enable-logs', RS_PLUGIN_URL .'public/assets/js/jquery.themepunch.enablelog.js', $waitfor, $slver);
			$waitfor[] = 'enable-logs';
		}
		
		
		$ft = ($includesFooter == "on") ? true : false;
		
//                if(_PS_VERSION_ < 1.7){
//		wp_enqueue_script('tp-tools', RS_PLUGIN_URL .'public/assets/js/jquery.themepunch.tools.min.js', $waitfor, $slver, $ft);
//		wp_enqueue_script('revmin', RS_PLUGIN_URL .'public/assets/js/jquery.themepunch.revolution.min.js', 'tp-tools', $slver, $ft);
//                        
//		
//			wp_enqueue_script('revmin-actions', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.actions.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-carousel', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.carousel.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-kenburn', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.kenburn.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-layeranimation', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.layeranimation.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-migration', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.migration.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-navigation', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.navigation.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-parallax', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.parallax.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-slideanims', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.slideanims.min.js', 'tp-tools', $slver, $ft);
//			wp_enqueue_script('revmin-video', RS_PLUGIN_URL .'public/assets/js/extensions/revolution.extension.video.min.js', 'tp-tools', $slver, $ft);
//                }
		//var_dump(RevSliderBase::$front_scripts);die();
		//UniteBaseClassRev::addAction('wp_head', array('RevSliderFront', 'add_meta_generator'));
		UniteBaseClassRev::addAction("wp_footer", array('RevSliderFront',"load_icon_fonts") );
		
		// Async JS Loading
		$js_defer = RevSliderBase::getVar($arrValues, 'js_defer', 'off');
		if($js_defer!='off') add_filter('clean_url', array('RevSliderFront', 'add_defer_forscript'), 11, 1);
		
		//add_action('wp_before_admin_bar_render', array('RevSliderFront', 'add_admin_menu_nodes'));
		UniteBaseClassRev::addAction('wp_footer', array('RevSliderFront', 'putAdminBarMenus'), 99);
		
	}
	
	/**
	 * add admin menu points in ToolBar Top
	 * @since: 5.0.5
	 */
	public static function putAdminBarMenus () {
		if(!is_super_admin() || !is_admin_bar_showing()) return;
		
		?>
		<script>	
			jQuery(document).ready(function() {			
				
				if (jQuery('#wp-admin-bar-revslider-default').length>0 && jQuery('.rev_slider_wrapper').length>0) {
					var aliases = new Array();
					jQuery('.rev_slider_wrapper').each(function() {
						aliases.push(jQuery(this).data('alias'));
					});								
					if(aliases.length>0)
						jQuery('#wp-admin-bar-revslider-default li').each(function() {
							var li = jQuery(this),
								t = jQuery.trim(li.find('.ab-item .rs-label').data('alias')); //text()
								
							if (jQuery.inArray(t,aliases)!=-1) {
							} else {
								li.remove();
							}
						});
				} else {
					jQuery('#wp-admin-bar-revslider').remove();
				}
			});
		</script>
		<?php 	
	}
	
	/**
	 * add admin nodes
	 * @since: 5.0.5
	 */
	public static function add_admin_menu_nodes(){
		if(!is_super_admin() || !is_admin_bar_showing()) return;
		
		self::_add_node('<span class="rs-label">Slider Revolution</span>', false, admin_url('admin.php?page=revslider'), array('class' => 'revslider-menu' ), 'revslider'); //<span class="wp-menu-image dashicons-before dashicons-update"></span>
		
		//add all nodes of all Slider
		$sl = new RevSliderSlider();
		$sliders = $sl->getAllSliderForAdminMenu();
		
		if(!empty($sliders)){
			foreach($sliders as $id => $slider){
				self::_add_node('<span class="rs-label" data-alias="'.esc_attr($slider['alias']).'">'.esc_html($slider['title']).'</span>', 'revslider', admin_url('admin.php?page=revslider&view=slide&id=new&slider='.intval($id)), array('class' => 'revslider-sub-menu' ), esc_attr($slider['alias'])); //<span class="wp-menu-image dashicons-before dashicons-update"></span>
			}
		}
		
	}
	
	
	/**
	 * add admin node
	 * @since: 5.0.5
	 */
	public static function _add_node($title, $parent = false, $href = '', $custom_meta = array(), $id = ''){
		global $wp_admin_bar;
		
		if(!is_super_admin() || !is_admin_bar_showing()) return;
		
		if($id == '') $id = strtolower(str_replace(' ', '-', $title));

		// links from the current host will open in the current window
		$meta = strpos( $href, site_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new tab/window
		$meta = array_merge( $meta, $custom_meta );

		$wp_admin_bar->add_node(array(
			'parent' => $parent,
			'id'     => $id,
			'title'  => $title,
			'href'   => $href,
			'meta'   => $meta,
		));
	}
	
	
	/**
	 *
	 * create db tables
	 */
	public static function createDBTables(){
		if(get_option('revslider_change_database', false) || get_option('rs_tables_created', false) === false){
			self::createTable(RevSliderGlobals::TABLE_SLIDERS_NAME);
			self::createTable(RevSliderGlobals::TABLE_SLIDES_NAME);
			self::createTable(RevSliderGlobals::TABLE_STATIC_SLIDES_NAME);
			self::createTable(RevSliderGlobals::TABLE_CSS_NAME);
			self::createTable(RevSliderGlobals::TABLE_LAYER_ANIMS_NAME);
			self::createTable(RevSliderGlobals::TABLE_NAVIGATION_NAME);
		}
		update_option('rs_tables_created', true);
		update_option('revslider_change_database', false);
		
		self::updateTables();
	}
	
	public static function load_icon_fonts(){
		global $fa_icon_var,$pe_7s_var;
		if($fa_icon_var) echo "<link rel='stylesheet' property='stylesheet' id='rs-icon-set-fa-icon-css'  href='" . RS_PLUGIN_URL . "public/assets/fonts/font-awesome/css/font-awesome.css' type='text/css' media='all' />";
		if($pe_7s_var) echo "<link rel='stylesheet' property='stylesheet' id='rs-icon-set-pe-7s-css'  href='" . RS_PLUGIN_URL . "public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css' type='text/css' media='all' />";
	}
	
	public static function updateTables(){
		$cur_ver = get_option('revslider_table_version', '1.0.0');
		if(get_option('revslider_change_database', false)){
			$cur_ver = '1.0.0';
		}
		
		if(version_compare($cur_ver, '1.0.1', '<')){ //add missing settings field, for new creates lines in slide editor for example
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$tableName = RevSliderGlobals::TABLE_SLIDES_NAME;
			$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
						  id int(9) NOT NULL AUTO_INCREMENT,
						  slider_id int(9) NOT NULL,
						  slide_order int not NULL,
						  params LONGTEXT NOT NULL,
						  layers LONGTEXT NOT NULL,
						  settings text NOT NULL,
						  UNIQUE KEY id (id)
						);";
			dbDelta($sql);
			
			$tableName = RevSliderGlobals::TABLE_STATIC_SLIDES_NAME;
			$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
						  id int(9) NOT NULL AUTO_INCREMENT,
						  slider_id int(9) NOT NULL,
						  params LONGTEXT NOT NULL,
						  layers LONGTEXT NOT NULL,
						  settings text NOT NULL,
						  UNIQUE KEY id (id)
						);";
			dbDelta($sql);
			
			update_option('revslider_table_version', '1.0.1');
			$cur_ver = '1.0.1';
		}
		
		if(version_compare($cur_ver, '1.0.2', '<')){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$tableName = RevSliderGlobals::TABLE_SLIDERS_NAME;
			
			$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
						  id int(9) NOT NULL AUTO_INCREMENT,
						  title tinytext NOT NULL,
						  alias tinytext,
						  params LONGTEXT NOT NULL,
						  settings text NULL,
						  UNIQUE KEY id (id)
						);";
			dbDelta($sql);
			
			update_option('revslider_table_version', '1.0.2');
			$cur_ver = '1.0.2';
		}
		
		if(version_compare($cur_ver, '1.0.3', '<')){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$tableName = RevSliderGlobals::TABLE_CSS_NAME;
			
			$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
						  id int(9) NOT NULL AUTO_INCREMENT,
						  handle TEXT NOT NULL,
						  settings LONGTEXT,
						  hover LONGTEXT,
						  advanced MEDIUMTEXT,
						  params TEXT NOT NULL,
						  UNIQUE KEY id (id)
						);";
			dbDelta($sql);
			
			update_option('revslider_table_version', '1.0.3');
			$cur_ver = '1.0.3';
		}
		
		if(version_compare($cur_ver, '1.0.4', '<')){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_SLIDERS_NAME ." (
					  UNIQUE KEY id (id)
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_SLIDES_NAME ." (
					  UNIQUE KEY id (id)
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_STATIC_SLIDES_NAME ." (
					  UNIQUE KEY id (id)
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_CSS_NAME ." (
					  UNIQUE KEY id (id)
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_LAYER_ANIMS_NAME ." (
					  UNIQUE KEY id (id)
					);";
			dbDelta($sql);
			
			update_option('revslider_table_version', '1.0.4');
			$cur_ver = '1.0.4';
		}
		
		if(version_compare($cur_ver, '1.0.5', '<')){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_LAYER_ANIMS_NAME ." (
					  settings text NULL
					);";
			dbDelta($sql);
			
			update_option('revslider_table_version', '1.0.5');
			$cur_ver = '1.0.5';
		}
		
		if(version_compare($cur_ver, '1.0.6', '<')){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_SLIDERS_NAME ." (
					 type VARCHAR(191) NOT NULL DEFAULT '',
					 params LONGTEXT NOT NULL
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_SLIDES_NAME ." (
					  settings text NOT NULL DEFAULT '',
					  params LONGTEXT NOT NULL,
					  layers LONGTEXT NOT NULL
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_STATIC_SLIDES_NAME ." (
					  params LONGTEXT NOT NULL,
					  layers LONGTEXT NOT NULL
					);";
			dbDelta($sql);
			$sql = "CREATE TABLE " .self::$table_prefix.RevSliderGlobals::TABLE_CSS_NAME ." (
					  advanced LONGTEXT
					);";
			dbDelta($sql);
			
			update_option('revslider_table_version', '1.0.6');
			$cur_ver = '1.0.6';
		}

	}
	
	
	/**
	 * create tables
	 */
	public static function createTable($tableName){
		$wpdb = rev_db_class::rev_db_instance();

		$parseCssToDb = false;

		$checkForTablesOneTime = get_option('revslider_checktables', '0');
		
		if($checkForTablesOneTime == '0'){
			update_option('revslider_checktables', '1');
			if(RevSliderFunctionsWP::isDBTableExists(self::$table_prefix.RevSliderGlobals::TABLE_CSS_NAME)){ //$wpdb->tables( 'global' )
				//check if database is empty
				$result = $wpdb->get_row("SELECT COUNT( DISTINCT id ) AS NumberOfEntrys FROM ".self::$table_prefix.RevSliderGlobals::TABLE_CSS_NAME);
				if($result->NumberOfEntrys == 0) $parseCssToDb = true;
			}
		}

		if($parseCssToDb){
			$RevSliderOperations = new RevSliderOperations();
			$RevSliderOperations->importCaptionsCssContentArray();
			$RevSliderOperations->moveOldCaptionsCss();
		}
		
		if(!get_option('revslider_change_database', false)){
			//if table exists - don't create it.
			$tableRealName = self::$table_prefix.$tableName;
			if(RevSliderFunctionsWP::isDBTableExists($tableRealName))
				return(false);
		}
		
		switch($tableName){
			case RevSliderGlobals::TABLE_SLIDERS_NAME:
			$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
						  id int(9) NOT NULL AUTO_INCREMENT,
						  title tinytext NOT NULL,
						  alias tinytext,
						  params LONGTEXT NOT NULL,
						  UNIQUE KEY id (id)
						);";
			break;
			case RevSliderGlobals::TABLE_SLIDES_NAME:
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  slider_id int(9) NOT NULL,
							  slide_order int not NULL,
							  params LONGTEXT NOT NULL,
							  layers LONGTEXT NOT NULL,
							  UNIQUE KEY id (id)
							);";
			break;
			case RevSliderGlobals::TABLE_STATIC_SLIDES_NAME:
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  slider_id int(9) NOT NULL,
							  params LONGTEXT NOT NULL,
							  layers LONGTEXT NOT NULL,
							  UNIQUE KEY id (id)
							);";
			break;
			case RevSliderGlobals::TABLE_CSS_NAME:
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  handle TEXT NOT NULL,
							  settings LONGTEXT,
							  hover LONGTEXT,
							  params LONGTEXT NOT NULL,
							  UNIQUE KEY id (id)
							);";
				$parseCssToDb = true;
			break;
			case RevSliderGlobals::TABLE_LAYER_ANIMS_NAME:
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  handle TEXT NOT NULL,
							  params TEXT NOT NULL,
							  UNIQUE KEY id (id)
							);";
			break;
			case RevSliderGlobals::TABLE_NAVIGATION_NAME:
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  name VARCHAR(191) NOT NULL,
							  handle VARCHAR(191) NOT NULL,
							  css LONGTEXT NOT NULL,
							  markup LONGTEXT NOT NULL,
							  settings LONGTEXT NULL,
							  UNIQUE KEY id (id)
							);";
			break;
			default:
				RevSliderFunctions::throwError("table: $tableName not found");
			break;
		}
		
                global $wpdb;
		//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$wpdb->runSql($sql);
		
		if(!get_option('revslider_change_database', false)){
			if($parseCssToDb){
				$RevSliderOperations = new RevSliderOperations();
				$RevSliderOperations->importCaptionsCssContentArray();
				$RevSliderOperations->moveOldCaptionsCss();
			}
		}

	}
	
	
	
	public function enqueue_styles(){
		
	}
	
	
	/**
	 * Change FontURL to new URL (added for chinese support since google is blocked there)
	 * @since: 5.0
	 */
	public static function modify_punch_url($url){
		$operations = new RevSliderOperations();
		$arrValues = $operations->getGeneralSettingsValues();
		
		$set_diff_font = RevSliderFunctions::getVal($arrValues, "change_font_loading",'');
		if($set_diff_font !== ''){
			return $set_diff_font;
		}else{
			return $url;
		}
	}
	
	
	/**
	 * Add Meta Generator Tag in FrontEnd
	 * @since: 5.0
	 */
	public static function add_meta_generator(){
		global $revSliderVersion;
		
		echo apply_filters('revslider_meta_generator', '<meta name="generator" content="Powered by Slider Revolution '.$revSliderVersion.' - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />'."\n");
	}

	/**
	 *
	 * adds async loading
	 * @since: 5.0
	 */
	public static function add_defer_forscript($url)
	{
	    if ( strpos($url, 'themepunch.enablelog.js' )===false && strpos($url, 'themepunch.revolution.min.js' )===false  && strpos($url, 'themepunch.tools.min.js' )===false )
	        return $url;
	    else if (is_admin())
	        return $url;
	    else
	        return $url."' defer='defer"; 
	}
	
}

	
?>