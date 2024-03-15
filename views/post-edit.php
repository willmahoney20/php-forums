<?php include('partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/left-sidebar.php'); ?>
    </div>

    <div class="w-6/12 px-8 flex flex-col justify-start items-center">
        <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
            <div class="bg-black w-full rounded-lg p-4">
                <?php include('partials/post-form.php'); ?>
            </div>
        </section>
    </div>

    <div class="w-4/12 border"></div>
</div>

<?php include('partials/footer.php'); ?>