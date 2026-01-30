<style>
    /* Professional Parent Management Styling */
    .parent-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .parent-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .parent-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .parent-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .parent-form-header .toggle-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .parent-form-header .toggle-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .parent-form-body {
        padding: 30px;
    }
    
    .parent-form-group {
        margin-bottom: 20px;
    }
    
    .parent-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .parent-form-input {
        input, textarea, select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d9dfe4;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: Poppins, sans-serif;
            
            &:focus {
                border-color: #03a9f3;
                box-shadow: 0 0 0 3px rgba(3, 169, 243, 0.1);
                outline: none;
            }
            
            &::placeholder {
                color: #a8adb5;
            }
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
    }
    
    .parent-form-button {
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            
            &:hover {
                box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
                transform: translateY(-1px);
            }
            
            &:active {
                transform: translateY(0);
            }
        }
    }
    
    .parent-list-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
    }
    
    .parent-list-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .parent-list-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .parent-list-body {
        padding: 20px;
        overflow-x: auto;
    }
    
    .parent-table {
        width: 100%;
        border-collapse: collapse;
        
        thead {
            tr {
                background: #f0f4f8;
                border-bottom: 2px solid #e4e7ea;
                
                th {
                    padding: 14px;
                    text-align: left;
                    font-weight: 600;
                    color: #2b2b2b;
                    font-size: 12px;
                    letter-spacing: 0.4px;
                    text-transform: uppercase;
                }
            }
        }
        
        tbody {
            tr {
                border-bottom: 1px solid #e4e7ea;
                transition: all 0.2s ease;
                
                &:hover {
                    background: #f8f9fb;
                }
                
                td {
                    padding: 14px;
                    font-size: 13px;
                    color: #686868;
                }
            }
        }
    }
    
    .parent-action-btn {
        display: inline-flex;
        gap: 6px;
        
        .btn-edit, .btn-delete {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            
            i {
                font-size: 13px;
            }
        }
        
        .btn-edit {
            background: #03a9f3;
            color: white;
            
            &:hover {
                background: #0288d1;
                box-shadow: 0 2px 8px rgba(3, 169, 243, 0.3);
            }
        }
        
        .btn-delete {
            background: #f44236;
            color: white;
            
            &:hover {
                background: #e53935;
                box-shadow: 0 2px 8px rgba(244, 66, 54, 0.3);
            }
        }
    }
    
    .parent-empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a8adb5;
        
        i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        p {
            font-size: 14px;
            margin: 0;
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .parent-form-body {
            padding: 20px;
        }
        
        .parent-list-body {
            padding: 15px;
        }
        
        .parent-table {
            thead tr th,
            tbody tr td {
                padding: 10px;
                font-size: 12px;
            }
        }
    }
</style>

<div class="parent-page-container">
    <!-- ADD NEW PARENT FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="parent-form-card">
                <div class="parent-form-header">
                    <h4><i class="fa fa-plus" style="margin-right: 10px;"></i>Add New Parent</h4>
                    <button type="button" class="toggle-btn" data-toggle="collapse" data-target="#parentFormBody">
                        <i class="fa fa-chevron-down"></i> Expand
                    </button>
                </div>
                <div class="parent-form-body collapse" id="parentFormBody">
                    <?php echo form_open(base_url().'admin/parent/insert', array('class' => 'form-horizontal', 'enctype'=>'multipart/form-data'));?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="parent-form-group parent-form-label">
                                <label><?php echo get_phrase('Name');?> <span style="color: #f44236;">*</span></label>
                                <div class="parent-form-input">
                                    <input type="text" name="name" class="form-control" placeholder="Parent's full name" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="parent-form-group parent-form-label">
                                <label><?php echo get_phrase('Email');?> <span style="color: #f44236;">*</span></label>
                                <div class="parent-form-input">
                                    <input type="email" name="email" class="form-control" placeholder="parent@example.com" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="parent-form-group parent-form-label">
                                <label><?php echo get_phrase('Phone');?> <span style="color: #f44236;">*</span></label>
                                <div class="parent-form-input">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone number" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="parent-form-group parent-form-label">
                                <label><?php echo get_phrase('Profession');?></label>
                                <div class="parent-form-input">
                                    <input type="text" name="profession" class="form-control" placeholder="Profession or occupation">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="parent-form-group parent-form-label">
                                <label><?php echo get_phrase('Address');?></label>
                                <div class="parent-form-input">
                                    <textarea class="form-control" name="address" placeholder="Home address"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="parent-form-group parent-form-label">
                                <label><?php echo get_phrase('Password');?> <span style="color: #f44236;">*</span></label>
                                <div class="parent-form-input">
                                    <input type="password" name="password" class="form-control" placeholder="Secure password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="parent-form-button">
                        <button type="submit"><i class="fa fa-check"></i>&nbsp; Save Parent</button>
                    </div>
                    
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>

    <!-- PARENTS LIST TABLE -->
    <div class="row">
        <div class="col-sm-12">
            <div class="parent-list-card">
                <div class="parent-list-header">
                    <i class="fa fa-users"></i>
                    <h4><?php echo get_phrase('Parents List');?></h4>
                </div>
                <div class="parent-list-body">
                    <?php if(!empty($select_parent)): ?>
                        <table class="parent-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%"><?php echo get_phrase('name');?></th>
                                    <th width="25%"><?php echo get_phrase('email');?></th>
                                    <th width="15%"><?php echo get_phrase('phone');?></th>
                                    <th width="20%"><?php echo get_phrase('profession');?></th>
                                    <th width="15%"><?php echo get_phrase('options');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 1;
                                foreach ($select_parent as $key => $parent):
                                ?>
                                <tr>
                                    <td><?php echo $count++;?></td>
                                    <td><strong><?php echo $parent['name'];?></strong></td>
                                    <td><?php echo $parent['email'];?></td>
                                    <td><?php echo $parent['phone'];?></td>
                                    <td><?php echo $parent['profession'];?></td>
                                    <td>
                                        <div class="parent-action-btn">
                                            <button class="btn-edit" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_parent/<?php echo $parent['parent_id'];?>')">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn-delete" onclick="return confirm('Are you sure you want to delete this parent?') ? window.location.href='<?php echo base_url();?>admin/parent/delete/<?php echo $parent['parent_id'];?>' : false;">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="parent-empty-state">
                            <i class="fa fa-inbox"></i>
                            <p>No parents found. Start by adding a new parent using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-collapse form on page load
    document.addEventListener('DOMContentLoaded', function() {
        const formBody = document.getElementById('parentFormBody');
        const toggleBtn = document.querySelector('.toggle-btn');
        
        // Initially collapse the form
        formBody.classList.remove('in');
        if(toggleBtn) {
            toggleBtn.innerHTML = '<i class="fa fa-chevron-right"></i> Expand';
        }
        
        // Toggle button text on collapse/expand
        formBody.addEventListener('show.bs.collapse', function() {
            if(toggleBtn) {
                toggleBtn.innerHTML = '<i class="fa fa-chevron-down"></i> Collapse';
            }
        });
        
        formBody.addEventListener('hide.bs.collapse', function() {
            if(toggleBtn) {
                toggleBtn.innerHTML = '<i class="fa fa-chevron-right"></i> Expand';
            }
        });
    });
</script>