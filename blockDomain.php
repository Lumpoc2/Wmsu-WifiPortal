<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = $_POST['domain'];
    if (!empty($domain)) {
        echo json_encode(blockDomainInPihole($domain));
    } else {
        echo json_encode(['success' => false, 'message' => 'Domain name is required']);
    }
}

function blockDomainInPihole($domain) {
    $api_key = "e95d070407e39d43d738badabe42893dce0726e7a2930cef760eaa36b6027a52";
    $url = "http://pi.hole/admin/api.php?list=black&add={$domain}&auth={$api_key}";

    $response = file_get_contents($url);

    if ($response) {
        return ['success' => true, 'message' => "Domain {$domain} successfully blocked."];
    }
    return ['success' => false, 'message' => "Failed to block domain."];
}
?>

YOUR_NEW_API_KEY