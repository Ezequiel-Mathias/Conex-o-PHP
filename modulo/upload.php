<?php
/**************
 * obejtivo : Arquivo responsavel em realizar uploads de arquivos 
 * 
 * autor : ezequiel-mathias
 * 
 * data : 25/04/2022
 * 
 * versao : 1.0
 * 
/***************/

// função responsavel para fazer os uplouds das imagens
function uploadFile($arrayFile){

    //import do config
    require_once('modulo/config.php');

    $arquivo = $arrayFile;
    $sizeFile = (int) 0;
    $typeFile = (string) null;
    $nameFile = (string) null;

    //size tamanho do arquivo, fazendo as tratativas
    if($arquivo['size'] > 0 && $arquivo['type'] != ""){
        //dividindo por 1024 para transformar os bytes em kbaits, para melhorar a manipulação
        $sizeFile = $arquivo['size'] / 1024;
        //Recupera o tipo de arquivo 
        $typeFile = $arquivo['type'];
        //Recupera o nome do arquivo 
        $nameFile = $arquivo['name'];
        //Recupera o caminho do diretorio temporario que esta o arquivo 
        $tempFile = $arquivo['tmp_name'];

        //Validando para permitir o upload apenas de arquivos  de no maximo 5mb
        if($sizeFile <= MAX_FILE_UPLOAD){
            //Validação para peritir somente as extençoes validas
            if(in_array($typeFile,  EXT_FILE_UPLOAD) ){
                //separa somente o nome do arquivo sem a sua extenção
                $nome = pathinfo($nameFile, PATHINFO_FILENAME);
                //separa somente a extensao do arquivo sem o nome 
                $extensao = pathinfo($nameFile, PATHINFO_EXTENSION);

                //existem diversos algoritmos para criptografia de dados
                // md5() seguro
                // sha1() mediamente seguro
                // hash() mais seguro

            
                /* criptografando o nome */
                //esse uniquid id faz com que ele gere um um id, para ter 100% de certesa que não vão se repitir, esse time gera a hora e sehundos
                //para não se repitir tbm
                //o time pega a hora o minuto e o segundo do momento que esta sendo feito o upload da foto
                $nome = md5($nome.uniqid(time()));

                $foto = $nome.".".$extensao;
               
                

                //Envia o arquivo da pasta temporaria do apache para a pasta criada no projeto 
                if(move_uploaded_file($tempFile, DIRETORIO_FILE_UPLOAD.$foto)){
                    return $foto;

                }else{
                    return array('idErro ' => 13, 
                    'message' => 'Não foi possivel mover o arquivo para o servidor' );  
                }

            }else{
                return array('idErro ' => 12, 
                'message' => 'A extenção do arquivo selecionado não é permitido no uploud' );   
            }

        }else{
            return array('idErro ' => 10, 
            'message' => 'Tamanho de arquivo invalido no upload.' );   
        }
    }else{
        return array('idErro ' => 11, 
        'message' => 'Não é possivel realizar o upload sem um arquivo selecionado ' );   
    }


}

?>