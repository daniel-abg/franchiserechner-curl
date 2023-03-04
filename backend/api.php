<?php
    include 'connection.php';
    include 'functions.php';
    
    $action = isset($_GET["action"]) ? htmlspecialchars($_GET["action"]) : '';

    switch($action) {
        case "holeMonatspraemie":
            $requiredParams = [
                'versicherungsmodell',
                'praemienregion',
                'unfalldeckung'
            ];
            $params = [];
            $altersgruppe = $_POST['altersgruppe'] ?? exit("Missing parameter: altersgruppe");
            foreach ($requiredParams as $param) {
                $params[$param] = $_POST[$param] ?? exit("Missing parameter: $param");
            }
            echo json_encode(holeMonatspraemie($verbindung, $altersgruppe, $params));
            break;
        case "getGemeindenByPLZ":
            $requiredParams = ['PLZ'];
            $params = [];
            foreach ($requiredParams as $param) {
                $params[$param] = $_POST[$param] ?? exit("Missing parameter: $param");
            }
            echo json_encode(holeGemeinde($verbindung, $params));
            break;
        default:
            exit('No action defined. Easy fix. 😎');
            break;
    }
    exit();
?>