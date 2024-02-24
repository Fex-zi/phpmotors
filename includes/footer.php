<!-- footer.php -->
<footer >
    <hr>
        <p>&copy; <?php echo  date("Y") ;?> PHP Motors. All time reserved.</p>        
        <p>All images used are believed to be in 'Fair use'. Please notify the author if they are not and they will be removed.</p>
    <?php
        $current_file_name = basename($_SERVER['PHP_SELF']);
        $file_last_modified = filemtime($current_file_name); 
        echo "Last updated: " . date("dS F, Y, h:ia", $file_last_modified)."\n";
    ?>
    
</footer>