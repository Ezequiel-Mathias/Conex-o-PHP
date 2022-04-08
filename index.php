<?php

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

    //Mudamos a ação do form para edita o registro no click do botão salvar
$form = "router.php?componente=contatos&action=editar&id=".$id;

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
                <form  action="<?=$form?>" name="frmCadastro" method="post" >
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
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50"  rows="7"><?=isset($obs)?$obs:null?></textarea>
                        </div>
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
                 $listcontatos = listarrContatos();
                 //estrutura de repetição para retorar os dados do array 
                 // e printar na tela  
                 foreach($listcontatos as $item){
                 ?>
                <tr id="tblLinhas">
                    <td class="tblColunas registros"><?=$item['Nome']?></td>
                    <td class="tblColunas registros"><?=$item['Celular']?></td>
                    <td class="tblColunas registros"><?=$item['Email']?></td>
                   
                    <td class="tblColunas registros">
                        <a href="router.php?componente=contatos&action=buscar&id=<?=$item['id']?>">
                            <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                        </a>
                            <a onclick="return confirm('Deseja realmente excluir este item ?')" href="router.php?componente=contatos&action=deletar&id=<?=$item['id']?>">
                            <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir" id="excluir">
                            </a>
                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                    </td>
                </tr>
            <?php
              }
            ?>
            </table>
        </div>
    </body>
</html>