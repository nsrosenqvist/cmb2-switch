<?php namespace NSRosenqvist\CMB2\SwitchField;

class Integration
{
	static $init = false;

	static function init()
	{
		if (self::$init) {
			return;
		}

		$init = true;

        // Add assets
        add_action('admin_enqueue_scripts', function() {
			wp_register_style('cmb2_switch', self::plugins_url('cmb2-switch', '/assets/cmb2-switch.css', __FILE__, 1), false, '1.0.0');
            wp_enqueue_style('cmb2_switch');
        });

        // Renderer callback for switch
        add_action('cmb2_render_switch', function($field, $escaped_value, $object_id, $object_type, $field_type_object) {
            $id = $field_type_object->_id();
			$desc = $field_type_object->_desc(true);

            // Render checkbox with CMB2 (easiest way to get all the correct
            // attributes that are added by plugins)
            $checkbox = $field_type_object->checkbox(['value' => 1], boolval($escaped_value));

			// Extract input element from rendered checkbox
			$doc = new \DOMDocument();
			$doc->loadHTML($checkbox);
			$input = $doc->getElementById($field_type_object->_id());
			$input = $input->cloneNode(true);

			$doc = new \DOMDocument();
			$doc->appendChild($doc->importNode($input, true));
			$inputHTML = $doc->saveHTML();

			// Render HTML
            $switch = '<div class="cmb2-switch">';
			$switch .= $inputHTML;
            $switch .= '<label for="'.$id.'">Toggle</label>';
            $switch .= '</div>';

        	$switch .= '<div class="cmb2-switch-description">';
        	$switch .= $desc;
            $switch .= '</div>';

        	echo $switch;
        }, 10, 5);

        // Sanitization filter for switch
        add_filter('cmb2_sanitize_switch', function($override_value, $value) {
            return (boolval($value)) ? "1" : "0";
        }, 10, 2);
    }

	static function plugins_url($name, $file, $__FILE__, $depth = 0)
	{
		// Traverse up to root
		$dir = dirname($__FILE__);

		for ($i = 0; $i < $depth; $i++) {
			$dir = dirname($dir);
		}

		$root = $dir;
		$plugins = dirname($root);

		// Compare plugin directory with our found root
		if ($plugins !== WP_PLUGIN_DIR || $plugins !== WPMU_PLUGIN_DIR) {
			// Must be a symlink, guess location based on default directory name
			$resource = $name.'/'.$file;
			$url = false;

			if (file_exists(WPMU_PLUGIN_DIR.'/'.$resource)) {
				$url = WPMU_PLUGIN_URL.'/'.$resource;
			}
			elseif (file_exists(WP_PLUGIN_DIR.'/'.$resource)) {
				$url = WP_PLUGIN_URL.'/'.$resource;
			}

			if ($url) {
				if (is_ssl() && substr($url, 0, 7) !== 'https://') {
					$url = str_replace('http://', 'https://', $url);
				}

				return $url;
			}
		}

		return plugins_url($file, $root);
	}
}
