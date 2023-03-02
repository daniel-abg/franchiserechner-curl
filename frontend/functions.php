<?php
    function fetchData($url, $request_method = 'GET', $parameter = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        
        if($request_method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        if (!empty($parameter)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));
        }
        $result = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($result, true);
    }

    function definiereAltersgruppe($prämienjahr, $jahrgang) {
        $altersjahr = $prämienjahr - $jahrgang;
        return ($altersjahr < 19) ? "Kinder" : (($altersjahr < 26) ? "Jugendliche" : "Erwachsene");
    }

    function definiereFranchisen($altersgruppe) {
        return $altersgruppe == "Kinder" ? [0, 100, 200, 300, 400, 500] : [300, 500, 1000, 1500, 2000, 2500];
    }

    function definiereUnfalldeckung($unfalldeckung) {
        return $unfalldeckung == 0 ? "nein" : ($unfalldeckung == 1 ? "ja" : "");
    }

    function definiereVersicherungsmodell($versicherungsmodell) {
        if(!isset($versicherungsmodell)) { return ""; }
        $modelle = [
            "freiearztwahl" => "Freie Arztwahl",
            "hausarztmodell" => "Hausarzt-Modell",
            "telmedmodell" => "Telmed-Modell",
            "digimedmodell" => "Digimed-Modell",
        ];
        return isset($modelle[$versicherungsmodell]) ? $modelle[$versicherungsmodell] : "";        
    }

    function berechneSelbstbehalt($franchise, $gesundheitskosten, $altersgruppe) {
        $selbstbehalt = ($gesundheitskosten - $franchise) * 0.1;
        $maxSelbstbehalt = ($altersgruppe === "Kinder") ? 350 : 700;
        return min($selbstbehalt, $maxSelbstbehalt);
    }
    
    function holeMonatspraemie($altersgruppe, $versicherungsmodell, $praemienregion, $unfalldeckung) {
        $url = 'http://localhost/franchiserechner-curl/backend/api.php?action=holeMonatspraemie';
        $parameter = [
            'altersgruppe' => $altersgruppe,
            'versicherungsmodell' => $versicherungsmodell,
            'praemienregion' => $praemienregion,
            'unfalldeckung' => $unfalldeckung
        ];
        return fetchData($url, 'POST', $parameter);
    }

    function holeGemeinde($PLZ) {
		if(!is_numeric($PLZ) OR $PLZ >= 10000 OR $PLZ <= 0) { 
			echo "";
			return;
		}

        $url = 'http://localhost/franchiserechner-curl/backend/api.php?action=getGemeindenByPLZ';
        $parameter = [
            'PLZ' => $PLZ
        ];
        $resultat = fetchData($url, 'POST', $parameter);

		if(count($resultat) == 0) { 
			echo "<p class='mt-3 mb-0'>Die Grundversicherung bieten wir lediglich in den Kantonen Wallis und Bern an.</p>";
			return;
		}

		echo "<div class='mt-3'>
				<select class='form-control' name='praemienort' style='height: 100% !important;'>";
                    foreach ($resultat as $eintrag) {
                        var_dump($eintrag);
						$gemeinde = $eintrag['Gemeinde'];
						$bfs = $eintrag['BFS'];
						$ort = $eintrag['Ort'];
						$praemienregion = $eintrag['Kanton'];	
						echo "<option value='".$praemienregion."'>".$ort." - ".$bfs." (".$gemeinde.")</option>";
					}	
		echo "	</select>
			</div>";
	}
?>