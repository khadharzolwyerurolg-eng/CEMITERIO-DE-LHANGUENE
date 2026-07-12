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
    }else if($info['data_type'] == 'delete')
    {
        $id = intval($_POST['id']);

        // Remove associated image file if exists
        $row = query("SELECT image FROM users WHERE id = $id LIMIT 1");
        if (is_array($row) && count($row) > 0) {
            $imagePath = $row[0]['image'] ?? '';
            if ($imagePath && file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $query = "DELETE FROM users WHERE id = $id LIMIT 1";

        $result = query($query);
        $info['data'] = $result ?? [];
    }elseif($info['data_type'] == 'update')
    {
        $id = intval($_POST['id']);
        $current = query("SELECT image FROM users WHERE id = $id LIMIT 1");
        $image = '';
        if (is_array($current) && count($current) > 0) {
            $image = $current[0]['image'] ?? '';
        }

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

                if ($image && file_exists($image)) {
                    @unlink($image);
                }

                $image = $path;
            }
        }

        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $city = $_POST['city'];

        $query = "UPDATE users SET name='$name', age='$age', image='$image', email='$email', city='$city' WHERE id = $id LIMIT 1";
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