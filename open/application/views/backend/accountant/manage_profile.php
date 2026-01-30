<?php
/**
 * Manage Profile
 */
?>

<!-- Row -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="white-box">
            <h3 class="box-title m-b-30"><i class="fa fa-user m-r-10"></i><?php echo get_phrase('My Profile'); ?></h3>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"><?php echo get_phrase('Name'); ?></label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($accountant['name']) ? $accountant['name'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email"><?php echo get_phrase('Email'); ?></label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($accountant['email']) ? $accountant['email'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone"><?php echo get_phrase('Phone'); ?></label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo isset($accountant['phone']) ? $accountant['phone'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="userfile"><?php echo get_phrase('Profile Picture'); ?></label>
                    <input type="file" id="userfile" name="userfile" class="form-control" accept="image/jpeg,image/png,image/gif" onChange="readURL(this);">
                    <img id="blah" src="<?php echo $this->crud_model->get_image_url('accountant', $accountant['accountant_id']); ?>?t=<?php echo time(); ?>" alt="Accountant Profile Picture" height="150" width="150" style="margin-top: 10px; border: 1px solid #ddd; padding: 5px;"/>
                </div>

                <hr>
                <h4 class="m-b-20"><?php echo get_phrase('Change Password (Optional)'); ?></h4>

                <div class="form-group">
                    <label for="password"><?php echo get_phrase('New Password'); ?></label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                </div>

                <div class="form-group">
                    <label for="confirm_password"><?php echo get_phrase('Confirm Password'); ?></label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm your password">
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-save m-r-5"></i> <?php echo get_phrase('Update Profile'); ?>
                </button>
            </form>
        </div>
    </div>
</div>
