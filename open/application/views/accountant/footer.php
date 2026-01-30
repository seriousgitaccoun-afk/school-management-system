<?php
/**
 * Accountant Footer View
 */
?>
        </div><!-- /.main-content -->
    </div><!-- /.page-wrapper -->

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-4 border-top">
        <p class="text-muted mb-0">
            &copy; <?php echo date('Y'); ?> <?php echo get_school_name(); ?>. All rights reserved.
        </p>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo base_url(); ?>optimum/bootstrap/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>optimum/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/css/all.min.js"></script>
    <script src="<?php echo base_url(); ?>optimum/js/canvasjs.min.js"></script>
    
    <!-- Custom Script -->
    <script>
        // Initialize tooltips and popovers
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        });
    </script>
</body>
</html>
