<?php

namespace Grav\Plugin\Shortcodes;
require_once(__DIR__.'/../classes/FlickrAPI.php');
use Grav\Common\Utils;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Grav\Plugin\Flickr\FlickrAPI;
use Grav\Plugin\Flickr\FlickrAPIException;
use Grav\Plugin\Flickr\Photoset;

class FlickrPhotosetShortcode extends Shortcode
{
    public function init()
    {
        $this->shortcode->getHandlers()->add('flickr-photoset', function(ShortcodeInterface $sc) {
            $content = $sc->getContent();
            $id = $sc->getParameter('id', '');
            $api = new FlickrAPI();
            try {
                $photoset = $api->photoset($id, $sc->getParameters() );
                $output = $this->twig->processTemplate('partials/flickr-photoset.html.twig', [
                    'photoset' => $photoset,
                ]);

                return $output;
            } catch(FlickrAPIException $e) {
                return $e->getMessage();
            }
        });
    }
}