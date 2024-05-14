<?php 
// incluir o conexao na pagina e todo seu conteudo
include 'conexao.php';
include_once 'funcoes.php';

if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $id = $_GET['id'];

    if ($id > 0) {
        //abrir a conexao com o banco
        $conexaoComBanco = abrirBanco();  
        //Preparar um SQL de exclusão
        $sql = "DELETE FROM pessoas WHERE id = $id";
        //executar comando no banco
        if ($conexaoComBanco->query($sql) === TRUE) {
            echo "<script>alert ('Contato excluido com sucesso!')</script>";
        } else {
            echo "Contato excluido com sucesso! :(";
        }

        }
        fecharBanco($conexaoComBanco);
    }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <h1 class="h1Site">AGENDA DE CONTATOS</h1>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cadastrar.php">Cadastrar</a></li>
    </nav>
    </header>
    <section>
        <h2>Lista de Contatos</h2>
        <div class="cssTabela">
        <table class="tabela" border="2">
            <thead class="aThead">
                <tr>
                    <div class="tdCol">
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Sobrenome</td>
                    <td>Nascimento</td>
                    <td>Endereço</td>
                    <td>Telefone</td>
                    <td>Ações</td>
                    </div>
                </tr>   
            </thead>
            <body>
            <?php
                 //Abrir a conexão com banco de dados
                 $conexaoComBanco = abrirBanco();
                 //Preparar a consulta SQL para selecionar os dados no BD
                 $query = "SELECT id, nome, sobrenome, nascimento, endereco, telefone 
                        FROM pessoas";
                 //Executar a query (o sql no banco)
                $result = $conexaoComBanco->query($query);
                //$registros = $result->fetch_assoc();
                 //Verificar se a query retornou registros
                 if ($result->num_rows > 0) {
                    // tem registro no banco
                    while ($registro = $result->fetch_assoc()) {
                        // echo "<pre>";
                        // print_r($registro);
                        // echo"</pre>";
                        // exit;
                        ?> 
                           <tr>
                            <td><?= $registro['id']  ?></td>
                            <td><?= $registro['nome']  ?></td>
                            <td><?= $registro['sobrenome']  ?></td>
                            <td><?= date("d/m/Y", strtotime($registro['nascimento'])) ?></td>
                            <td><?= $registro['endereco']  ?></td>
                            <td><?= $registro['telefone']  ?></td>
                            <td>
                                <a href="editar.php?acao=editar&id=<?= $registro['id'] ?>"><button>Editar</button></a>
                                <a href="?acao=excluir&id=<?= $registro['id'] ?>"
                                onclick="return confirm('Tem certeza que deseja excluir?')">
                                <button>Excluir</button></a>

                            </td>
                           </tr>
                        
                        <?php


                    }


                 } else {
                    ?>
                     <tr>
                        <td colspan='7'>Nenhum registro encontrado no banco de dados</td>
                    </tr>
                    <?php
                 }
                
                 //Criar um laco de repetição para preencher a tabela


            ?>
            </body>
        </table>
        </div>
    </section>
</body>
</html>