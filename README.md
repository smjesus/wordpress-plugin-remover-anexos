# Remover Arquivos Anexos de um CPT - (Wordpress plugin)

### Remover Anexos de um Custom Post Type (CPT)

Este plugin foi desenvolvido com a finalidade de remover os arquivos anexados em um CPT.  Estes arquivos são campos do tipo **Mídia** que podem conter uma imagem (JPG, PNG, GIF, etc) ou um outro documento qualquer (PDF, DOC, XML, etc).

Normalmente, quando um post personalizado é removido, os arquivos anexados à ele ficam no servidor, acessíveis na Aba Mídias do **Painel Administrativo do WordPress**.  Assim, este plugin possibilita a remoção desses arquivos juntamente com a deleção do Post propriamente dito.

Para **instalar** este plugin no seu WordPres, baixe todo o código no formato ZIP e proceda normalmente na tela de "Enviar plugin" no seu painel de controle do WordPress.

Após a instalação e ativação do plugin, para usá-lo siga os seguintes passos:

1. Configurar os parametros no menu **Configuração** -> "Remover Anexos":

1.1. No campo "URL BASE do Sistema" informe "/" para instalações do WordPress na raiz do dominio, ou "/nome-dir/" para o nome do diretório onde foi instalado o WordPress, por exemplo:  se o teu Wordpress está no endereço https://www.meusite.com.br/sistema então informe "/sistema/ " (somente o diretório com as barras iniciais e finais.  Se for um sub-dominio registrado no DNS informe somente "/".

1.2. Nos demais campos, evite deixa-los vazios, caso nao tenha nenhuma informação a informar, digite "nenhum" (sem as aspas).

2. No LISTING adicionar um componente Dynamic Field e como "Object Field" selecione "Post ID";  ative o "Customize field output" e formate a saida com o seguinte código:
```
	<button type="button" id="btn_delete_post" onclick="javascript: remover_cpt(%s);" >
	     <i class="fa  fa-trash-alt"></i>Deletar
	</button> 
```
3. Para formatar o visual do componente em sua página (designer) com o Dynamic Field selecionado, vá na aba AVANÇADO e utilize o "CSS Personalizado", como por exemplo:
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
4. Por fim, na página onde será apresentado o LISTING, insira o SHORTCODE:   ```[ajax-code-cpt]```  (isto colocará na página o codigo javascript que chama a função de Remover Anexos).

##
### Remover Anexos ao atualizar um CPT

Normalmente, quando você atualiza um CPT e troca uma imagem ou documento (campo mídia), o arquivo original não é removido da Galeria de Mídias do Wordpress, resultando em arquivos desnecessários em seu servidor.

Este plugin, implementa uma função que remove o arquivo da Galeria, caso seja alterado ou removido em um Formulário de Edição; para isto, é necessário três configurações:

1) acrescentar um campo hidden no referido formulário de edição, com o ID "campos_tipo_midia" e inserir nele uma lista com os campos que deseja aplicar a ação de remover os arquivos (uma lista de nomes dos campos separados por vírgula, exemplo: "campo_01, _thumbnail, documento_001");

2) caso o campo do formulário esteja atualizando a **Imagem de Destaque** do CPT então o ID do campo **deverá** ser definido como **_thumbnail**;

2.1. os campos do tipo **mídia** (imagens ou documentos) no formulário de edição, devem **obrigatóriamente** ter o seu ID com o mesmo nome do identificador (**slurg**) do campo no CPT;

3) na configuração do formulário, na opção "**Post Submit Actions**", adicionar uma ação do tipo "**Call Hook**" e preencher o campo "**Hook Name**" com "**image_changed_on_form**". Veja na imagem abaixo:
![Ilustração da configuração do Hook](https://github.com/smjesus/smjesus/blob/main/tela_config_plugin_01.png)


A inclusão do **campo hidden** deve ser feita somente nos formulários onde haja um campo mídia; caso tenha-se um formulário que não esteja alterando ou não tenha um campo mídia no CPT, todos os passos acima não são necessário e o plugin não terá nenhuma ação ao realizar o submit do formulário.


##

Bom trabalho!
