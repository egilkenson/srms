<?php
/**
 * This is the template that displays the footer
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#footer-php
 *
 * @package srms
 */
?>

</section> <!-- end #main-content -->

<footer id="main-footer">
    <div id="footer-panels">
        <div id="footer-events" class="footer-panel">
            <?php dynamic_sidebar('footer-widget-area'); ?>
            <p>See all events on the <a href="/calendar">Calendar page</a><br>
                Subscribe to our calendar in <a href="https://www.google.com/calendar/embed?src=admin%40srmontessori.org&ctz=America/New_York">Google Calendar</a></p>
        </div><div id="footer-logo" class="footer-panel">
            <img src="<?php echo get_theme_mod('srms_logo');?>" />
        </div><div id="footer-contact-info" class="footer-panel">
            <h3><?php bloginfo('name'); ?></h3>
            <p><?php bloginfo('description'); ?></p>
            <address>
                <?php echo get_theme_mod('srms_address');?>
            </address>
            <p class="social-links"><a target="_blank" href="https://www.facebook.com/<?php echo get_theme_mod('srms_facebook');?>/"><i class="fa fa-facebook-official"></i></a>
                <a target="_blank" href="https://www.google.com/maps/dir/<?php echo urlencode(get_theme_mod('srms_address'));?>"><i class="fa fa-map-marker"></i></a></p>
            <p><a class="phone-link" href="tel:<?php echo get_theme_mod('srms_phone');?>"><?php echo get_theme_mod('srms_phone');?></a></p>
            <a class="button" href="/contact-us">Contact Us</a>
            
        </div>
    </div>
    <div id="footer-banner">
        <p>&copy;<?php echo date('Y'); ?> <?php bloginfo('name'); ?> - All Rights Reserved</p>
    </div>
</footer>


</div>

<?php wp_footer(); ?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-60843788-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
