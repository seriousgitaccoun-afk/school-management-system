<?php
/**
 * Accountants List
 */
?>

<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-20"><i class="fa fa-users m-r-10"></i><?php echo get_phrase('Accountants'); ?></h3>
            <div class="table-responsive">
                <?php if (isset($accountants) && !empty($accountants)): ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('Name'); ?></th>
                            <th><?php echo get_phrase('Email'); ?></th>
                            <th><?php echo get_phrase('Phone'); ?></th>
                            <th><?php echo get_phrase('Status'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accountants as $accountant): ?>
                        <tr>
                            <td><?php echo $accountant['name']; ?></td>
                            <td><?php echo $accountant['email']; ?></td>
                            <td><?php echo $accountant['phone']; ?></td>
                            <td>
                                <?php if ($accountant['login_status'] == 1): ?>
                                    <span class="label label-success"><?php echo get_phrase('Online'); ?></span>
                                <?php else: ?>
                                    <span class="label label-default"><?php echo get_phrase('Offline'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center text-muted"><?php echo get_phrase('No accountants found'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

