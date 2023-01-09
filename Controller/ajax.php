<?php

include "./../Model/database.php";
include "./../Model/projectModel.php";
include "./../Model/contactModel.php";

if (isset($_POST["newProjectName"]) && isset($_POST["newProjectDesc"]) && isset($_POST["newProjectstatus"])) {

    $project = new Project($_POST["newProjectName"], $_POST["newProjectDesc"], $_POST["newProjectstatus"]);

    $newProjectName = $project->getName();
    $newProjectDesc = $project->getDesc();
    $newProjectstatus = $project->getStatus();

    $sql = "INSERT INTO projects (name, description, status) VALUES ('$newProjectName', '$newProjectDesc', '$newProjectstatus')";
    $result = $conn->query($sql);

    $newProjectId = $conn->insert_id;

    if ($result === TRUE) {
        echo $newProjectId;
    } else {
        echo -1;
    }
}

if (isset($_POST["saveContact"]) && isset($_POST["newContactName"]) && isset($_POST["newContactEmail"]) && isset($_POST["projectId"])) {

    $projectId = $_POST["projectId"];
    $contact = new Contact($_POST["newContactName"], $_POST["newContactEmail"]);

    $newContactName = $contact->getName();
    $newContactEmail = $contact->getEmail();

    $sql = "INSERT INTO contacts (name, email, project_id) VALUES ('$newContactName', '$newContactEmail', '$projectId')";
    $result = $conn->query($sql);

    $newContactId = $conn->insert_id;

    if ($result === TRUE) {
        echo "<tr><td>" . $newContactName . "</td><td>" . $newContactEmail . "</td><td id='" . $newContactId . "'><i class='fas fa-pencil-alt update-contact' value='" . $newContactId . "'></i><i class='fas fa-trash-alt delete-contact' value='" . $newContactId . "'></i></td></tr>";
    } else {
        echo -1;
    }
}

if (isset($_POST["updateContactId"]) && isset($_POST["newContactName"]) && isset($_POST["newContactEmail"]) && isset($_POST["projectId"])) {

    $editedContactId = $_POST["updateContactId"];
    $editedContactName = $_POST["newContactName"];
    $editedContactEmail = $_POST["newContactEmail"];

    $sql = "UPDATE contacts SET name='$editedContactName', email='$editedContactEmail' WHERE id='$editedContactId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo 1;
    } else {
        echo -1;
    }
}

if (isset($_POST["updatedProjectName"]) && isset($_POST["updatedProjectDesc"]) && isset($_POST["updatedProjectstatus"]) && isset($_POST["projectId"])) {

    $projectId = $_POST["projectId"];
    $updatedProjectName = $_POST["updatedProjectName"];
    $updatedProjectDesc = $_POST["updatedProjectDesc"];
    $updatedProjectstatus = $_POST["updatedProjectstatus"];

    $sql = "UPDATE projects SET name='$updatedProjectName', description='$updatedProjectDesc', status='$updatedProjectstatus' WHERE id='$projectId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo 1;
    } else {
        echo -1;
    }
}

if (isset($_POST["deletedProjectId"])) {

    $deletedProjectId = $_POST["deletedProjectId"];
    $sql = "DELETE FROM projects WHERE id='$deletedProjectId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo 1;
    } else {
        echo -1;
    }
}

if (isset($_POST["deletedContactId"])) {

    $deletedContactId = $_POST["deletedContactId"];
    $sql = "DELETE FROM contacts WHERE id='$deletedContactId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo 1;
    } else {
        echo -1;
    }
}
