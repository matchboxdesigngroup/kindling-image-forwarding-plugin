<?php
/**
 * Kindling Image Forwarding - Helpers
 * @package Kindling_Image_Forwarding
 */

 /**
  * Checks if image forwarding is enabled
  *
  * @return boolean
  */
function kindling_image_forwarding_enabled()
{
    return (bool) apply_filters(
        'kindling_image_forwarding_enabled',
        config('kindling-image-forwarding.enabled')
    );
}

 /**
  * Replaces the forward URL if needed.
  *
  * @param string $uri
  * @return string
  */
function kindling_image_forwarding_replace_forward_uri($uri)
{
    if (!kindling_image_forwarding_enabled()) {
        return $uri;
    }

    // Let's check if the file exists before altering it.
    // You may want to upload files while testing even
    // though the primary access is from the forwarding site.
    if (file_exists(str_replace(network_home_url('/'), ABSPATH, $uri))) {
        return $uri;
    }

    return str_replace(
        network_home_url(),
        apply_filters(
            'kindling_image_forwarding_get_forward_url',
            config('kindling-image-forwarding.url') ? config('kindling-image-forwarding.url') : network_home_url()
        ),
        $uri
    );
}
