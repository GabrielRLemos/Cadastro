<?php
include 'connection.php';

if (isset($_POST['remover'])) {
    $id_funcionario = intval($_POST['id_funcionario']);
    $sql_delete = "DELETE FROM funcionarios WHERE id_funcionario = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_funcionario);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Funcionário removido com sucesso!'); window.location.href='consulta.php';</script>";
    } else {
        echo "Erro ao remover funcionário: " . $stmt_delete->error;
    }
}
?>