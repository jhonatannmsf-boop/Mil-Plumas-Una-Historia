<?php

function generarResumenIA($textoCompleto) {
    $apiKey = getenv('GEMINI_API_KEY') ?: "TU_API_KEY_DE_GEMINI"; 

    if (empty($apiKey) || $apiKey === "TU_API_KEY_DE_GEMINI") {
        return "Los escritores continúan tejiendo esta apasionante historia capítulo a capítulo. Sigue el hilo de los turnos para descubrir los secretos que aguardan.";
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

    $prompt = "Resume el siguiente avance de una historia colaborativa en máximo 2 o 3 oraciones concisas, destacando los acontecimientos clave para los siguientes escritores:\n\n" . $textoCompleto;

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $respuesta = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($respuesta, true);

    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
        return trim($json['candidates'][0]['content']['parts'][0]['text']);
    }

    return "Resumen no disponible en este momento.";
}
?>