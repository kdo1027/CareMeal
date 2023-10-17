<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('daftplugInstantifyFbiaPublicAdvertisements')) {
    class daftplugInstantifyFbiaPublicAdvertisements {
        public $name;
        public $description;
        public $slug;
        public $version;
        public $textDomain;
        public $optionName;

        public $pluginFile;
        public $pluginBasename;

        public $settings;

        public $daftplugInstantifyFbiaPublic;

        public function __construct($config, $daftplugInstantifyFbiaPublic) {
            $this->name = $config['name'];
            $this->description = $config['description'];
            $this->slug = $config['slug'];
            $this->version = $config['version'];
            $this->textDomain = $config['text_domain'];
            $this->optionName = $config['option_name'];

            $this->pluginFile = $config['plugin_file'];
            $this->pluginBasename = $config['plugin_basename'];

            $this->settings = $config['settings'];

            $this->daftplugInstantifyFbiaPublic = $daftplugInstantifyFbiaPublic;

            if (daftplugInstantify::getSetting('fbiaAudienceNetwork') == 'on') {
                add_filter("{$this->optionName}_articles_head", array($this, 'injectAdMetaTag'), 10, 2);
                add_filter("{$this->optionName}_articles_header", array($this, 'injectAdTag'), 10, 2);
            }
        }

        public function injectAdMetaTag($head, $postId) {
            $AdMetaTag = '<meta property="fb:use_automatic_ad_placement" content="enable=true ad_density=default">';

            return $AdMetaTag;
        }

        public function injectAdTag($header, $postId) {
            $placementId = daftplugInstantify::getSetting('fbiaAudienceNetworkPlacementId');
            
            $AdTag = '<figure class="op-ad">
                          <iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement='.$placementId.'&adtype=banner300x250"></iframe>
                      </figure>';

            return $header.$AdTag;
        }
    }
}