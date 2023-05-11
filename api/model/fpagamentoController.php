<?php

include ("../connection/conn.php");

$requisicao = $_REQUEST;

if ($requisicao['operation'] == 'create') {
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "INSERT INTO FPAGAMENTO (NOME) VALUES (?)";
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
    // Obter o númeor de colunas da nossa tabela
    $colunas = $requisicao['columns'];

    // Gerar a nossa query de consulta ao banco de dados
    $sql = "SELECT * FROM FPAGAMENTO WHERE 1=1";

    // Obter o total de registros encontrados
    $resultados = $pdo->query($sql);

    // Contar quantos registros tem nesse objeto
    $qtdLinhas = $resultado->rowCount();

    // Verificar se existe algum filtro determinado
    $filtro = $requisicao['search']['value'];
    if (!empty($filtro)) {
        $sql .= " AND (ID LIKE $filtro% ";
        $sql .= " OR NOME LIKE %$filtro) ";
    }

    // Obter o total de registros encontrados filtrados
    $resultados = $pdo->query($sql);

    // Contar quantos registros tem nesse objeto filtrado
    $totalFiltrados = $resultado->rowCount();

    // Obter os valores para ordenação de registro
    $colunaOrdem = $requisicao['ordem'][0]['column']; // obtendo a posição da coluna na ordenação
    $ordem = $colunas[$colunaOrdem]['data']; // obtendo o nome da coluna que será ordenada
    $direcao = $requisicao['order'][0]['dir']; // obtendo a direção da ordenação ASC | DESC

    // Obter os limites para a paginação dos dados
    $inicio = $requisicao['start']; // obtendo o inicio do limite
    $tamanho = $requisicao['length']; // obtendo o tamanho do limite

    // Realizar a nossa ordenação e os limites
    $sql .= " ORDER BY $ordem $direcao LIMIT $inicio $tamanho ";
    $resultado = $pdo->query($sql);
    $dados = array();
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $dados[] = array_map(null, $row);
    }

    // Montar o objeto JSON no padrão DataTables
    $json_data = array(
        "draw" => intval($requisicao['draw']),
        "recordsTotal" => intval($qtdLinhas),
        "recordsFiltered" => intval($totalFiltrados),
        "data" => $dados
    );

    echo json_encode($json_data);
}

if ($requisicao['operation'] == 'update') {
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "UPDATE FPAGAMENTO SET NOME = ? WHERE ID = ?";
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
        $sql = "DELETE FROM FPAGAMENTO WHERE ID = ?";
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