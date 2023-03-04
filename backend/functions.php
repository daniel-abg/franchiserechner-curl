<?php    
    function holeMonatspraemie($verbindung, $altersgruppe, $params) {
        $allowedTables = ['kinder', 'jugendliche', 'erwachsene']; // whitelist of allowed table names
        if (!in_array($altersgruppe, $allowedTables)) {
            throw new Exception("Invalid parameter: altersgruppe");
        }

        $sql = "SELECT * FROM {$altersgruppe} WHERE Versicherungsmodell=? AND Kanton=? AND Unfall=?";
        $stmt = $verbindung->prepare($sql);
        
        // Bind parameters
        $types = str_repeat('s', count($params));
        $bindParams = array_merge([$types], array_values($params));    
        $refs = array();
        foreach($bindParams as $key => $value) {
            $refs[$key] = &$bindParams[$key];
        }    
        call_user_func_array(array($stmt, 'bind_param'), $refs);
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function holeGemeinde($verbindung, $params) {
        $sql = "SELECT * FROM orte WHERE PLZ = ?";
        $stmt = $verbindung->prepare($sql);

        foreach ($params as $param) {
            $stmt->bind_param("s", $param);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
?>