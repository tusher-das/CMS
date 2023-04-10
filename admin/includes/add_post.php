<?php
if (isset($_POST['create_post'])) {
    $post_title       = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author      = $_POST['post_author'];
    $post_status      = $_POST['post_status'];

    $post_image      = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $post_tags          = $_POST['post_tags'];
    $post_content       = $_POST['post_content'];
    $post_date          = date('d-m-y');
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`) VALUES (NULL, '{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}')";

    $create_post_query = mysqli_query($connection, $query);

    confirm_query($create_post_query);
    header("Location: posts.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control">
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
        <input type="text" name="post_author" class="form-control"
            value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?>">
    </div>


    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="" class="form-control">
            <option value="draft">Select Options</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>



    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10" id="editor"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="PUBLISH POST">
    </div>
</form>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>