<?php

// Função para adicionar a venda

function adicionarVenda() {
    // Restante do código...

    global $conn;

    $query = "INSERT INTO vendas (data, item, expositor, forma_pagamento, valor, desconto, valor_com_desconto)
            VALUES (:data, :item, :expositor, :formaPagamento, :valor, :desconto, :valorComDesconto)";
    $stmt = $conn->prepare( $query );
    $stmt->bindParam( ':data', $data );
    $stmt->bindParam( ':item', $item );
    $stmt->bindParam( ':expositor', $expositor );
    $stmt->bindParam( ':formaPagamento', $formaPagamento );
    $stmt->bindParam( ':valor', $valor );
    $stmt->bindParam( ':desconto', $desconto );
    $stmt->bindParam( ':valorComDesconto', $valorComDesconto );

    try {
        $stmt->execute();
        echo 'Venda adicionada com sucesso!';
    } catch ( PDOException $e ) {
        echo 'Erro ao adicionar venda: ' . $e->getMessage();
    }

    // Restante do código...
}

// Função para carregar os expositores

function carregarExpositores() {
    global $conn;

    $query = 'SELECT id, nome FROM expositores';
    $stmt = $conn->prepare( $query );
    $stmt->execute();
    $expositores = $stmt->fetchAll( PDO::FETCH_ASSOC );

    echo json_encode( $expositores );
}

// Restante do código...