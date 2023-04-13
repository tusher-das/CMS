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
            $user_image = 'noImage.png';
        }

        $user_role = $row['user_role'];
    }
}
?>

<div class="profile-card">
    <img src="../images/profile/<?php echo $user_image; ?>" width="150" height="150" alt="..." class="img-circle">
    <div class="profile-card-body">
        <h3 class="highlight">
            <?php echo $user_firstname . ' ' . $user_lastname; ?>
        </h3>
        <p><strong>Id:
                <?php echo $user_id; ?>
            </strong>
        </p>
        <p><strong>Username:
                <?php echo $username; ?>
            </strong>
        </p>
        <p><strong>Email:
                <?php echo $user_email; ?>
            </strong>
        </p>
        <p><strong>First name:
                <?php echo $user_firstname; ?>
            </strong>
        </p>
        <p><strong>Last name:
                <?php echo $user_lastname; ?>
            </strong>
        </p>
        <p><strong>Role:
                <?php echo $user_role; ?>
            </strong>
        </p>
        <a href="profile.php?source=edit_profile" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
    </div>
</div>