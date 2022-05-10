<?php
//Import do arquivo de configurações do projeto
require_once('modulo/config.php');

//Formas para resolver o problema das caixas com variaveis iniciais não definidas!
//1 Forma *
// Declarar as variaveis nome, telefone,celular,email,obs como null string ex:
/* $nome = (string) null;
$telefone = (string) null;
$celular = (string) null; */
//(forma consideravel correta)



//2 Forma *
// @ basta ir la em baixo (na index, parte do html) e colocar o @ ex: 
/* //<?=@$nome?> */ 
//(forma consideravel errada)


//3 Forma *
//if ternario (na index, parte do html)
//ex:
/* <?=isset($nome)?$nome:null?> */
//(forma mais consederavel certa!)
//isso quer dizer que, a variavel nome esta criada ? se sim pode correr normalmente, se não recebe null



//Valida se a utilização de variaveis de sessão
//esta vazia


//essa variavel foi criada para diferenciar no action do formulario
//qual ação deveria ser levada para a router (inserir ou editar).
//Nas condiçoes abaixo, mudados o action dessa variavel para a ação de editar

$form = (string) "router.php?componente=contatos&action=inserir";

//Variavel para carregar o nome da foto no banco de dados 
$foto = (string) null;
//Variavel para carregar o nome do estado no banco de dados 
$idestado = (string) null;
if(session_status()){
    //Valida se a variavel de sessão dadosContato
    //Não esta vazia
    if(!empty($_SESSION['dadosContato']))
    {    
    $id         =$_SESSION['dadosContato']['id'];
    $nome       =$_SESSION['dadosContato']['Nome'];
    $telefone   =$_SESSION['dadosContato']['Telefone'];
    $celular    =$_SESSION['dadosContato']['Celular'];
    $email      =$_SESSION['dadosContato']['Email'];
    $obs        =$_SESSION['dadosContato']['Obs'];
    $foto        =$_SESSION['dadosContato']['foto'];
    $idestado        =$_SESSION['dadosContato']['idestado'];

    //Mudamos a ação do form para edita o registro no click do botão salvar
$form = "router.php?componente=contatos&action=editar&id=".$id."&foto=".$foto;

//Destroi uma variavel da memoria do servidor 
unset($_SESSION['dadosContato']);
    }

}

?>


<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="JS/main.js" defer></script>

    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
                
            </div>
            <div id="cadastroInformacoes">
            <!--  o enctype="multipart/form-data" no form é obrigatorio para enviar arquivos do formulario em html para o servidor. -->
                <form  action="<?=$form?>" name="frmCadastro" method="post" enctype="multipart/form-data" >
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?=isset($nome)?$nome:null?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Estado: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <select name="sltEstado" >
                            <option value="">Selecione um item </option>
                            <?php

                            require_once('controller/controllerEstados.php');
                            //chama a função para carregar todos os estados do BD
                            $listarEstados = listarrEstado();
                            foreach ($listarEstados as $item)
                            {

                                
                                ?>
                            
                                    <option <?= $idestado == $item['idestado']?'selected':null?> value="<?=$item['idestado']?>"><?=$item['Nome']?></option>
                                <?php
                            }

                            ?>
                            </select>
                        </div>
                    </div>
                                     
                        <div class="campos">
                            <div class="cadastroInformacoesPessoais">
                                <label> Telefone: </label>
                            </div>
                            <div class="cadastroEntradaDeDados">
                                <input type="tel" name="txtTelefone" value="<?=isset($telefone)?$telefone:null?>">
                            </div>
                        </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?=isset($celular)?$celular:null?>">
                        </div>
                    </div>
                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?=isset($email)?$email:null?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Escolha um arquinho</label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                        <!-- o accept serve para colocar as extençoes qye vai poder aceitar quando fizer o uploud de imagens -->
                            <input type="file" name="flefoto" accept=".jpg, .png, .jpeg, .gif">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50"  rows="7"><?=isset($obs)?$obs:null?></textarea>
                        </div>
                    </div>
                    <div class="campos">
                    <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" alt="">
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
               <?php
                //import do arquivo daq controller para solicitar a listagem dos dados 
                 require_once('controller/ControllerContatos.php');
                 //chama a funçao que vai retornar os dados de contatos
                 if($listcontatos = listarrContatos()){

                 
                 //estrutura de repetição para retorar os dados do array 
                 // e printar na tela  
                 foreach($listcontatos as $item){
                    $foto = $item['foto'];
                    

                 ?>
                <tr id="tblLinhas">
                    <td class="tblColunas registros"><?=$item['Nome']?></td>
                    <td class="tblColunas registros"><?=$item['Celular']?></td>
                    <td class="tblColunas registros"><?=$item['Email']?></td>
                    <td class="tblColunas registros">
                    <img src="arquivos/<?=DIRETORIO_FILE_UPLOAD.$foto?>" class="foto">
                    </td>

                   
                    <td class="tblColunas registros">
                        <a href="router.php?componente=contatos&action=buscar&id=<?=$item['id']?>">
                            <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                        </a>
                            <a onclick="return confirm('Deseja realmente excluir este item ?')" href="router.php?componente=contatos&action=deletar&id=<?=$item['id']?>&foto<?=$foto?>">
                            <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir" id="excluir">
                            </a>
                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                    </td>
                </tr>
            <?php
              }
            }
            ?>
            </table>
        </div>
    </body>
</html>