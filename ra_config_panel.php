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


/**
 *  Esta funcao cria o campo para entrada de dados no Painel do Wordpress.
 *  Criada por Sergio Murilo  -  Set/2022
 */
function cpt_list_fields() {
	// Adiciona uma secao para o campo
	// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
	add_settings_section('minha_secao', 'Informa&ccedil;&otilde;es Necess&aacute;rias', function( $args ) { echo '<p>Listagem dos MetaFields que s&atilde;o Midia Type.</p>'; }, 'grac_minhas_configuracoes' 	);
	
	// Registra o campo de entrada de dados para MIDIA
	// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
	register_setting(
		'grac_minhas_configuracoes',
		'lista_campos_cpt',
		$lista_campos,
	);
	// Adicona o campo para MIDIAS
	add_settings_field(
		'lista_campos_cpt',
		'Nomes dos Campos Midia do CPT',
		function( $args ) {
			$options = get_option( 'lista_campos_cpt' );
			?>
			<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="lista_campos_cpt" value="<?php echo esc_attr( $options ); ?>" size="80">
			<?php
		},
		'grac_minhas_configuracoes',
		'minha_secao',
		[ 'label_for' => 'lista_campos_cpt_id', 'class'     => 'classe-html-tr',	]
	);	
	
	// Registra o campo de entrada de dados para GALERIAS
	// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
	register_setting(
		'grac_minhas_configuracoes',
		'lista_galerias_cpt',
		$lista_galerias,
	);	
	// Adicona o campo para GALERIAS
	add_settings_field(
		'lista_galerias_cpt',
		'Nomes dos Campos de Galerias do CPT',
		function( $args ) {
			$options = get_option( 'lista_galerias_cpt' )  ;
			?>
			<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="lista_galerias_cpt" value="<?php echo esc_attr( $options ); ?>" size="80">		
			<?php
		},
		'grac_minhas_configuracoes',
		'minha_secao',
		[ 'label_for' => 'lista_galerias_cpt_id', 'class'     => 'classe-html-tr',	]
	);		

	// Registra o campo de selecao do modo
	// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
	register_setting(
		'grac_minhas_configuracoes',
		'modo_delete_cpt',
		$modo_delete,
	);	
	// Adicona o campo de modo de exclusao
	add_settings_field(
		'modo_delete_cpt',
		'Modo de exclusao: ',
		function( $args ) {
			$options = get_option( 'modo_delete_cpt' )  ;
			?>
  			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"  name="modo_delete_cpt"  >
    			<option value="TRASH" <?php echo ( $options == "TRASH" ) ? "SELECTED" : "" ; ?> >Enviar para Lixeira</option>
    			<option value="FULL"  <?php echo ( $options == "FULL"  ) ? "SELECTED" : "" ; ?> >Deletar Permanentemente</option>
 			</select>			
			<?php
		},
		'grac_minhas_configuracoes',
		'minha_secao',
		[ 'label_for' => 'modo_delete_cpt_id', 'class'     => 'classe-html-tr',	]
	);		

	// Registra o campo de confirmar EXCLUSAO de GALERIAS
	// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
	register_setting(
		'grac_minhas_configuracoes',
		'is_delete_galerias_cpt',
		$delete_galerias,
	);	
	// Adicona o campo de Confirmar Delecao das GALERIAS
	add_settings_field(
		'is_delete_galerias_cpt',
		'Preservar Galerias do CPT',
		function( $args ) {
			$options = get_option( 'is_delete_galerias_cpt' )  ;
			?>
  			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"  name="is_delete_galerias_cpt"  >
    			<option value="SIM" <?php echo ( $options == "SIM" ) ? "SELECTED" : "" ; ?> >Sim</option>
    			<option value="NAO" <?php echo ( $options == "NAO" ) ? "SELECTED" : "" ; ?> >Não</option>
 			</select>			
			<?php
		},
		'grac_minhas_configuracoes',
		'minha_secao',
		[ 'label_for' => 'is_delete_galerias_cpt_id', 'class'     => 'classe-html-tr',	]
	);	

}

/**
 *  Esta funcao adiciona o MENU para a pagina de entrada de dados no Painel do Wordpress.
 */
function rac_configuracoes_menu() {
	add_options_page(
		'Remover Anexos do CPT',  // Título da página
		'Remover Anexos',         // Nome no menu do Painel
		'manage_options',         // Permissões necessárias
		'remover-anexos',         // Valor do parâmetro "page" no URL
		'remover_anexos_html'     // Função que imprime o conteúdo da página
	);
}
 
/**
 *  Esta funcao monta a pagina de entrada de dados para o Painel do Wordpress.
 */
function remover_anexos_html() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'grac_minhas_configuracoes' );
			do_settings_sections( 'grac_minhas_configuracoes' );
			submit_button();
			?>
		</form>
	</div>

	<div class="wrap">
	<p><span style="font-size:22px"><u><strong>Modo de usar</strong></u>:</span></p>
	<p>&nbsp;</p>
	<p>1) Configurar os parametros no menu de configura&ccedil;&atilde;o;</p>

	<p>2) No LISTING adicionar um componente <strong>Dynamic Field</strong> e como &quot;Object Field&quot; selecione &quot;Post ID&quot;;&nbsp; ative o &quot;Customize field output&quot; e formate&nbsp;a saida com o seguinte c&oacute;digo:</p>

	<pre>
	<code>&lt;button type="button" id="btn_delete_post" onclick="javascript: remover_cpt(%s);" &gt;&lt;i class="fa  fa-trash-alt"&gt;&lt;/i&gt;  Deletar&lt;/button&gt; </code></pre>

	<p>3) Para formatar o visual do componente em sua p&aacute;gina (designer) com o Dynamic Field selecionado, v&aacute; na aba AVAN&Ccedil;ADO e utilize o &quot;CSS Personalizado&quot;, como por exemplo:</p>

	<pre>
<code>#btn_delete_post {
  -webkit-border-radius: 4;
  -moz-border-radius: 4;
  border-radius: 4px;
  font-family: 'Inter';
  color: #ffffff;
  font-size: 16px;
  background: #8F201F;
  padding: 10px 20px 10px 20px;
  border: solid 3px;
  border-color: #8F201F;
  text-decoration: none;
}

#btn_delete_post:hover {
  background: #ffffff;
  color: #2E0101;
  text-decoration: none;
}</code></pre>

	<p>4) Por fim, na p&aacute;gina onde ser&aacute; apresentado o LISTING, insira o SHORTCODE:&nbsp; &nbsp;<strong>[ajax-code-cpt]&nbsp;&nbsp;</strong>(isto colocar&aacute; na p&aacute;gina o codigo javascript que chama a fun&ccedil;&atilde;o de Remover Anexos).</p>

	<p>&nbsp;</p>
		
	</div>
	<?php
}

/*
 *    End of File.
 */