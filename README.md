# Remover Arquivos Anexos de um CPT - (Wordpress plugin)
### Plugin para WordPress - Remover Anexos de um Custom Post Type (CPT)

Este plugin foi desenvolvido com a finalidade de remover os arquivos anexados em um CPT.  Estes arquivos são campos do tipo **Mídia** que podem conter uma imagem (JPG, PNG, GIF, etc) ou um outro documento qualquer (PDF, DOC, XML, etc).

Normalmente, quando um post personalizado é removido, os arquivos anexados à ele ficam no servidor, acessíveis na Aba Mídias do **Painel Administrativo do WordPress**.  Assim, este plugin possibilita a remoção desses arquivos juntamente com a deleção do Post propriamente dito.

Para **instalar** este plugin no seu WordPres, baixe todo o código no formato ZIP e proceda normalmente na tela de "Enviar plugin" no seu painel de controle do WordPress.

Após a instalação e ativação do plugin, para usá-lo siga os seguintes passos:

1) Configurar os parametros no menu de configuração;

2) No LISTING adicionar um componente Dynamic Field e como "Object Field" selecione "Post ID";  ative o "Customize field output" e formate a saida com o seguinte código:

	<button type="button" id="btn_delete_post" onclick="javascript: remover_cpt(%s);" ><i class="fa  fa-trash-alt"></i>  Deletar</button> 
3) Para formatar o visual do componente em sua página (designer) com o Dynamic Field selecionado, vá na aba AVANÇADO e utilize o "CSS Personalizado", como por exemplo:
```
#btn_delete_post {
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
}
``` 
4) Por fim, na página onde será apresentado o LISTING, insira o SHORTCODE:   ```[ajax-code-cpt]```  (isto colocará na página o codigo javascript que chama a função de Remover Anexos).

