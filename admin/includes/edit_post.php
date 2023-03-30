<?php
if (isset($_GET['p_id'])) {
    $the_post_id       = $_GET['p_id'];
    $query             = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_post_by_id = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_post_by_id)) {
        $post_id            = $row['post_id'];
        $post_author        = $row['post_author'];
        $post_title         = $row['post_title'];
        $post_category_id   = $row['post_category_id'];
        $post_status        = $row['post_status'];
        $post_image         = $row['post_image'];
        $post_tags          = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date          = $row['post_date'];
        $post_content       = $row['post_content'];
    }
}

if (isset($_POST['update_post'])) {
    $post_author      = $_POST['post_author'];
    $post_title       = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_status      = $_POST['post_status'];
    $post_image       = $_FILES['post_image']['name'];
    $post_image_temp  = $_FILES['post_image']['tmp_name'];
    $post_tags        = $_POST['post_tags'];
    $post_content     = $_POST['post_content'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_image)) {
        $query              = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image_query = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_image_query)) {
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$the_post_id}";

    $update_post_query = mysqli_query($connection, $query);
    confirm_query($update_post_query);
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" value="<?php echo $post_title; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category</label>
        <select name="post_category_id" id="" class="form-control">
            <?php
            $query          = "SELECT * FROM categories";
            $all_categories = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($all_categories)) {
                $cat_id    = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>

        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" value="<?php echo $post_author; ?>" name="post_author" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" name="post_status" value="<?php echo $post_status; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img width="100" height="50" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" value="<?php echo $post_tags; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="UPDATE POST">
    </div>
</form>