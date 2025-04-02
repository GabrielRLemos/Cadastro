<?php
function getDepartamentos($conn) {
    $sql = "SELECT * FROM departamento";
    $result = $conn->query($sql);
    $departamentos = [];
    
    while ($row = $result->fetch_assoc()) {
        $departamentos[] = $row;
    }
    
    return $departamentos;
}