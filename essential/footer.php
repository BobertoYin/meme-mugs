<footer>
            <span style="font-weight:bold">For Proprietary Use</span>
            <div class="footer-text">
                <!-- Receives and shows when the document has been updated -->
                <?php
                    date_default_timezone_set('America/Chicago');
                    echo "Last Updated " .date("h:i:s A m/d/Y",filemtime(str_replace("/","",$_SERVER['PHP_SELF'])));
                ?>
            </div>
            <div class="footer-text">Designed By Butyl Group</div>
        </footer>