<?php

class LNM_Admin {
	private $options;
	public function __construct() {
		add_action('admin_menu', array($this, 'create_menu'));
		add_action('admin_init', array( $this, 'page_init'));
	}

	private function _get_menu() {
		return require_once LNM_PLUGIN_PATH.'/inc/lnm-menu.php';
	}

	public function create_menu() {
		$menu_config = $this->_get_menu();
		foreach($menu_config as $menu => $setting) {
			add_menu_page(
				$setting['page_title'],
				$setting['menu_title'],
				$setting['capability'],
				$setting['menu_slag'],
				array($this, $menu),
				LNM_PLUGIN_URL. $setting['icon_url']
			);
		}
	}
	public function create_lnm_menu() {
		$this->options = get_option('lnm_option_name');
		?>
		<div class="wrap">
			<h2>Latest News Marquee Settings</h2>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'lnm_option_group' );
					do_settings_sections( 'latest-news-marquee-settings' );
					submit_button();
				?>
			</form>
		</div>
	<?php
	}

	public function page_init() {
		register_setting(
			'lnm_option_group',
			'lnm_option_name',
			array($this, 'sanitize')
		);

		add_settings_section(
			'setting_section_id',
			'Settings Latest News',
			array($this, 'print_section_info'),
			'latest-news-marquee-settings'
		);


		add_settings_field(
			'lnm_news_label_id',
			'Label',
			array($this, 'lnm_news_label'),
			'latest-news-marquee-settings',
			'setting_section_id'
		);

		add_settings_field(
			'lnm_label_color',
			'Label Color',
			array($this, 'lnm_label_color'),
			'latest-news-marquee-settings',
			'setting_section_id'
		);

		add_settings_field(
			'lnm_news_color',
			'News Element Color',
			array($this, 'lnm_news_color'),
			'latest-news-marquee-settings',
			'setting_section_id'
		);
	}
	public function sanitize($input) {
		$new_input = array();
		if(isset($input['lnm_label_color']))
			$new_input['lnm_label_color'] = trim($input['lnm_label_color']);

		if(isset($input['lnm_news_label_id']))
			$new_input['lnm_news_label_id'] = trim($input['lnm_news_label_id']);

		if(isset($input['lnm_news_color']))
			$new_input['lnm_news_color'] = trim($input['lnm_news_color']);

		return $new_input;
	}

	public function print_section_info() {
		print 'Select a news paper so that you can show latest news';
	}


	public function lnm_news_label() {
		printf(
			'<input type="text" id="lnm_news_label_id" name="lnm_option_name[lnm_news_label_id]" value="%s" />',
			isset( $this->options['lnm_news_label_id'] ) ? esc_attr( $this->options['lnm_news_label_id']) : ''

		);
	}

	public function lnm_label_color() {
		printf(
			'<input type="color" id="lnm_label_color" name="lnm_option_name[lnm_label_color]" value="%s" />',
			isset( $this->options['lnm_label_color'] ) ? esc_attr( $this->options['lnm_label_color']) : ''

		);
	}

	public function lnm_news_color() {
		printf(
			'<input type="color" id="lnm_news_color" name="lnm_option_name[lnm_news_color]" value="%s" />',
			isset( $this->options['lnm_news_color'] ) ? esc_attr( $this->options['lnm_news_color']) : ''

		);
	}
}

$obj_lnm_admin = new LNM_Admin();
