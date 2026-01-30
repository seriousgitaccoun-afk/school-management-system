<footer class="footer text-center">
    <i class="fa fa-globe"></i>
    <?php 
        $school_info = get_school_contact();
        echo '<strong>' . get_school_name() . '</strong> | ';
        echo $school_info['phone'];
        if (!empty($school_info['email'])) {
            echo ' | ' . $school_info['email'];
        }
    ?>
</footer>
			
			
	