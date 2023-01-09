<?php
include "./../Controller/query.php";

$projects = listProjects($conn);
$itemsPerPage = 10;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$startPageFrom = ($page - 1) * $itemsPerPage;
$limitedItems = listLimitedProjects($conn, $startPageFrom, $itemsPerPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektlista</title>

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

    <div class="row">
        <div class="col-12">
            <div class="col-10 mx-auto">
                <h2>Projekt lista</h2>
                <div class="new-project-btn-container">
                    <button type="button" class="btn btn-info new-project-btn" onclick="location.href = 'createEditProject.php'" id="addNewProject">
                        <i class="fas fa-plus-circle new-project-plus-icon"></i>
                        <span class="new-project-text">Új projekt</span>
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Név</th>
                            <th scope="col">Státusz</th>
                            <th scope="col">Kapcsolattartók száma</th>
                            <th scope="col">Műveletek</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($limitedItems as $project) {
                            $contactCount = getContactCount($conn, $project["id"]);
                        ?>

                            <tr>
                                <td><?php echo $project["name"]; ?></td>
                                <td><?php echo $project["status"]; ?></td>
                                <td><?php echo $contactCount; ?></td>
                                <td>
                                    <a href="createEditProject.php?id=<?php echo $project["id"] ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <i class="fas fa-trash-alt delete-project-btn" value="<?php echo $project["id"] ?>"></i>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-10 mx-auto pagination-container">
                <?php
                $totalItems = mysqli_num_rows($projects);
                $totalPages = ceil($totalItems / $itemsPerPage);

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a class='btn btn-light' href='projectList.php?page=" . $i . "'>" . $i . "</a>";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>