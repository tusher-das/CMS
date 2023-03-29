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
            $the_cat_title   = $_POST['cat_title'];
            $query           = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id}";
            $update_category = mysqli_query($connection, $query);
            if (!$update_category) {
                die("Query Failed " . mysqli_error($connection));
            } else {
                header("Location: categories.php");
            }
        }
        ?>

    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="UPDATE CATEGORY">
    </div>
</form><!-- !Update category Form -->