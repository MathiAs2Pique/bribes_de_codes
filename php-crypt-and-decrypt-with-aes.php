<?php

function crypter($tocrypt, $clechiffrement) {
    $plaintext = $tocrypt;
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC"); //méthode
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $clechiffrement, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $clechiffrement, $as_binary=true);
    $crypted = base64_encode( $iv.$hmac.$ciphertext_raw ); //Texte chiffré
    return $crypted; //on return le texte chiffre
};

function decrypter($hash, $clechiffrement) {
    $c = base64_decode($hash);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC"); //méthode
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $decrypted = openssl_decrypt($ciphertext_raw, $cipher, $clechiffrement, $options=OPENSSL_RAW_DATA, $iv); //texte déchiffré
    return $decrypted; //on return le texte déchiffré
};

?>
