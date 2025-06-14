<?php

include "../../database/koneksi.php";
include "../../database/model.php";

function send_notif($nomor, $pesan) {
    $token = "HsCtMv5poHL7eTAnNtVj";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.fonnte.com/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => array(
            'target' => $nomor, 
            'message' => $pesan
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    return $err ? false : true;
}
