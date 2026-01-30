<?php
/**
 * School Header Component
 * 
 * This file displays the school header with all customized information
 * Can be included in reports, invoices, certificates, etc.
 * 
 * Usage: <?php $this->load->view('backend/school_header'); ?>
 */

$school_info = get_school_info();
$contact_info = get_school_contact();
?>

<div class="school-header text-center" style="padding: 20px; border-bottom: 2px solid #333; margin-bottom: 20px;">
    
    <!-- School Logo -->
    <div style="margin-bottom: 10px;">
        <img src="<?php echo get_school_logo(); ?>" alt="School Logo" style="max-height: 80px; max-width: 150px;">
    </div>
    
    <!-- School Name -->
    <h2 style="margin: 10px 0; font-weight: bold;">
        <?php echo $school_info['name']; ?>
    </h2>
    
    <!-- School Motto -->
    <?php if (!empty($school_info['motto'])): ?>
        <h5 style="margin: 5px 0; color: #666; font-style: italic;">
            "<?php echo $school_info['motto']; ?>"
        </h5>
    <?php endif; ?>
    
    <!-- School Details -->
    <div style="margin-top: 15px; font-size: 13px; color: #555;">
        <?php if (!empty($school_info['board_affiliation'])): ?>
            <div><?php echo get_phrase('Board') . ': ' . $school_info['board_affiliation']; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($school_info['accreditation_no'])): ?>
            <div><?php echo get_phrase('Accreditation No') . ': ' . $school_info['accreditation_no']; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($school_info['registration_no'])): ?>
            <div><?php echo get_phrase('Registration No') . ': ' . $school_info['registration_no']; ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Contact Information -->
    <div style="margin-top: 10px; font-size: 12px; color: #777;">
        <div><?php echo $contact_info['address']; ?></div>
        <div><?php echo get_phrase('Phone') . ': ' . $contact_info['phone']; ?></div>
        <?php if ($contact_info['email'] !== 'N/A'): ?>
            <div><?php echo get_phrase('Email') . ': ' . $contact_info['email']; ?></div>
        <?php endif; ?>
        <?php if ($school_info['website'] !== 'https://yourschool.com'): ?>
            <div><?php echo $school_info['website']; ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Principal Information -->
    <?php if (!empty($school_info['principal_name'])): ?>
        <div style="margin-top: 15px; font-size: 12px;">
            <strong><?php echo $school_info['principal_title']; ?>:</strong> <?php echo $school_info['principal_name']; ?>
        </div>
    <?php endif; ?>
    
</div>
