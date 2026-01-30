<?php
// This file should be placed in open/application/controllers/ or accessible via browser
// Access it like: http://localhost/free_and_open_source/open/index.php/setup/init_fee_types

class Setup extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function init_fee_types() {
        // Check if already initialized
        $result = $this->db->query('SELECT COUNT(*) as count FROM fee_type WHERE is_active = 1');
        $existing = $result->row()->count;
        
        if ($existing > 0) {
            echo "<h3>✓ Fee types already initialized (" . $existing . " active)</h3>";
            echo "<a href='javascript:history.back()'>Go Back</a>";
            return;
        }
        
        // Default fee types
        $fee_types = array(
            array('name' => 'Tuition Fee', 'category' => 'tuition', 'description' => 'Monthly tuition fee'),
            array('name' => 'Daily Fee', 'category' => 'daily', 'description' => 'Daily school fee'),
            array('name' => 'Examination Fee', 'category' => 'tuition', 'description' => 'Examination and assessment fee'),
            array('name' => 'Library Fee', 'category' => 'tuition', 'description' => 'Library and learning materials fee'),
            array('name' => 'Sports Fee', 'category' => 'tuition', 'description' => 'Sports and physical education fee'),
            array('name' => 'Transportation Fee', 'category' => 'tuition', 'description' => 'Transportation fee'),
        );
        
        echo "<h3>Initializing Fee Types...</h3>";
        echo "<ul>";
        
        foreach ($fee_types as $type) {
            $this->db->insert('fee_type', array(
                'name' => $type['name'],
                'category' => $type['category'],
                'description' => $type['description'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ));
            echo "<li>✓ Created: " . $type['name'] . " (" . $type['category'] . ")</li>";
        }
        
        echo "</ul>";
        
        // Verify
        $result = $this->db->query('SELECT COUNT(*) as count FROM fee_type WHERE is_active = 1');
        $count = $result->row()->count;
        
        echo "<h4>✓ Setup Complete! Created " . $count . " fee types.</h4>";
        echo "<a href='javascript:history.back()'>Go Back</a>";
    }
    
    /**
     * Cleanup duplicate subjects
     */
    public function cleanup_subject_duplicates() {
        echo "<h3>Subject Duplicate Cleanup</h3>";
        
        // Find duplicate subjects (case-insensitive)
        $sql = "SELECT LOWER(name) as name_lower, COUNT(*) as count, GROUP_CONCAT(subject_id) as ids
                FROM subject
                GROUP BY LOWER(name)
                HAVING count > 1
                ORDER BY count DESC";
        
        $result = $this->db->query($sql);
        $duplicates = $result->result_array();
        
        if (empty($duplicates)) {
            echo "<h4>✓ No duplicate subjects found!</h4>";
            echo "<a href='javascript:history.back()'>Go Back</a>";
            return;
        }
        
        echo "<p>Found " . count($duplicates) . " subject(s) with duplicates.</p>";
        echo "<h4>Cleaning up...</h4>";
        echo "<ul>";
        
        $total_removed = 0;
        
        foreach ($duplicates as $dup) {
            $ids = explode(',', $dup['ids']);
            
            // Keep the first one, remove the rest
            $to_remove = array_slice($ids, 1);
            
            if (!empty($to_remove)) {
                // Delete duplicates
                $this->db->where_in('subject_id', $to_remove);
                $this->db->delete('subject');
                
                $removed_count = count($to_remove);
                $total_removed += $removed_count;
                
                echo "<li>Subject '<strong>" . htmlspecialchars($dup['name_lower']) . "</strong>': Removed " . $removed_count . " duplicate(s) (kept ID: " . $ids[0] . ")</li>";
            }
        }
        
        echo "</ul>";
        echo "<h4>✓ Cleanup Complete! Removed " . $total_removed . " duplicate subject(s).</h4>";
        echo "<a href='javascript:history.back()'>Go Back</a>";
    }
    
    /**
     * List all subjects with duplicate check
     */
    public function list_subjects() {
        echo "<h3>All Subjects</h3>";
        
        $result = $this->db->query("
            SELECT subject_id, name
            FROM subject
            ORDER BY name ASC
        ");
        
        $subjects = $result->result_array();
        
        echo "<table border='1' cellpadding='10' style='width: 100%;'>";
        echo "<tr><th>ID</th><th>Name</th></tr>";
        
        foreach ($subjects as $subject) {
            echo "<tr>";
            echo "<td>" . $subject['subject_id'] . "</td>";
            echo "<td>" . htmlspecialchars($subject['name']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "<p>Total subjects: " . count($subjects) . "</p>";
        echo "<a href='javascript:history.back()'>Go Back</a>";
    }
}
?>