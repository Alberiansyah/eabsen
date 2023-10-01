<?php

require __DIR__ . '/../connections/connections.php';

function tampilData($request)
{
    global $pdo;
    $query = $pdo->prepare($request);
    $query->execute();
    $row = $query->fetchAll(PDO::FETCH_OBJ);

    return $row;
}

function tampilDataFirst($request, $array)
{
    global $pdo;
    $query = $pdo->prepare($request);
    $query->execute($array);
    $row = $query->fetch(PDO::FETCH_OBJ);

    return $row;
}
