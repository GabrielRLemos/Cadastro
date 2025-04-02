<?php
if (!function_exists('getFuncionariosFiltrados')) {
    function getFuncionariosFiltrados($conn, $filtro_departamento = '') {
        // Prevenir SQL injection
        $where = '';
        if (!empty($filtro_departamento)) {
            $filtro_departamento = intval($filtro_departamento);
            $where = " WHERE f.id_departamento = " . $filtro_departamento;
        }
        
        $sql = "SELECT f.id_funcionario, f.nome_funcionario, f.cpf, f.id_departamento, f.email, d.nome_departamento 
                FROM funcionarios f 
                JOIN departamento d ON f.id_departamento = d.id_departamento" . $where;
        
        $result = $conn->query($sql);
        
        if (!$result) {
            error_log("Erro SQL: " . $conn->error);
            return false;
        }
        
        return $result;
    }
}
?>