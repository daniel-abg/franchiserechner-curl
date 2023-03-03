<?php
    include 'connection.php';
    include 'functions.php';
    
    $action = isset($_GET["action"]) ? htmlspecialchars($_GET["action"]) : '';

    switch($action) {
        case "holeMonatspraemie":
            $requiredParams = ['altersgruppe', 'versicherungsmodell', 'praemienregion', 'unfalldeckung'];
            foreach($requiredParams as $param){
                ${$param} = $_POST[$param] ?? exit("Missing parameter: $param");
            }
            echo json_encode(holeMonatspraemie($verbindung, $altersgruppe, $versicherungsmodell, $praemienregion, $unfalldeckung));
            break;
        case "getGemeindenByPLZ":
            $requiredParams = ['PLZ'];
            foreach($requiredParams as $param){
                ${$param} = $_POST[$param] ?? exit("Missing parameter: $param");
            }
            echo json_encode(holeGemeinde($verbindung, $PLZ));
            break;
        default:
            exit('No action defined. Easy fix. 😎');
            break;
    }
    exit();
?>