<?php

try {
    require 'vatinfo-panels-config.php';

    $pdo = new PDO('mysql:host=' . $database_host . '; dbname=' . $database_name, $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = '';
    $ident = $_GET['ident'];
    $action = $_GET['action'];
    $type = $_GET['type'];
    $response = [];

    if ($action == "save") {
        $postdata = file_get_contents('php://input');

        $json_postdata = json_decode($postdata, TRUE);
        if ($type == "metar") {
            $query = "delete from vatinfo where ident='" . $ident . "' and metar<>''";
        }
        if ($type == "cid") {
            $query = "delete from vatinfo where ident='" . $ident . "' and cid<>''";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        foreach ($json_postdata['data'] as $row) {
            if ($type == "metar") {
                $query = "INSERT INTO vatinfo (ident,cid,metar) VALUES ('" . $ident . "','','" . $row['icao'] . "')";
            }
            if ($type == "cid") {
                $query = "INSERT INTO vatinfo (ident,cid,metar) VALUES ('" . $ident . "','" . $row . "','')";
            }
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
    } elseif ($action == "load") {
        $query = "select * from vatinfo where ident='" . $ident . "'";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $response['data'] =  $data;
    }

    header("Content-Type:application/json");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    echo json_encode($response, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo 'Database error. ' . $e->getMessage();
}
