<?php
class HotspotController extends CI_Controller {

    // Method to delete the active record and backup the data
    public function delActive($id)
    {
        $this->load->database();
        
        // Fetch the active record based on the ID
        $this->db->where('id', $id);
        $activeRecord = $this->db->get('tbl_active_ip')->row_array();
        
        if ($activeRecord) {
            // Check if the record already exists in the backup table
            $this->db->where('mac_address', $activeRecord['mac_address']);
            $existingBackup = $this->db->get('tbl_deleted_active_ip')->row_array();
            
            // If it doesn't exist in the backup table, insert it
            if (!$existingBackup) {
                $backupData = array(
                    'name' => $activeRecord['name'],
                    'ip_address' => $activeRecord['ip_address'],
                    'mac_address' => $activeRecord['mac_address'],
                    'uptime' => $activeRecord['uptime'],
                    'bytes_in' => $activeRecord['bytes_in'],
                    'bytes_out' => $activeRecord['bytes_out'],
                    'conn_status' => $activeRecord['conn_status'],
                    'datetime_conn' => $activeRecord['datetime_conn'],
                    'other_data' => $activeRecord['other_data'],
                    'date_created' => $activeRecord['date_created'],
                    'date_updated' => $activeRecord['date_updated'],
                    'deleted_at' => date('Y-m-d H:i:s')  // Set the deletion timestamp
                );
                $this->db->insert('tbl_deleted_active_ip', $backupData);
            }
            
            // Now delete from the active table
            $this->db->where('id', $id);
            $this->db->delete('tbl_active_ip');
        }
        
        // Redirect or return a success message
        redirect('hotspot/active_list'); // Redirect to the active list or any other page
    }
}
?>