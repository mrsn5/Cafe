<?php
    define("PATH", get_template_directory_uri());

get_header();
?>

<?php
if (have_posts()) :
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
endif;
?>


<?php
get_footer();