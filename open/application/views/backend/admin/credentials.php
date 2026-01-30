<?php
// Credentials Page - Tabbed view for all user credentials
// Tabs: Students, Parents, Teachers, Others
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-key"></i>&nbsp;&nbsp;User Credentials
            </div>
            <div class="panel-body">
                <p><strong>View Login Credentials:</strong> Select a tab below to view credentials for students, parents, teachers, or other users.</p>
                
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#admins" aria-controls="admins" role="tab" data-toggle="tab">
                            <i class="fa fa-user-secret"></i>&nbsp;Admins
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#students" aria-controls="students" role="tab" data-toggle="tab">
                            <i class="fa fa-graduation-cap"></i>&nbsp;Students
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#parents" aria-controls="parents" role="tab" data-toggle="tab">
                            <i class="fa fa-users"></i>&nbsp;Parents
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#teachers" aria-controls="teachers" role="tab" data-toggle="tab">
                            <i class="fa fa-chalkboard-user"></i>&nbsp;Teachers
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#accountants" aria-controls="accountants" role="tab" data-toggle="tab">
                            <i class="fa fa-calculator"></i>&nbsp;Accountants
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#others" aria-controls="others" role="tab" data-toggle="tab">
                            <i class="fa fa-user"></i>&nbsp;Others
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="padding-top: 20px;">
                    
                    <!-- ADMINS TAB -->
                    <div role="tabpanel" class="tab-pane active" id="admins">
                        <h4>Admin Credentials</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email/Username</th>
                                        <th>Password</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($admins) && !empty($admins)):
                                        foreach($admins as $admin):
                                    ?>
                                        <tr>
                                            <td><?php echo $admin['admin_id']; ?></td>
                                            <td><?php echo $admin['name']; ?></td>
                                            <td><?php echo $admin['email']; ?></td>
                                            <td>
                                                <code style="font-size: 12px; background-color: #e8f5e9; padding: 5px; border-radius: 3px; font-weight: bold;">
                                                    <?php echo isset($admin['plaintext_password']) && !empty($admin['plaintext_password']) ? $admin['plaintext_password'] : '<em>Not set</em>'; ?>
                                                </code>
                                            </td>
                                            <td>
                                                <?php 
                                                if(!empty($admin['login_status']) && $admin['login_status'] != '') {
                                                    echo '<span class="label label-success">Active</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No admins found</td>
                                        </tr>
                                    <?php 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- STUDENTS TAB -->
                    <div role="tabpanel" class="tab-pane" id="students">
                        <h4>Student Credentials</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email/Username</th>
                                        <th>Password</th>
                                        <th>Class</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($students) && !empty($students)):
                                        foreach($students as $student):
                                    ?>
                                        <tr>
                                            <td><?php echo $student['student_id']; ?></td>
                                            <td><?php echo $student['name']; ?></td>
                                            <td><?php echo $student['email']; ?></td>
                                            <td>
                                                <code style="font-size: 12px; background-color: #e8f5e9; padding: 5px; border-radius: 3px; font-weight: bold;">
                                                    <?php echo isset($student['plaintext_password']) && !empty($student['plaintext_password']) ? $student['plaintext_password'] : '<em>Not set</em>'; ?>
                                                </code>
                                            </td>
                                            <td><?php echo isset($student['class_name']) ? $student['class_name'] : 'N/A'; ?></td>
                                            <td>
                                                <?php 
                                                if(!empty($student['login_status']) && $student['login_status'] != '') {
                                                    echo '<span class="label label-success">Active</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No students found</td>
                                        </tr>
                                    <?php 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- PARENTS TAB -->
                    <div role="tabpanel" class="tab-pane" id="parents">
                        <h4>Parent Credentials</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email/Username</th>
                                        <th>Password</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($parents) && !empty($parents)):
                                        foreach($parents as $parent):
                                    ?>
                                        <tr>
                                            <td><?php echo $parent['parent_id']; ?></td>
                                            <td><?php echo $parent['name']; ?></td>
                                            <td><?php echo $parent['email']; ?></td>
                                            <td>
                                                <code style="font-size: 12px; background-color: #e8f5e9; padding: 5px; border-radius: 3px; font-weight: bold;">
                                                    <?php echo isset($parent['plaintext_password']) && !empty($parent['plaintext_password']) ? $parent['plaintext_password'] : '<em>Not set</em>'; ?>
                                                </code>
                                            </td>
                                            <td>
                                                <?php 
                                                if(!empty($parent['login_status']) && $parent['login_status'] != '') {
                                                    echo '<span class="label label-success">Active</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No parents found</td>
                                        </tr>
                                    <?php 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TEACHERS TAB -->
                    <div role="tabpanel" class="tab-pane" id="teachers">
                        <h4>Teacher Credentials</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email/Username</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($teachers) && !empty($teachers)):
                                        foreach($teachers as $teacher):
                                    ?>
                                        <tr>
                                            <td><?php echo $teacher['teacher_id']; ?></td>
                                            <td><?php echo $teacher['name']; ?></td>
                                            <td><?php echo $teacher['email']; ?></td>
                                            <td>
                                                <code style="font-size: 12px; background-color: #e8f5e9; padding: 5px; border-radius: 3px; font-weight: bold;">
                                                    <?php echo isset($teacher['plaintext_password']) && !empty($teacher['plaintext_password']) ? $teacher['plaintext_password'] : '<em>Not set</em>'; ?>
                                                </code>
                                            </td>
                                            <td>
                                                <?php 
                                                if($teacher['role'] == 1) {
                                                    echo '<span class="label label-primary">Class Teacher</span>';
                                                } elseif($teacher['role'] == 2) {
                                                    echo '<span class="label label-info">Subject Teacher</span>';
                                                } else {
                                                    echo '<span class="label label-default">Unknown</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if($teacher['status'] == 1) {
                                                    echo '<span class="label label-success">Active</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No teachers found</td>
                                        </tr>
                                    <?php 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ACCOUNTANTS TAB -->
                    <div role="tabpanel" class="tab-pane" id="accountants">
                        <h4>Accountant Credentials</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email/Username</th>
                                        <th>Password</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($accountants) && !empty($accountants)):
                                        foreach($accountants as $accountant):
                                    ?>
                                        <tr>
                                            <td><?php echo isset($accountant['accountant_id']) ? $accountant['accountant_id'] : 'N/A'; ?></td>
                                            <td><?php echo isset($accountant['name']) ? $accountant['name'] : 'N/A'; ?></td>
                                            <td><?php echo isset($accountant['email']) ? $accountant['email'] : 'N/A'; ?></td>
                                            <td>
                                                <code style="font-size: 12px; background-color: #e8f5e9; padding: 5px; border-radius: 3px; font-weight: bold;">
                                                    <?php echo isset($accountant['plaintext_password']) && !empty($accountant['plaintext_password']) ? $accountant['plaintext_password'] : '<em>Not set</em>'; ?>
                                                </code>
                                            </td>
                                            <td>
                                                <?php 
                                                if(!empty($accountant['login_status']) && $accountant['login_status'] != '') {
                                                    echo '<span class="label label-success">Active</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No accountants found</td>
                                        </tr>
                                    <?php 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- OTHERS TAB -->
                    <div role="tabpanel" class="tab-pane" id="others">
                        <h4>Other Users</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email/Username</th>
                                        <th>Password</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($others) && !empty($others)):
                                        foreach($others as $user):
                                    ?>
                                        <tr>
                                            <td><?php echo isset($user['id']) ? $user['id'] : 'N/A'; ?></td>
                                            <td><?php echo isset($user['name']) ? $user['name'] : 'N/A'; ?></td>
                                            <td><?php echo isset($user['email']) ? $user['email'] : 'N/A'; ?></td>
                                            <td>
                                                <code style="font-size: 11px;"><?php echo isset($user['password']) ? substr($user['password'], 0, 10) . '...' : 'N/A'; ?></code>
                                            </td>
                                            <td><?php echo isset($user['user_type']) ? $user['user_type'] : 'N/A'; ?></td>
                                            <td>
                                                <?php 
                                                if(isset($user['is_active']) && $user['is_active'] == 1) {
                                                    echo '<span class="label label-success">Active</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No other users found</td>
                                        </tr>
                                    <?php 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    code {
        background-color: #f5f5f5;
        padding: 2px 4px;
        border-radius: 3px;
    }
    .table-responsive {
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>
