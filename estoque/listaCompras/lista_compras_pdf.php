<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../public/img/icone-LucreMais.png">

    <title>Manipulação de Arquivos</title>
</head>
<body>
    <?php
        require __DIR__.'/vendor/autoload.php';

        use Dompdf\Dompdf;
        use Dompdf\Options;

        //Instanciação do objeto options
        $options = new Options();
        
        //Permissão para renderização de elementos externos
        //$options->isRemoteEnabled(true)

        //Configuração da root para o diretório atual
        $options->setChroot(__DIR__);

        //Instanciação do objeto dompdf
        $dompdf = new Dompdf($options);

        //Configurando a folha em tamanho A4 e formato retrato
        $dompdf->setPaper('A4', 'portrait');

        //Armazenamento das saídas do arquivo em buffer
        ob_start();
        require 'lista_compras.php';

        //Envio do valor do buffer para a a classe
        $dompdf->loadHtml(ob_get_clean());

        //Renderização do arquivo PDF
        $dompdf->render();

        //Imprime o conteudo do pdf na tela
        header('Content-type: application/pdf');
        echo $dompdf->output();
    ?>
    
</body>
</html>