<?php
    function holeMonatspraemie($verbindung, $altersgruppe, $versicherungsmodell, $praemienregion, $unfalldeckung) {
        $sql = "SELECT * FROM ".strtolower($verbindung->real_escape_string($altersgruppe))." WHERE Versicherungsmodell='".$verbindung->real_escape_string($versicherungsmodell)."' AND Kanton='".$verbindung->real_escape_string($praemienregion)."' AND Unfall='".$verbindung->real_escape_string($unfalldeckung)."'";
        return $verbindung->query($sql)->fetch_assoc();
    }

    function holeGemeinde($verbindung, $plz) {
        $sql = "SELECT * FROM orte WHERE PLZ = '".$verbindung->real_escape_string($plz)."'";
		$resultate = array();
        $resultat = $verbindung->query($sql);
        while($eintrag = $resultat->fetch_assoc()) {
            $resultate[] = $eintrag;
        }
        return $resultate;
    }
?>