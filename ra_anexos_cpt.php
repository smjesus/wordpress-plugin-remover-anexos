<?php
/**
 * Copyright (C) 2022 - by Sergio Murilo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// Bloqueia acesso direto:
defined( 'ABSPATH' ) || exit;

/*
 * Funcao que remove os arquivos de midia dos CPT
 * Criada por Sergio Murilo  -  Set/2022
 *
*/
function remover_anexos_cpt() {
	// Configura as variaveis locais:
	$cpt_id          = esc_attr( $_GET['_post_id'] );
    $post            = get_post($cpt_id);	
	$campos          = explode(',', get_option( 'lista_campos_cpt' ) );
	$isTrash         = get_option( 'modo_delete_cpt' ) == "TRASH" ? true : false ;
	$preserve_Galery = get_option( 'is_delete_galerias_cpt' ) ;
	
	// varre todos os metafilds especificados na Tela de Configuracao:
	foreach ( $campos as $cpt_field ) {	
		$metafield_id = get_post_meta( $post->ID, $cpt_field, true );  
		if( $metafield_id ) {
			wp_delete_attachment( $metafield_id, !$isTrash );
		}
	}
	
	// Deleta o Thambnail do Post, se houver:
	if( has_post_thumbnail($post->ID) && !$isTrash ) {
		wp_delete_attachment( get_post_thumbnail_id( $post ) , !$isTrash );
		delete_post_thumbnail( $post->ID );
	}
	
	// Deleta as Galerias se for o caso:
	if( $preserve_Galery == "NAO" ) {
		// varre todos as Galerias especificadas na Tela de Configuracao:
		$campos  = explode(',', get_option( 'lista_galerias_cpt' ) );
		foreach ( $campos as $cpt_field ) {	
			$fotos_da_galeria = explode(',', get_post_meta( $post->ID, $cpt_field, true ) ); 
			foreach ( $fotos_da_galeria as $foto_ID ) {	
				wp_delete_attachment( $foto_ID, !$isTrash );
			}
		}
	}
	
	// Deleta o POST finalmente:
	if( $isTrash ) {
		wp_trash_post( $cpt_id );
		echo "<BR> TRASH o post..." ;	
	} else {
		wp_delete_post( $cpt_id, true );
		echo "<BR> deletei o post..." ;	
	}
}

/**
 * Funcao que remove as midias alteradas nos formularios de EDICAO.
 * 
 * Ao editar um CPT, caso troque um arquivo de midia (foto ou documento), o antigo sera deletado
 * da Galeria de Midias por esta funcao.  Sem esse plugin, o arquivo permaneceria na galeria.
 * Para remover deve-se criar um campo hidden no formulario de edicao, com a lista dos id dos campos
 * que se deseja validar a troca.
 */
function validate_image_changed_on_form ( $post_id ) {
	$campos        = explode(',', $_POST['campos_tipo_midia'] );
	$post          = get_post($_POST['post_id']);
	
	if( !($campos[0] == NULL) ) {
		// varre todos os metafilds especificados no campo hidden:
		foreach ( $campos as $midia_field ) {
			$campo_midia   = $_POST[ $midia_field ] ;

			if( gettype( $campo_midia ) == "NULL" ) {
				$metafield_id = get_post_meta( $post->ID, $midia_field, true ); 
				if( $metafield_id == "" && $midia_field == "_thumbnail" ) {
					wp_delete_attachment( get_post_thumbnail_id( $post ) , true );
					delete_post_thumbnail( $post->ID );
				} 
				if( $metafield_id !== "" ) {
					wp_delete_attachment( $metafield_id, true );
				}
			} 
		}
	}
}

/*
 Funcao que LISTA os arquivos de midia dos CPT, atraves de uma chamada AJAX.
 Criada por Sergio Murilo  -  Set/2022
*/
function listar_anexos_cpt() {
	$cpt_id        = esc_attr( $_GET['_post_id'] );
    $post          = get_post($cpt_id);	
	$isTrash       = get_option( 'modo_delete_cpt' ) == "TRASH" ? true : false ;
	
	echo "<BR>POST: " . $post->post_title . "(ID=" . $post->ID . ')<BR>';
	// varre todos os metafilds especificados na Tela de Configuracao:
	$campos  = explode(',', get_option( 'lista_campos_cpt' ) );
	foreach ( $campos as $cpt_field ) {	
		echo  "<BR><BR>Mostrando anexos do campo: " . $cpt_field ;
		$metafield_id = get_post_meta( $post->ID, $cpt_field, true );  
		list_all_files_attached($metafield_id);		
	}
	
	if( has_post_thumbnail($post->ID) ) {
		echo  "<BR><BR>THUMBNAIL do Post: " ;
		list_all_files_attached( get_post_thumbnail_id( $post ) );
	}
	
	// varre todos as Galerias especificadas na Tela de Configuracao:
	$campos  = explode(',', get_option( 'lista_galerias_cpt' ) );
	foreach ( $campos as $cpt_field ) {	
		echo  "<BR><BR>Mostrando Galeria: " . $cpt_field . "<BR>";
		$fotos_da_galeria = explode(',', get_post_meta( $post->ID, $cpt_field, true ) ); 
		foreach ( $fotos_da_galeria as $galeria ) {	
			list_all_files_attached($galeria); echo "<BR><BR>";
		}
	}
	wp_die();
}


/**
 * Funcao de DEBUG para ver o link dos anexos. 
 */
function list_all_files_attached ( $attach_file_id ) {
	echo "[ID=" .  $attach_file_id . "]";
	$attachment =   wp_get_attachment_url( $attach_file_id) ;
	echo "<BR>1) " . $attachment ;
	$attachments = wp_get_attachment_image_src( $attach_file_id, 'full' ) 	;	
	echo "<BR>2) " . $attachments[0] ;
	$attachments = wp_get_attachment_image_src( $attach_file_id, 'thumbnail' ) 	;	
	echo "<BR>3) " . $attachments[0] ;
	$attachments = wp_get_attachment_image_src( $attach_file_id, 'medium' ) 	;	
	echo "<BR>4) " . $attachments[0] ;
	$attachments = wp_get_attachment_image_src( $attach_file_id, 'large' ) 	;	
	echo "<BR>5) " . $attachments[0] ;
}

/*
 *    End of File.
 */
