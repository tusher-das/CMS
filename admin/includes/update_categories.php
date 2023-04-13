<form action="" method="post"><!-- Update category Form -->
    <div class="form-group">
        <label for="cat_title">Edit Category</label>

        <?php //select category query
        if (isset($_GET['edit'])) {
            $cat_id             = $_GET['edit'];
            $query              = "SELECT * FROM categories WHERE cat_id = $cat_id";
            $select_category_id = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_category_id)) {
                $cat_id    = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>
                <input type="text" class="form-control" name="cat_title" value="<?php if (isset($cat_title)) {
                    echo $cat_title;
                } ?>">
                <?php
            }
        }
        ?>

        <?php //update category query
        if (isset($_POST['update_category'])) {
            $the_cat_title = $_POST['cat_title'];

            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
            mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id);
            mysqli_stmt_execute($stmt);

            if (!$stmt) {
                die("Query Failed " . mysqli_error($connection));
            } else {
                mysqli_stmt_close($stmt);
                header("Location: categories.php");
            }
        }
        ?>

    </div>
    <div class="form-group">
        <input class="btn btn-info" type="submit" name="update_category" value="UPDATE CATEGORY">
    </div>
</form><!-- !Update category Form -->