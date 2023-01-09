<?php
include "./../Controller/query.php";

if (isset($_GET["id"])) {
    $project = getProject($conn, $_GET["id"]);
    $contacts = getContacts($conn, $_GET["id"]);
    $statuses = ["fejlesztésre vár", "folyamatban", "kész"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt adatlap</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./../Resources/css/styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/b389db4779.js" crossorigin="anonymous"></script>
    <script src="./../Resources/js/index.js"></script>
</head>

<body>

    <div class="container new-project-container">
        <?php if (isset($_GET["id"])) { ?>
            <h3>Projekt szerkesztése</h3>
            <div class="row">
                <div class="col-5" style="margin: 0 auto;">
                    <form action="">
                        <input type="hidden" name="new-project-id" id="new-project-id" value="<?php echo $_GET["id"] ?>">
                        <div class="mb-3 form-group">
                            <label for="new-project-name" class="form-label">Projekt neve*</label>
                            <input type="text" class="form-control" id="new-project-name" name="new-project-name" value="<?php echo $project["name"] ?>" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="new-project-description" class="form-label">Leírás*</label>
                            <textarea class="form-control" name="new-project-description" id="new-project-description" cols="30" rows="7" required><?php echo $project["description"] ?></textarea>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="new-project-status" class="form-label">Státusz*</label>
                            <select id="new-project-status" class="form-select">
                                <?php
                                foreach ($statuses as $status) {
                                    if ($project["status"] == $status) {
                                        echo '<option value="' . $status . '" selected>' . $status . '</option>';
                                    } else {
                                        echo '<option value="' . $status . '">' . $status . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div id="result"></div>
                        <button type="button" class="btn btn-primary" id="project-update">Szerkesztés</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <h3>Új projekt felvétele</h3>
            <div class="row">
                <div class="col-5" style="margin: 0 auto;">
                    <form action="">
                        <input type="hidden" name="new-project-id" id="new-project-id">
                        <div class="mb-3 form-group">
                            <label for="new-project-name" class="form-label">Projekt neve*</label>
                            <input type="text" class="form-control" id="new-project-name" name="new-project-name" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="new-project-description" class="form-label">Leírás*</label>
                            <textarea class="form-control" name="new-project-description" id="new-project-description" cols="30" rows="7" required></textarea>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="new-project-status" class="form-label">Státusz*</label>
                            <select id="new-project-status" class="form-select">
                                <option value="fejlesztésre vár">fejlesztésre vár</option>
                                <option value="folyamatban">folyamatban</option>
                                <option value="kész">kész</option>
                            </select>
                        </div>
                        <div id="result"></div>
                        <button type="button" class="btn btn-primary" id="new-project-save">Mentés</button>
                    </form>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <?php if (isset($_GET["id"])) { ?>
                <div id="new-contact-section" class="col-8">
                <?php } else { ?>
                    <div id="new-contact-section" class="col-8" style="display: none;">
                    <?php } ?>
                    <p class="form-label">Kapcsolattartók</p>
                    <input type="hidden" name="edited-contact-id" id="edited-contact-id">
                    <table class="table" id="contact-table">
                        <thead>
                            <tr>
                                <th scope="col">Név</th>
                                <th scope="col">Email cím</th>
                                <th scope="col">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="new-contact-name" id="new-contact-name">
                                </td>
                                <td>
                                    <input type="email" name="new-contact-email" id="new-contact-email">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary d-block" id="add-new-contact-row">
                                        <i class="fas fa-plus-circle"> mentés</i>
                                    </button>
                                </td>
                            </tr>
                            <?php if (isset($_GET["id"]) && $contacts) {
                                foreach ($contacts as $row => $contact) {
                                    echo "<tr><td>" . $contact["name"] . "</td><td>" . $contact["email"] . "</td><td id='" . $contact["id"] . "'><i class='fas fa-pencil-alt update-contact' value='" . $contact["id"] . "'></i><i class='fas fa-trash-alt delete-contact' value='" . $contact["id"] . "'></i></td></tr>";
                                }
                            } ?>
                        </tbody>
                    </table>
                    <div id="error-message"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5" style="margin: 20px auto;text-align: center;">
                        <a href="projectList.php">
                            <button type="button" class="btn btn-light" id="btn-back">Vissza</button>
                        </a>
                    </div>
                </div>
        </div>
</body>

</html>