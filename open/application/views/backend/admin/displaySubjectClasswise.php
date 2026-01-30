<div style="background-color: #f9f9f9; padding: 15px; border-radius: 4px; border-left: 4px solid #17a2b8;">
    <?php 
    if(isset($class_id) && !empty($class_id)) {
        // Get subjects linked to this class from class_subjects table
        $linked_subjects = $this->db->select('s.subject_id, s.name, cs.teacher_id')
                                     ->from('class_subjects cs')
                                     ->join('subject s', 's.subject_id = cs.subject_id')
                                     ->where('cs.class_id', $class_id)
                                     ->get()
                                     ->result_array();
        
        // Get all subjects (unfiltered by class)
        $all_subjects = $this->db->get('subject')->result_array();
        
        // Get linked subject IDs
        $linked_ids = array_map(function($s) { return $s['subject_id']; }, $linked_subjects);
        
        // Get unlinked subjects
        $unlinked_subjects = array_filter($all_subjects, function($s) use ($linked_ids) {
            return !in_array($s['subject_id'], $linked_ids);
        });
        
        $class_name = $this->crud_model->get_type_name_by_id('class', $class_id);
        
        // Display linked subjects
        if(!empty($linked_subjects)) {
            echo '<h5 style="margin-top: 0;"><i class="fa fa-check-circle" style="color: #28a745;"></i> Linked Subjects in ' . $class_name . '</h5>';
            echo '<div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;">';
            
            foreach($linked_subjects as $subject) {
                $teacher_name = $this->crud_model->get_type_name_by_id('teacher', $subject['teacher_id']);
                echo '<div style="background-color: white; border: 1px solid #28a745; padding: 12px 16px; border-radius: 20px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">';
                echo '<i class="fa fa-check" style="color: #28a745;"></i>';
                echo '<div>';
                echo '<strong>' . $subject['name'] . '</strong>';
                echo '<br><span style="font-size: 12px; color: #666;">Teacher: ' . $teacher_name . '</span>';
                echo '</div>';
                echo '<button type="button" onclick="unlink_subject(' . $subject['subject_id'] . ')" class="btn btn-xs btn-danger" style="margin-left: 8px;" title="Unlink subject">';
                echo '<i class="fa fa-trash"></i>';
                echo '</button>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<p style="color: #999; font-style: italic;">No subjects linked to this class yet.</p>';
        }
        
        // Display unlinked subjects
        if(!empty($unlinked_subjects)) {
            echo '<hr style="margin: 20px 0;">';
            echo '<h5><i class="fa fa-plus-circle" style="color: #ffc107;"></i> Available Subjects to Link</h5>';
            echo '<div style="display: flex; flex-wrap: wrap; gap: 8px;">';
            
            foreach($unlinked_subjects as $subject) {
                echo '<div style="background-color: white; border: 1px solid #ffc107; padding: 12px 16px; border-radius: 20px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">';
                echo '<i class="fa fa-plus" style="color: #ffc107;"></i>';
                echo '<strong>' . $subject['name'] . '</strong>';
                echo '<button type="button" class="link-subject-btn btn btn-xs btn-success" data-subject-id="' . $subject['subject_id'] . '" data-class-id="' . $class_id . '" style="margin-left: 8px;" title="Link subject">';
                echo '<i class="fa fa-link"></i> Link';
                echo '</button>';
                echo '</div>';
            }
            
            echo '</div>';
        }
    } else {
        echo '<p style="color: #999; font-style: italic;">Select a class to view its linked subjects</p>';
    }
    ?>
</div>
        }
    } else {
        echo '<p style="color: #999; font-style: italic;">Select a class to view its linked subjects</p>';
    }
    ?>
</div>