<?php
/*******
 * objetivo : arquivo responsavel pela manipulacao de dados de contatos 
 * obs(esse arquivo fara a ponte entre a view e a model);
 * 
 * autor : Marcus
 * 
 * Data : 04/03/22
 * 
 * versao : 1.0
 */



 function inserirContatos($dadoscontatos){
      
     if(!empty($dadoscontatos)){              //verificando se a caixa esta vazia     //empty = serve para verificar se o elemento esta vazio 


        if(!empty($dadoscontatos['txtNome']) & !empty($dadoscontatos['txtCelular']) & !empty($dadoscontatos['txtEmail'])){
   
      $arreyDados = array(
            
      "nome" => $dadoscontatos['txtNome'],
      "telefone" => $dadoscontatos['txtTelefone'],
      "celular" => $dadoscontatos['txtCelular'],
      "email" => $dadoscontatos['txtEmail'],
      "obs" => $dadoscontatos['txtObs']
        
  );


        require_once('model/bd/contato.php');         //chamanda e mandando para a funcao insert la na model
         if(insertContato($arreyDados)){

             return true;

         }else{

                return array('idErro ' => 1, 
                'message' => 'nao foi possivel inserir os dados' );     
         }

         
             }else {

              return array('idErro ' => 2,  'message' => 'existem campos obrigatorios que nao foram preenchidos');

             }



    }

        
 }

 //função para buscar um contato atraves do id do registro
 function buscarContato($id){

    if($id != 0 && !empty($id) && is_numeric($id)){
        //import do arquivo de contato
        require_once('model/bd/contato.php');

       $dados = selectByIdContatos($id);


       //Valida se existem dados para serem devolvidos
       if(!empty($dados)){
        return $dados;
       }
       else{
        return false;
       }
       

 } else{
    return array(
        'idErro' => 4,
        'message' => 'Não é possivel buscar um registro sem imformar um id valido.'
    );
   }

 }


 function atualizarContatos(){
     
 }


 function excluirContatos($id){
    if($id != 0 && !empty($id) && is_numeric($id)){
        require_once('model/bd/contato.php');

        //Chama a função da model e valida se o retorno foi verdadeiro ou false
        if (deleteContato($id))
            return true;
        else
            return array(
                'idErro' => 3,
                'message' => 'O banco de dados não pode excluir o registro.'
            );
    }else{
        return array(
            'idErro' => 4,
            'message' => 'Não é possivel excluir um registro sem imformar um id valido.'
        );
    }
 }
 
 
 function listarrContatos(){
     
    require_once('./model/bd/contato.php');
    
    $dados = selectAllContatos();
 
    if(!empty($dados)){
           
        return $dados;
    }else{

        return false;
    }
}
