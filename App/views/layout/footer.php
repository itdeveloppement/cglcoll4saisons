<?php
/*
Template de page : pied de page
*/
?>
            <footer class = "footer flex">

                <?php
                if (isset($langs) && is_object($langs)) {
                    if ($langs->trans("text-footer")!= null) {
                        echo '<h3>' . html_entity_decode(htmlspecialchars($langs->trans("text-footer"), ENT_QUOTES, 'UTF-8')) . '</h3>';
                    } else {
                        echo '';
                    }
                }
                ?>
                <div class = "flex container-texte">  
                    <p>
                        <?php
                        $telephone = "(+33) - 09 80 36 37 84";
                        echo '<a href="tel:' . $telephone . '">' . $telephone . '</a>';
                        ?>
                    </p>      
                    <?php
                        $email = "contact@cigaleaventure.com";
                        echo '<a href="mailto:' . $email . '">' . $email . '</a>';
                        ?>
                    </p>
                    <p>
                        <?php
                        $url = "https://www.cigaleaventure.com";
                        echo '<a href="' . $url . '" target="_blank">Visiter le site</a>';
                        ?>
                    </p>
                    <p>Cigale Aventure, 3 rue de l'horloge 30120 Le Vigan </p>
                </div>
            </footer>
        <!-- div container -->
        </div> 
    </body>
</html>

