<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query        = "SELECT * FROM posts";
        $select_posts = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_id            = $row['post_id'];
            $post_author        = $row['post_author'];
            $post_title         = $row['post_title'];
            $post_category_id   = $row['post_category_id'];
            $post_status        = $row['post_status'];
            $post_image         = $row['post_image'];
            $post_tags          = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date          = $row['post_date'];

            echo "<tr>";
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";


            $query         = "SELECT * FROM categories WHERE cat_id = $post_category_id";
            $post_category = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($post_category)) {
                $cat_id    = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<td>{$cat_title}</td>";
            }


            echo "<td>{$post_status}</td>";
            echo "<td><img width='100' height='50' src='../images/$post_image' alt='Post Image'></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_comment_count}</td>";
            echo "<td>{$post_date}</td>";
            echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>EDIT</a></td>";
            echo "<td><a href='posts.php?delete={$post_id}'>DELETE</a></td>";
            echo "</tr>";
        }
        ?>

    </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
    $the_post_id       = $_GET['delete'];
    $query             = "DELETE FROM posts WHERE post_id = $the_post_id";
    $delete_post_query = mysqli_query($connection, $query);
    confirm_query($delete_post_query);
    header("Location: posts.php");
}
?>