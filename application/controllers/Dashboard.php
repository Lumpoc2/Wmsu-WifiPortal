<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function index()
    {
        try {
            // Retrieve session data
            $ip = $this->session->userdata('ip');
            $user = $this->session->userdata('user');
            $password = $this->session->userdata('password');

            // Connect to MikroTik RouterOS API
            $API = new Mikweb();
            $API->connect($ip, $user, $password);

            // Fetch data from MikroTik
            $hotspotuser = $API->comm("/ip/hotspot/user/print");
            $hotspotactive = $API->comm("/ip/hotspot/active/print");
            $resource = $API->comm("/system/resource/print");
            $interface = $API->comm("/interface/print");

            // Extract CPU load and uptime from system resource
            $cpu = $resource[0]['cpu-load'];
            $uptime = $resource[0]['uptime'];
            
            // Initialize variables to hold total traffic
            $totalBytesOut = 0;
            $weeklyTraffic = 0;
            $monthlyTraffic = 0;

            // Current date and the timestamp for one week and one month ago
            $currentDate = new DateTime();
            $oneWeekAgo = $currentDate->modify('-7 days')->format('Y-m-d H:i:s');
            $oneMonthAgo = $currentDate->modify('-1 month')->format('Y-m-d H:i:s');

            // Prepare an array to hold the user traffic data
            $userTrafficData = [];

            // Loop through each user to extract and calculate the total traffic
            foreach ($hotspotuser as $user) {
                // Add bytes-out to the total sum
                $totalBytesOut += $user['bytes-out'];

                // Assuming the user data has a 'timestamp' field, replace with actual field if needed
                $userTimestamp = strtotime($user['timestamp']); // Replace with the correct timestamp field

                if ($userTimestamp >= strtotime($oneWeekAgo)) {
                    $weeklyTraffic += $user['bytes-out'];
                }

                if ($userTimestamp >= strtotime($oneMonthAgo)) {
                    $monthlyTraffic += $user['bytes-out'];
                }

                // Calculate total traffic for this user (bytes-in + bytes-out)
                $totalTraffic = $user['bytes-in'] + $user['bytes-out'];

                // Store the data for the user
                $userTrafficData[] = [
                    'bytes-in' => $user['bytes-in'],   // Bytes in (download)
                    'bytes-out' => $user['bytes-out'], // Bytes out (upload)
                    'total-traffic' => $totalTraffic,  // Total traffic (download + upload)
                ];
            }

            // Prepare the data for the view
            $data = [
                'totalhotspotuser' => count($hotspotuser),
                'hotspotactive' => count($hotspotactive),
                'hotspotuser' => $hotspotuser,
                'cpu' => $cpu,
                'uptime' => $uptime,
                'interface' => $interface,
                'totalBytesOut' => $totalBytesOut,  // Include the total bytes-out in the data
                'userTrafficData' => $userTrafficData, // Include the user traffic data
                'weeklyTraffic' => $weeklyTraffic,  // Include weekly traffic
                'monthlyTraffic' => $monthlyTraffic // Include monthly traffic
            ];

            // Load views and pass data
            $this->load->view('template/main');
            $this->load->view('dashboard', $data);

        } catch (Exception $err) {
            // In case of an error, load the index view
            $this->load->view('index.html');
        }
    }

    public function traffic(){
        $post = $this->input->post(null, true);
        $ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');
        $API = new Mikweb();
        $API->connect($ip, $user, $password);
        
        // Fetch interface traffic data
        $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array(
            'interface' => 'ether5-isp',
            'once' => '',
        ));

        $rx = $getinterfacetraffic[0]['rx-bits-per-second'];
        $tx = $getinterfacetraffic[0]['tx-bits-per-second'];

        // Prepare data for the view
        $data = [
            'tx' => $tx,
            'rx' => $rx,
        ];

        // Load the traffic view
        $this->load->view('traffic', $data);
    }
}