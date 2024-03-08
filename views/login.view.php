<?php include('views/partials/navbar.php'); ?>

<div class="container mx-auto flex flex-col justify-center items-center p-4 pb-12" style="min-height: calc(100vh - 104px);">
    <h1 class="text-7xl text-white font-bold mb-4">Login</h1>
    <form
        class="flex flex-col w-full"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        method="POST"
    >
    </form>
</div>

<?php include('views/partials/footer.php'); ?>