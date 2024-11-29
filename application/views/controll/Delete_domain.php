<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Include your PiHoleAPI class file if it's in a separate file, or include the code directly
class PiHoleAPI {
    private $apiUrl;
    private $apiToken;

    public function __construct($piHoleUrl, $apiToken) {
        $this->apiUrl = rtrim($piHoleUrl, '/') . '/admin/api.php';
        $this->apiToken = $apiToken;
    }

    public function getStats() {
        $url = $this->apiUrl . "?status&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    public function addToBlocklist($domain) {
        $url = $this->apiUrl . "?list=black&add=" . urlencode($domain) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    public function removeFromBlocklist($domain) {
        $url = $this->apiUrl . "?list=black&sub=" . urlencode($domain) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    // Updated sendRequest method with error handling
    private function sendRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        
        // Error handling for curl
        if(curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            return null;
        }
        
        curl_close($ch);
        
        // Check if the response is empty or invalid
        if (empty($response)) {
            echo 'No response from Pi-hole API';
            return null;
        }
        
        return json_decode($response, true);
    }
}       

// // Example usage:
// $piHole = new PiHoleAPI('10.10.10.6', 'e95d070407e39d43d738badabe42893dce0726e7a2930cef760eaa36b6027a52');
// $stats = $piHole->getStats();
// print_r($stats);

// // Remove a domain from the blocklist
// $result = $piHole->removeFromBlocklist('rpiers.com');
// echo "Remove from blocklist: " . print_r($result, true);

// // Add a domain to the blocklist
// $result = $piHole->addToBlocklist('facebook.com');
// echo "Add to blocklist: " . print_r($result, true);