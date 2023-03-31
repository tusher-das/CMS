<?php include("includes/admin_header.php"); ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("includes/admin_navigation.php"); ?>

    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <?php include("includes/admin_heading.php"); ?>

                <div class="col-xs-6">
                    <!-- Add category Form -->
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="cat_title">Add Category</label>

                            <!-- add category query -->
                            <?php insert_categories(); ?>

                            <input type="text" class="form-control" name="cat_title" id="">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="submit" value="ADD CATEGORY">
                        </div>
                    </form><!-- !Add category Form -->

                    <!-- update category -->
                    <?php
                    if (isset($_GET['edit'])) {
                        $cat_id = $_GET['edit'];
                        include("includes/update_categories.php");
                    }
                    ?>

                </div>

                <!-- Category table -->
                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Show all categories -->
                            <?php show_all_categories(); ?>
                        </tbody>

                        <!-- Delete a category -->
                        <?php delete_a_category(); ?>

                    </table>
                </div><!-- !Category table -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include("includes/admin_footer.php") ?>