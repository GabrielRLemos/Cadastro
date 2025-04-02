<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id_funcionario = intval($_POST['id_funcionario']);
    $nome_funcionario = $_POST['nome_funcionario'];
    $id_departamento = intval($_POST['id_departamento']);
    $email = $_POST['email'];

    $sql_update = "UPDATE funcionarios SET nome_funcionario = ?, id_departamento = ?, email = ? WHERE id_funcionario = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sisi", $nome_funcionario, $id_departamento, $email, $id_funcionario);

    if ($stmt_update->execute()) {
        echo "<script>alert('Funcionário atualizado com sucesso!'); window.location.href='consulta.php';</script>";
    } else {
        echo "Erro ao atualizar funcionário: " . $stmt_update->error;
    }
}
?>