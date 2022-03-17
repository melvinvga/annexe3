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
        <div class="gauche">
            <ul>
                <?php
                $bdd = mysqli_connect('172.28.100.3', 'mviougea', 'elini01', 'mviougea_atlantik');
                if (!$bdd) {
                    die("error");
                } else {
                    //echo "connexion réussie";
                }

                $txtSec = "SELECT numeroSecteur,libelleSecteur FROM secteur ORDER BY libelleSecteur ASC";
                $reqSec = mysqli_query($bdd, $txtSec);

                while ($donnees = mysqli_fetch_array($reqSec)) {

                ?>
                    <li><a href="main3.php?secteur=<?= $donnees["numeroSecteur"] ?>"><?= $donnees['libelleSecteur']; ?></li></a>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="droite">
            Sélectionner la liaison, et la date souhaitée<br>
            <form method="GET" action="">
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
            if (isset($_GET['libelleLiaison']) && isset($_GET['dateTraversée'])) {
                echo $_GET['libelleLiaison'] . "<br>";
                echo "Traversées pour le " . $_GET['dateTraversée'] . ". Sélectionner la traversée souhaitée";
            }
            ?>
            <form action='main4.php' method='POST'>
            <table>
                <tr>
                    <th colspan="3">Traversée</th>
                    <th colspan="3">Place disponible</th>
                </tr>
                <tr>
                    <td>N°</td>
                    <td>Heure</td>
                    <td>Bateau</td>
                    <td>A<br>Passager</td>
                    <td>B<br>Vehicule inf</td>
                    <td>C<br>Vehicule sup</td>
                </tr>
                <?php
                $txtInfo = "SELECT numeroTraversée,heureTraversée, bateau.numeroBateau,libelleBateau FROM traversée inner join bateau ON bateau.numeroBateau=traversée.numeroBateau WHERE traversée.CodeLiaison=15 ORDER BY numeroTraversée;";
                $reqInfo = mysqli_query($bdd, $txtInfo);

                // affichage des données 
                while ($donnees = mysqli_fetch_array($reqInfo)) {
                    $requetePlace = "SELECT nombrePlace FROM Contient WHERE numeroBateau=" . $donnees['numeroBateau'] . ";";
                    $resultatPlace = mysqli_query($bdd, $requetePlace);
                ?>
                    <tr>
                        <td><?= $donnees['numeroTraversée'] ?></td>
                        <td><?= $donnees['heureTraversée'] ?></td>
                        <td><?= $donnees['libelleBateau'] ?></td>

                        <?php
                        // affichage du nombre de places
                        while ($place = mysqli_fetch_array($resultatPlace)) {
                        ?>
                            <td><?= $place['nombrePlace'] ?></td>
                        <?php } ?>
                        <td><input type="radio" id="<?= $donnees['numeroTraversée'] ?>" name="traversee" value="<?= $donnees['numeroTraversée'] ?>"></td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <input type='submit' value="Réserver cette traversée" class="btn">
            </form>
        </div>
    </main>
</body>

</html>