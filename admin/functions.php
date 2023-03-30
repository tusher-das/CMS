<?php

function confirm_query($result)
{
    global $connection;
    if (!$result) {
        die("Query Failed " . mysqli_error($connection));
    }
}

function insert_categories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "<span class='text-danger'> *This field should not be empty!</span>";
        } else {
            $query                 = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);
            if (!$create_category_query) {
                die("Query Failed " . mysqli_error($connection));
            }
        }
    }
}

function show_all_categories()
{
    global $connection;
    $query          = "SELECT * FROM categories";
    $all_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($all_categories)) {
        $cat_id    = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>
                <td>{$cat_id}</td>
                <td>{$cat_title}</td>
                <td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>
                <td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>
            </tr>";
    }
}

function delete_a_category()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id      = $_GET['delete'];
        $query           = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $delete_category = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

?>