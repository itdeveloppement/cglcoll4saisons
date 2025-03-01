<?php
/*
Template de page : pied de page
*/
?>
            <footer class = "footer flex">
                <div class = "flex container-texte">
                        <p class = "footer-p">
                            <?php
                            $telephone = "+339 80 36 37 84";
                            echo '<a href="tel:' . $telephone . '">+33(0)9 80 36 37 84</a>';
                            ?>
                        </p>
                        <p class = "footer-p">
                            <?php
                            $email = "contact@cigaleaventure.com";
                            echo '<a href="mailto:' . $email . '">contact@cigaleaventure.com</a>';
                            ?>
                        </p>
                        <p class = "footer-p">
                            <?php
                            $url = "https://www.cigaleaventure.com";
                            echo '<a href="' . $url . '" target="_blank">www.cigaleaventure.com</a>';
                            ?>
                        </p>
                </div>
            </footer>
        <!-- div container -->
        </div>
    </body>
</html>

