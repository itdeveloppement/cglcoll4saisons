<?php
/*
Template de page : pied de page
*/
?>
            <footer class = "footer flex">

                <?php
                // if (isset($langs) && is_object($langs)) {
                //     if ($langs->trans("text-footer")!= null) {
                //         echo '<h3>' . html_entity_decode(htmlspecialchars($langs->trans("text-footer"), ENT_QUOTES, 'UTF-8')) . '</h3>';
                //     } else {
                //         echo '';
                //     }
                // }
                ?>
                <div class = "flex container-texte">
                        <p class = "footer-p">
                            <?php
                            $telephone = "+330980363784";
                            echo '<a href="tel:' . $telephone . '">(+33) 09 80 36 37 84</a>';
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
                            echo '<a href="' . $url . '" target="_blank">Web site</a>';
                            ?>
                        </p>
                        <p class = "footer-p"><a href="https://www.google.com/maps?q=Cigale+Aventure,+3+rue+de+l'horloge+30120+Le+Vigan" target="_blank">Maps</a></p>
                </div>
            </footer>
        <!-- div container -->
        </div> 
    </body>
</html>

