<?php
require 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nomeF = $_POST['nomeF'];
        $departamento = $_POST['departamento'];
        $cpf = $_POST['cpf'];
        $cpf = preg_replace("/\D/", "", $_POST['cpf']); 
        $email = $_POST['email'];
    
        $stmt = $conn->prepare("INSERT INTO funcionarios (nome_funcionario, id_departamento, cpf, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $nomeF, $departamento, $cpf, $email);
    
        try {
            if ($stmt->execute()) {
                echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href='index.html';</script>";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {  
                echo "<script>alert('Erro: CPF já cadastrado!'); window.location.href='index.html';</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar funcionário! (CPF invalido ou erro na conexão).'); window.location.href='index.html';</script>";
            }
        }
    }
    $stmt->close();
    $conn->close();
    exit();
?>
