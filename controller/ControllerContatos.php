<?php
/*******
 * objetivo : arquivo responsavel pela manipulacao de dados de contatos 
 * obs(esse arquivo fara a ponte entre a view e a model);
 * 
 * Data : 04/03/22
 * 
 * versao : 1.0
 */
//import do arquivo de configuração do projeto
require_once('modulo/config.php');

 function inserirContatos($dadoscontatos , $file){
      
     if(!empty($dadoscontatos)){              //verificando se a caixa esta vazia     //empty = serve para verificar se o elemento esta vazio 


     if(!empty($dadoscontatos['txtNome']) & !empty($dadoscontatos['txtCelular']) & !empty($dadoscontatos['txtEmail']) & !empty($dadoscontatos['sltEstado'])){

        if($file['fleFoto']['name'] != null){
            require_once('modulo/upload.php');
            $resultado = uploadFile($file['flefoto']);
           
        }
    
   
      $arreyDados = array(
            
      "nome" => $dadoscontatos['txtNome'],
      "telefone" => $dadoscontatos['txtTelefone'],
      "celular" => $dadoscontatos['txtCelular'],
      "email" => $dadoscontatos['txtEmail'],
      "obs" => $dadoscontatos['txtObs'],
      "idEstado" => $dadoscontatos['sltEstado']

        
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


 function atualizarContatos($dadoscontatos, $id){
     
    $statusUpload = (boolean) false;
    
    $id = $arreyDados['id'];

    $foto = $arreyDados['foto'];

    $file = $arreyDados['file'];

    if(!empty($dadoscontatos)){              //verificando se a caixa esta vazia     //empty = serve para verificar se o elemento esta vazio 


        if(!empty($dadoscontatos['txtNome']) & !empty($dadoscontatos['txtCelular']) & !empty($dadoscontatos['txtEmail'])){

            if(!empty($id) && $id != 0 && is_numeric($id)){
                if($file['fleFoto']['name'] != null){
                    //Import da função 
                    require_once('modulo/upload.php');

                    $novaFoto = uploadFile($file['fleFoto'])
                    $statusUpload = true;

                }else{
                    $novaFoto = $foto;
                }
                $arreyDados = array(
                "id" => $id,      
                "nome" => $dadoscontatos['txtNome'],
                "telefone" => $dadoscontatos['txtTelefone'],
                "celular" => $dadoscontatos['txtCelular'],
                "email" => $dadoscontatos['txtEmail'],
                "obs" => $dadoscontatos['txtObs'],
                "idestados" => $dadoscontatos['sltEstados']
                    
                 );


                    require_once('model/bd/contato.php');         //chamanda e mandando para a funcao insert la na model
                    if(updateContato($arreyDados)){
                        if($statusUpload){
                       
                        unlink(DIRETORIO_FILE_UPLOAD.$foto);
                        }
                        return true;
                    }else{

                            return array('idErro ' => 1, 
                            'message' => 'nao foi possivel Atualizar os dados Os dados no banco' );     
                    }

                }else{
                    return array(
                        'idErro' => 4,
                        'message' => 'Não é possivel excluir um registro sem imformar um id valido.'
                    );
                 }    

             }
             
             else {

              return array('idErro ' => 2,  'message' => 'existem campos obrigatorios que nao foram preenchidos');

             }



    }

     
 }


 function excluirContatos($id , $arrayDados){
    //Recebe o id do registro que sera excluido
    $id = $arrayDados['id'];
    //Recebe o nome da foto que séra excluido
    $foto = $arreyDados['foto'];

    

    if($id != 0 && !empty($id) && is_numeric($id)){
        require_once('model/bd/contato.php');
        require_once('model/bd/config.php');

        //Chama a função da model e valida se o retorno foi verdadeiro ou false
        
            //permite apagar a foto fisicamente do diretorio no servidor
            // a funçao unlink serve para apagar um arquivo de um diretorio
            //ai nela se passa o caminho e o nome da foto
            if (deleteContato($id)){
                //Validação para caso a foto não exista com o registro
                if($foto !=null){
           if (unlink(DIRETORIO_FILE_UPLOAD.$foto)){
            return true;
           }
           else{
            return array(
                'idErro' => 5,
                'message' => 'O registro do banco de Dados foi excluido com sucesso, porém a imagem não foi excluida do diretorio do servidor !'
            );
           }
        }   
        }else
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


