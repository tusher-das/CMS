<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query            = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_info = mysqli_query($connection, $query);

    confirm_query($select_user_info);

    while ($row = mysqli_fetch_assoc($select_user_info)) {
        $user_id        = $row['user_id'];
        $user_name      = $row['username'];
        $user_password  = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname  = $row['user_lastname'];
        $user_email     = $row['user_email'];

        $user_image = $row['user_image'];
        if (empty($user_image)) {
            $user_image = 'noImage.jpg';
        }

        $user_role = $row['user_role'];
    }
}
?>

<div class="card" style="width: 20rem; margin: auto; text-align:center;">
    <img src="../images/profile/<?php echo $user_image; ?>" class="card-img-top"
        style="width:100px; height:100px; border-radius: 50px;" alt="...">
    <div class="card-body">
        <h3>
            <?php echo $user_firstname . ' ' . $user_lastname; ?>
        </h3>
        <p style="text-align:left;"><strong>Id:
                <?php echo $user_id; ?>
            </strong>
        </p>
        <p style="text-align:left;"><strong>Username:
                <?php echo $username; ?>
            </strong>
        </p>
        <p style="text-align:left;"><strong>Email:
                <?php echo $user_email; ?>
            </strong>
        </p>
        <p style="text-align:left;"><strong>First name:
                <?php echo $user_firstname; ?>
            </strong>
        </p>
        <p style="text-align:left;"><strong>Last name:
                <?php echo $user_lastname; ?>
            </strong>
        </p>
        <p style="text-align:left;"><strong>Role:
                <?php echo $user_role; ?>
            </strong>
        </p>
        <a href="profile.php?source=edit_profile" class="btn btn-primary">Edit</a>
    </div>
</div>