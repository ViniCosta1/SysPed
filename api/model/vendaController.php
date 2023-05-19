<?php

include ("../connection/conn.php");

$requisicao = $_REQUEST;

date_default_timezone_set("America/Sao_Paulo");
$dataLocal = date('Y-m-d H:i:s', time());

if ($requisicao['operation'] == 'create') {
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "INSERT INTO VENDA (DATA, SUBTOTAL, DESCONTO, VLRTOTAL, STATUS, ATENDENTE_ID, FPAGAMENTO_ID, CLIENTE_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dataLocal,
            $requisicao['SUBTOTAL'],
            $requisicao['DESCONTO'],
            $requisicao['VLRTOTAL'],
            $requisicao['STATUS'],
            $requisicao['ATENDENTE_ID'],
            $requisicao['FPAGAMENTO_ID'],
            $requisicao['CLIENTE_ID']
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
    $sql = "SELECT * FROM VENDA WHERE 1=1";

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
        $sql = "UPDATE VENDA SET DATA = ?, SUBTOTAL = ?, DESCONTO = ?, VLRTOTAL = ?, STATUS = ?, ATENDENTE_ID = ?, FPAGAMENTO_ID = ?, CLIENTE_ID = ? WHERE ID = ?";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dataLocal,
            $requisicao['SUBTOTAL'],
            $requisicao['DESCONTO'],
            $requisicao['VLRTOTAL'],
            $requisicao['STATUS'],
            $requisicao['ATENDENTE_ID'],
            $requisicao['FPAGAMENTO_ID'],
            $requisicao['CLIENTE_ID'],
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
        $sql = "DELETE FROM VENDA WHERE ID = ?";
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