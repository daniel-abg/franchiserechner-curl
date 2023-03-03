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
?>