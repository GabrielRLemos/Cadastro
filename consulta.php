<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$base_path = __DIR__;

require $base_path . '/connection.php';
require $base_path . '/includes/listar_departamentos.php';
require $base_path . '/includes/editar_funcionarios.php';
require $base_path . '/includes/remover_funcionarios.php';
require_once $base_path . '/includes/filtro_departamento.php';

$departamentos = getDepartamentos($conn);

$filtro_departamento = isset($_POST['filtro_departamento']) ? intval($_POST['filtro_departamento']) : '';

$result = getFuncionariosFiltrados($conn, $filtro_departamento);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Funcionários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-3">
            <img src="gragasgame1.png" alt="Logo" class="me-3" style="height: 60px;">
            <h3 class="mb-0">Consulta de Funcionários</h3>
        </div>

        <!-- Filtro por Departamento -->
<form method="post" class="row g-3 mb-4 align-items-center">
    <div class="col-md-5">
        <select class="form-select" name="filtro_departamento">
            <option value="">Selecione um departamento</option>
            <?php foreach ($departamentos as $departamento) { ?>
                <option value="<?= $departamento['id_departamento'] ?>" <?= ($departamento['id_departamento'] == $filtro_departamento) ? "selected" : "" ?>>
                    <?= $departamento['nome_departamento'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
    </div>
    <div class="col-md-2">
    <a href="gerar_pdf.php?filtro=<?= $filtro_departamento ?>" class="btn btn-danger">
    <i class="bi bi-file-pdf"></i> Exportar PDF (FPDF)
</a>
    </div>
</form>

        <!-- Tabela de Funcionários -->
        <?php if ($result->num_rows > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">CPF</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Departamento</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { 
                            $cpfR = $row['cpf'];
                            $cpfF = "***." . substr($cpfR, 3, 3) . '.***.-**';
                            $id_departamento_atual = $row['id_departamento'];
                        ?>
                            <tr>
                                <form method="post">
                                    <td class="align-middle"><?= $row['id_funcionario'] ?></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="nome_funcionario" value="<?= htmlspecialchars($row['nome_funcionario']) ?>" required>
                                    </td>
                                    <td class="align-middle"><?= $cpfF ?></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm" name="id_departamento">
                                            <?php foreach ($departamentos as $departamento) { ?>
                                                <option value="<?= $departamento['id_departamento'] ?>" <?= ($departamento['id_departamento'] == $id_departamento_atual) ? "selected" : "" ?>>
                                                    <?= $departamento['nome_departamento'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <input type="hidden" name="id_funcionario" value="<?= $row['id_funcionario'] ?>">
                                            <button type="submit" name="editar" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-lg"></i> Salvar
                                            </button>
                                            <button type="submit" name="remover" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">
                                                <i class="bi bi-trash"></i> Remover
                                            </button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning text-center">Nenhum funcionário encontrado.</div>
        <?php } ?>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="index.html" class="btn btn-warning">
                <i class="bi bi-arrow-left"></i> Voltar ao Cadastro
            </a>
        </div>
    </div>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
