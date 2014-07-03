<?php
/**
 * Plugin Name: WP Gallery - Addon Lightbox
 * Plugin URI: http://crea8xion.com/features/wp-gallery-lightbox/
 * Description: This plugin will add a prettyPhoto lightbox on your media attachment gallery.
 * Version: 1.1
 * Author: crea8xion
 * Author URI: http://crea8xion.com
 * License: GPL2
    
 * Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : robpane126@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
**/

class wp_gallery_lightbox_addon{
    
    public function __construct(){
            
        add_filter( 'wp_get_attachment_link', array( &$this, 'wpgl_add_rel_attribute' ), 10, 6);      
        
        if ( !is_admin() ){
            add_action( 'wp_enqueue_scripts', array( &$this, 'wpgl_enqueue_script' ) );
            add_action( 'wp_footer', array( &$this, 'wpgl_the_script' ), 50 );
        }
    }
    
    public function wpgl_add_rel_attribute($content, $id, $size, $permalink, $icon, $text) {
        $image = wp_get_attachment_image_src($id, 'large');
        $content = preg_replace("/<a href/","<a rel=\"prettyPhoto[wpgl-slides]\" href=\"$image[0]\"",$content,1);
        return $content;        
    }
    
    public function wpgl_enqueue_script(){
        //register prettyPhoto js
        wp_enqueue_script( 'wpgl-pretty-photo-js', plugins_url( '/js/jquery.prettyPhoto.js', __FILE__ ), array('jquery'),'',true );
        
        // register prettyphoto stylesheet
        wp_enqueue_style( 'wpgl-pretty-photo-css', plugins_url( '/css/prettyPhoto.css', __FILE__ ) );
    }
    
    public function wpgl_the_script(){
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                if( typeof jQuery().prettyPhoto === "function" ){
                    //jQuery(".gallery a[rel^='prettyPhoto'], a[rel^='prettyPhoto']").prettyPhoto();
                    jQuery(".gallery a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:3000, autoplay_slideshow: false});
                }
            });
        </script>
    <?php    
    }
        
}

$wp_gallery_lightbox_addon = new wp_gallery_lightbox_addon(); 

?>