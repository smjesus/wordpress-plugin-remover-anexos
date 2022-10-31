<?php
/*
Plugin Name: Remover Anexos
Plugin URI: 
Description: Remove as mídias anexadas a um CPT
Version: 1.0
Author: Sergio Murilo
Author URI: https://www.aeroceti.com
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html 
*/

// Bloqueia acesso direto:
defined( 'ABSPATH' ) || exit;

// Includes:
require_once ( plugin_dir_path(__FILE__) . 'ra_config_panel.php' );
require_once ( plugin_dir_path(__FILE__) . 'ra_anexos_cpt.php' );


// ACTIONS:
add_action( 'wp_ajax_remover_anexos', 'remover_anexos_cpt');
add_action( 'wp_ajax_listar_anexos' , 'listar_anexos_cpt' );
add_action('jet-form-builder/custom-action/image_changed_on_form', 'validate_image_changed_on_form');
add_action( 'admin_init', 'cpt_list_fields' );
add_action( 'admin_menu', 'rac_configuracoes_menu' );


function code_script_ajax_cpt( $atts ) {
	$sufix_url_app = get_option( 'url_base_app' ) ;
	// monta o script que fara a chamada:
	$output = 
'<script>
    function remover_cpt($POST_ID) {
		if(confirm("Ao confirmar, todos os dados e arquivos vinculados serão apagados permanentemente. Confirma?")){
            jQuery.ajax({
                url: "' . $sufix_url_app . 'wp-admin/admin-ajax.php",
                type: "GET",
                data: {
                    action:   "remover_anexos",
					_post_id: $POST_ID ,
                },
                success: function(response) {
                    alert( "Removido com Sucesso!" );
                    window.location.href = window.location.href; 
                },
                error: function(response) {
                    alert( "Operacao Nao Realizada." );
                }
            });
        } else {
            return false;
        } 
    }
</script>';
	// envia para o Wordpress o codigo:
	return $output;
}
add_shortcode( 'ajax-code-cpt', 'code_script_ajax_cpt' );

/*
 *  End of File.
 */
