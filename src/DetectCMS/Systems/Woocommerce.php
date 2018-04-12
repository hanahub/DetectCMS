<?php
namespace DetectCMS\Systems;

class Woocommerce extends \DetectCMS\DetectCMS {

	public $methods = array(
		"generator_meta",
		"scripts",
		"api",
	);

	public $home_html = "";
  public $home_headers = array();
	public $url = "";

  function __construct($home_html, $home_headers, $url) {
          $this->home_html = $home_html;
          $this->home_headers = $home_headers;
          $this->url = $url;
  }
	/**
	 * Check meta tags for generator
	 * @return [boolean]
	 */
	public function generator_meta() {

		if($this->home_html) {

			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");

			if($html = str_get_html($this->home_html)) {

				if($meta = $html->find("meta[name='generator']",0)) {
          //$meta2 = $html->find("meta[name='generator']",1);


					if( strpos($meta->content, "WordPress") !== FALSE ) {
            if(preg_match("/<meta name=\"generator\" content=\"WooCommerce/", $this->home_html)) {
              return TRUE;
            }
          }

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check for WordPress Core scripts
	 * @return [boolean]
	 */
	public function scripts() {

		if($this->home_html) {

      if(\preg_match("/var woocommerce_params = {\"ajax_url\":/",$this->home_html)) {
        return TRUE;
      }
		}

		return FALSE;

	}

}
