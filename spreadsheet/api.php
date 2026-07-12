<?php

function query($query)
{
    $res = false;
    if (!$con = mysqli_connect('localhost', 'terdeu', '54e7OtJM', 'spreadsheet_db')) {
        die("unable to connect!");
    }

    $result = mysqli_query($con, $query);
    // For non-SELECT queries mysqli_query returns true/false.
    if ($result === true) {
        $res = true;
    } elseif ($result && mysqli_num_rows($result) > 0) {
        $res = [];
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
        $query = "SELECT * FROM users ORDER BY id DESC";
        $result = query($query);
        $info['data'] = $result ?? [];
    }elseif($info['data_type'] == 'save')
    {
        // Check for an image::
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['image/jpeg', 'image/png'];

            if(in_array($_FILES['image']['type'], $allowed))
            {
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                    mkdir($folder, 0777, true);
                }

                $path = $folder . time() . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $path);

                $image = $path;
            }
        }

        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $city = $_POST['city'];

        $query = "INSERT INTO users(name, age, image, email, city) VALUES('$name', '$age', '$image', '$email', '$city')";
        $result = query($query);
        $info['data'] = $result ?? [];
    }

    echo json_encode($info);
}