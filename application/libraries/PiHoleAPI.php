<?php
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

    public function addToBlocklist($input) {
        if ($this->isRegex($input)) {
            return $this->addToRegexBlocklist($input);
        } else {
            return $this->addDomainToBlocklist($input);
        }
    }

    public function removeFromBlocklist($input) {
        if ($this->isRegex($input)) {
            return $this->removeFromRegexBlocklist($input);
        } else {
            return $this->removeDomainFromBlocklist($input);
        }
    }

    private function addDomainToBlocklist($domain) {
        $url = $this->apiUrl . "?list=black&add=" . urlencode($domain) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    private function removeDomainFromBlocklist($domain) {
        $url = $this->apiUrl . "?list=black&sub=" . urlencode($domain) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    private function addToRegexBlocklist($regex) {
        $url = $this->apiUrl . "?list=regex_black&add=" . urlencode($regex) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    private function removeFromRegexBlocklist($regex) {
        $url = $this->apiUrl . "?list=regex_black&sub=" . urlencode($regex) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    private function sendRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    private function isRegex($input) {
        // Check for common regex characters
        return preg_match('/[.*?^$|\\[\\](){}]/', $input) === 1;
    }
    public function getBlocklist() {
    $url = $this->apiUrl . "?list=black&auth=" . $this->apiToken;
    return $this->sendRequest($url);
}



}