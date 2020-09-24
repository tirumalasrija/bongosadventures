<?php

namespace TMProd\Base\Assets;

/**
 * Object reference to manifest.json
 * The manifest.json defines the scripts & stylesheets that are
 * compiled during the build process.
 */
class JsonManifest {
    private $manifest;

    public function __construct( $manifest_path ) {
        if ( file_exists( $manifest_path ) ) {
            $this->manifest = json_decode( file_get_contents( $manifest_path ), true );
        } else {
            $this->manifest = [ ];
        }
    }

    public function get() {
        return $this->manifest;
    }

    public function getPath( $key = '', $default = null ) {
        $collection = $this->manifest;
        if ( is_null( $key ) ) {
            return $collection;
        }
        if ( isset( $collection[ $key ] ) ) {
            return $collection[ $key ];
        }
        foreach ( explode( '.', $key ) as $segment ) {
            if ( ! isset( $collection[ $segment ] ) ) {
                return $default;
            } else {
                $collection = $collection[ $segment ];
            }
        }

        return $collection;
    }
}

/**
 * Returns the path to the asset distribution directory
 *
 * @param $filename
 *
 * @return string
 */
function asset_path( $filename ) {
    $dist_path = get_template_directory_uri() . DIST_DIR;
    $directory = dirname( $filename ) . '/';
    $file      = basename( $filename );
    static $manifest;

    if ( empty( $manifest ) ) {
        $manifest_path = get_template_directory() . DIST_DIR . 'assets.json';
        $manifest      = new JsonManifest( $manifest_path );
    }

    if ( array_key_exists( $file, $manifest->get() ) ) {
        return $dist_path . $directory . $manifest->get()[ $file ];
    } else {
        return $dist_path . $directory . $file;
    }
}

/**
 * Handle assets
 *
 * Register, de-register, & enqueue theme scripts & stylesheets.
 */
function assets() {

    // Add main stylesheet
    wp_enqueue_style( 'base/css', asset_path( 'styles/main.css' ), false, null );

    // Add main script-file
    wp_enqueue_script( 'main/js', asset_path( 'scripts/main.js' ), [ 'jquery' ], null, true );

    // Comment reply scripts if required
    if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100 );
