<?php
    include 'connection.php';
    include 'functions.php';
    
    $action = isset($_GET["action"]) ? htmlspecialchars($_GET["action"]) : '';

    switch($action) {
        case "holeMonatspraemie":
            $altersgruppe = isset($_POST['altersgruppe']) ? $_POST['altersgruppe'] : exit('Missing parameter: altersgruppe');
            $versicherungsmodell = isset($_POST['versicherungsmodell']) ? $_POST['versicherungsmodell'] : exit('Missing parameter: versicherungsmodell');
            $praemienregion = isset($_POST['praemienregion']) ? $_POST['praemienregion'] : exit('Missing parameter: praemienregion');
            $unfalldeckung = isset($_POST['unfalldeckung']) ? $_POST['unfalldeckung'] : exit('Missing parameter: unfalldeckung');
            echo json_encode(holeMonatspraemie($verbindung, $altersgruppe, $versicherungsmodell, $praemienregion, $unfalldeckung));
            break;
        case "getGemeindenByPLZ":
            $PLZ = isset($_POST['PLZ']) ? $_POST['PLZ'] : exit('Missing parameter: PLZ');
            echo json_encode(holeGemeinde($verbindung, $PLZ));
            break;
        default:
            exit('No action defined. Easy fix. 😎');
            break;
    }
    exit();
?>