<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('daftplugInstantifyPwaPublic')) {
    class daftplugInstantifyPwaPublic {
    	public $name;
        public $description;
        public $slug;
        public $version;
        public $textDomain;
        public $optionName;

        public $pluginFile;
        public $pluginBasename;

        public $dependencies;

        public $settings;

        public $partials;

    	public function __construct($config) {
    		$this->name = $config['name'];
            $this->description = $config['description'];
            $this->slug = $config['slug'];
            $this->version = $config['version'];
            $this->textDomain = $config['text_domain'];
            $this->optionName = $config['option_name'];

            $this->pluginFile = $config['plugin_file'];
            $this->pluginBasename = $config['plugin_basename'];

            $this->dependencies = array();

            $this->settings = $config['settings'];

            $this->partials = $this->generatePartials();

            add_action('wp_enqueue_scripts', array($this, 'loadAssets'));
    	}

        public function loadAssets() {
            if (daftplugInstantify::isAmpPage()) {
                return;
            }
            
        	$this->dependencies[] = 'jquery';
            $this->dependencies[] = "{$this->slug}-public";

            wp_enqueue_script("{$this->slug}-pwa-uaparser", plugins_url('pwa/public/assets/js/script-uaparser.js', $this->pluginFile), array(), $this->version, true);
            $this->dependencies[] = "{$this->slug}-pwa-uaparser";

            wp_enqueue_script("{$this->slug}-pwa-toast", plugins_url('pwa/public/assets/js/script-toast.js', $this->pluginFile), array('jquery'), $this->version, true);
            $this->dependencies[] = "{$this->slug}-pwa-toast";

            if (daftplugInstantify::getSetting('pwaOfflineNotification') == 'on') {
                wp_enqueue_style("{$this->slug}-pwa-offlinenotification", plugins_url('pwa/public/assets/css/style-offlinenotification.css', $this->pluginFile), array(), $this->version);
                wp_enqueue_script("{$this->slug}-pwa-offlinenotification", plugins_url('pwa/public/assets/js/script-offlinenotification.js', $this->pluginFile), array(), $this->version, true);
                $this->dependencies[] = "{$this->slug}-pwa-offlinenotification";
            }

            if (daftplugInstantify::getSetting('pwaOfflineForms') == 'on') {
                wp_enqueue_script("{$this->slug}-pwa-offlineforms", plugins_url('pwa/public/assets/js/script-offlineforms.js', $this->pluginFile), array('jquery', "{$this->slug}-pwa-toast"), $this->version, true);
                $this->dependencies[] = "{$this->slug}-pwa-offlineforms";
            }

            if (daftplugInstantify::getSetting('pwaAjaxify') == 'on') {
                wp_enqueue_script("{$this->slug}-pwa-ajaxify", plugins_url('pwa/public/assets/js/script-ajaxify.js', $this->pluginFile), array('jquery'), $this->version, true);
                $this->dependencies[] = "{$this->slug}-pwa-ajaxify";
            }

            if (wp_is_mobile()) {
                if (daftplugInstantify::getSetting('pwaNavigationTabBar') == 'on') {
                    wp_enqueue_style("{$this->slug}-pwa-fontawesome", 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css', array(), $this->version);
                }

                if (daftplugInstantify::getSetting('pwaPullDownNavigation') == 'on') {
                    wp_enqueue_script("{$this->slug}-pwa-pulltonavigate", plugins_url('pwa/public/assets/js/script-pulltonavigate.js', $this->pluginFile), array(), $this->version, true);
                    $this->dependencies[] = "{$this->slug}-pwa-pulltonavigate";
                }

                if (daftplugInstantify::getSetting('pwaSwipeNavigation') == 'on') {
                    wp_enqueue_script("{$this->slug}-pwa-touchevents", plugins_url('pwa/public/assets/js/script-touchevents.js', $this->pluginFile), array(), $this->version, true);
                    $this->dependencies[] = "{$this->slug}-pwa-touchevents";
                }

                if (daftplugInstantify::getSetting('pwaShakeToRefresh') == 'on') {
                    wp_enqueue_script("{$this->slug}-pwa-shake", plugins_url('pwa/public/assets/js/script-shake.js', $this->pluginFile), array(), $this->version, true);
                    $this->dependencies[] = "{$this->slug}-pwa-shake";
                }

                if (daftplugInstantify::getSetting('pwaVibration') == 'on') {
                    wp_enqueue_script("{$this->slug}-pwa-vibrate", plugins_url('pwa/public/assets/js/script-vibrate.js', $this->pluginFile), array('jquery'), $this->version, true);
                    $this->dependencies[] = "{$this->slug}-pwa-vibrate";
                }
            }

            wp_enqueue_style("{$this->slug}-pwa-public", plugins_url('pwa/public/assets/css/style-pwa.min.css', $this->pluginFile), array(), $this->version);
            wp_enqueue_script("{$this->slug}-pwa-public", plugins_url('pwa/public/assets/js/script-pwa.min.js', $this->pluginFile), $this->dependencies, $this->version, true);
        }

    	public function generatePartials() {
            $partials = array(
                'metaTags' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-metatags.php')),
                'rotateNotice' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-rotatenotice.php')),
                'fullscreenOverlays' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-fullscreenoverlays.php')),
                'headerOverlay' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-headeroverlay.php')),
                'checkoutOverlay' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-checkoutoverlay.php')),
                'postOverlay' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-postoverlay.php')),
                'registerServiceWorker' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-registerserviceworker.php')),
                'preloader' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-preloader.php')),
                'pushPrompt' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-pushprompt.php')),
                'pushButton' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-pushbutton.php')),
                'navigationTabBar' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-navigationtabbar.php')),
                'webShareButton' => plugin_dir_path(__FILE__) . implode(DIRECTORY_SEPARATOR, array('partials', 'display-websharebutton.php')),
            );

            return $partials;
    	}
    }
}