<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <title>Premiers tests du CSS</title>
</head>

<body>
    <header>
        <h1>C o m p a g n i e A t l a n t i k</h1>
    </header>
    <main>
        <!--partie gauche de l'annexe-->
        <div class="gauche">
            <ul>
                <?php
                $bdd = mysqli_connect('172.28.100.3', 'mviougea', 'elini01', 'mviougea_atlantik');
                if (!$bdd) {
                    die("error");
                } else {
                    //echo "connexion réussie";
                }
                //affichage de tout les secteurs
                $txtSec = "SELECT numeroSecteur,libelleSecteur FROM secteur ORDER BY libelleSecteur ASC";
                $reqSec = mysqli_query($bdd, $txtSec);

                while ($donnees = mysqli_fetch_array($reqSec)) {

                ?>
                    //secteur clicable
                    <li><a href="main3.php?secteur=<?= $donnees["numeroSecteur"] ?>"><?= $donnees['libelleSecteur']; ?></li></a>
                <?php
                }
                ?>
            </ul>
        </div>
        <!--partie droite de l'annexe-->
        <div class="droite">
            Sélectionner la liaison, et la date souhaitée<br>
            <!--formulaire de la traversée-->
            <form action='main32.php' method='GET'>
                <select name="libelleLiaison" id="libelleLiaison-select">
                    <?php
                    $numeroSec = $_GET['secteur'];

                    $txtSelect = "SELECT CodeLiaison, libelleLiaison FROM liaison WHERE numerosecteur='" . $numeroSec . "'";
                    $reqSelect = mysqli_query($bdd, $txtSelect);

                    while ($donnees = mysqli_fetch_array($reqSelect)) {

                    ?>
                        <option value="<?= $donnees["libelleLiaison"] ?>"><?php echo $donnees['libelleLiaison']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <select name="dateTraversée" id="dateTraversée-select">
                    <?php
                    $txtDate = "SELECT DISTINCT dateTraversée FROM traversée";
                    $reqDate = mysqli_query($bdd, $txtDate);

                    while ($donnees = mysqli_fetch_array($reqDate)) {

                    ?>
                        <option value="<?= $donnees["dateTraversée"] ?>"><?php echo $donnees['dateTraversée']; ?></option>
                    <?php
                    }
                    ?>
                </select>

                <input type="submit" value="Afficher les traversées"><br>
            </form>
            <br>
            <?php
            //les informations récupérées
            if (isset($_GET['libelleLiaison']) && isset($_GET['dateTraversée'])) {
                echo $_GET['libelleLiaison'] . "<br>";
                echo "Traversées pour le " . $_GET['dateTraversée'] . ". Sélectionner la traversée souhaitée";
            }
            ?>
        </div>
    </main>
</body>

</html>
