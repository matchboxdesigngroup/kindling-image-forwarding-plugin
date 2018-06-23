<?php
/**
 * Kindling Image Forwarding - Filters
 * @package Kindling_Image_Forwarding
 */

add_action('kindling_ready', function () {
    add_filter('kindling_config_directories', function ($directories) {
        $directories[] = __DIR__ . '/config';
        return $directories;
    });


    /**
     * Updates the attachment image src uri.
     */
    add_filter('wp_get_attachment_image_src', function ($image, $attachment_id, $size, $icon) {
        if (!$image) {
            return $image;
        }

        $uri = isset($image[0]) ? $image[0] : '';
        $image[0] = kindling_image_forwarding_replace_forward_uri($uri);

        return $image;
    }, 10, 4);

    /**
     * Updates the attachment image srcset uri.
     */
    add_filter('wp_calculate_image_srcset', function ($sources, $size_array, $image_src, $image_meta, $attachment_id) {
        return array_map(function ($source) {
            $uri = isset($source['url']) ? $source['url'] : '';
            $source['url'] = kindling_image_forwarding_replace_forward_uri($uri);

            return $source;
        }, $sources);
    }, 10, 5);
});
