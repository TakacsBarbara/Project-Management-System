<?php

include "./../Model/database.php";

function listProjects($conn)
{

    $sql = "SELECT * FROM projects";
    $result = $conn->query($sql);

    return $result;
}

function listLimitedProjects($conn, $limit, $offset)
{
    $sql = "SELECT * FROM projects LIMIT $limit, $offset";
    $result = $conn->query($sql);

    return $result;
}

function getProject($conn, $id)
{
    $sql = "SELECT * FROM projects WHERE id=" . $id;
    $result = $conn->query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return $row;
}

function getContacts($conn, $id)
{
    $sql = "SELECT * FROM contacts WHERE project_id=" . $id;
    $result = $conn->query($sql);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result;
}

function getContactCount($conn, $id)
{
    $contactCount = 0;
    $sql = "SELECT * FROM contacts WHERE project_id=" . $id;
    $result = $conn->query($sql);

    foreach ($result as $contact) {
        $contactCount++;
    }

    return $contactCount;
}
