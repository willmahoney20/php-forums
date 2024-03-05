<!DOCTYPE html>
<html lang="en">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <?php include('./main-components/navbar.php'); ?>

    <div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
        <div class="w-1/5 border"></div>

        <div class="w-1/2 flex flex-col justify-start items-center">
            <?php include('./components/post.php'); ?>
    
            <?php include('./components/posts.php'); ?>
        </div>

        <div class="w-1/4 border"></div>
    </div>

    <?php include('./main-components/footer.php'); ?>
</html>