<?php

function query($query)
{
    $res = false;
    if (!$con = mysqli_connect('localhost', 'terdeu', '54e7OtJM', 'spreadsheet_db')) {
        die("unable to connect!");
    }

    $result = mysqli_query($con, $query);
    if($result && mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result)) {
            $res[] = $row;
        }
    }

    return $res;
}

if(count($_POST) > 0)
{
    $info = [];
    $info['data_type'] = $_POST['data_type'] ?? 'read';

    if($info['data_type'] == 'read')
    {
        $query = "SELECT * FROM users";
        $result = query($query);
        $info['data'] = $result ?? [];
    }

    echo json_encode($info);
}