<?php
// Vérifie si la connexion est en HTTPS
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    function getCertificateInfo($host = 'localhost', $port = 443) {
        $context = stream_context_create([
            "ssl" => [
                "capture_peer_cert" => true,
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            ]
        ]);
        $stream = stream_socket_client("ssl://{$host}:{$port}", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
        if (!$stream) {
            return "Failed to connect: $errno - $errstr";
        }
        $params = stream_context_get_params($stream);
        $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
        fclose($stream);
        return $cert;
    }
    $certInfo = getCertificateInfo();
    $validTo = (new DateTimeImmutable())->setTimestamp($certInfo['validTo_time_t']);
    echo "<div id='connection-info'>";
    echo "You are securely connected via HTTPS.<br>";
    echo "Common Name: " . $certInfo['subject']['CN'] . "<br>";
    echo "Issuer: " . $certInfo['issuer']['CN'] . "<br>";
    echo "Valid To: " . $validTo->format('jS F Y') . "<br>";
    echo "</div>";
} else {
    echo "<div id='connection-info'>";
    echo "Your connection is not secure. Please switch to <a href='https://localhost/'>HTTPS</a> for a secure connection.";
    echo "</div>";
}
?>