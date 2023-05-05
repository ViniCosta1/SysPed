<?php

include ("../connection/conn.php");

$requisicao = $_REQUEST;

if ($requisicao['operation'] == 'create') {
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "INSERT INTO ACESSO (NOME) VALUES (?)";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $requisicao['NOME']
        ]);
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro salvo com sucesso!'
        );
    } catch (PDOException $e) {
        $dados = array(
            'type' => 'error',
            'message' => 'Erro ao salvar o registro: '.$e
        );
    }

    echo json_encode($dados);
}

if ($requisicao['operation'] == 'read') {

}

if ($requisicao['operation'] == 'update') {
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "UPDATE ACESSO SET NOME = ? WHERE ID = ?";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $requisicao['NOME'],
            $requisicao['ID']
        ]);
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro atualizado com sucesso!'
        );
    } catch (PDOException $e) {
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao atualizar o registro: '.$e
        );
    }

    echo json_encode($dados);
}

if ($requisicao['operation'] == 'delete') {
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "DELETE FROM ACESSO WHERE ID = ?";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $requisicao['ID']
        ]);
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro excluído com sucesso!'
        );
    } catch (PDOException $e) {
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao excluir o registro: '.$e
        );
    }

    echo json_encode($dados);
}