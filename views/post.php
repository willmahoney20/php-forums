<?php include('views/partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/leftSidebar.php'); ?>
    </div>

    <div class="w-6/12 px-8 flex flex-col justify-start items-center">
        <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
            <div class="bg-black w-full rounded-lg p-4 mb-0">
                <div class="flex flex-row justify-between items-center mb-3">
                    <div class="flex flex-row items-center">
                        <img class="h-8 w-8 rounded-2xl mr-1" src="../assets/propic.png" alt="Logo">
                        <div class="flex flex-col">
                            <h6 class="text-white text-xs font-bold mb-0">
                                @<?= $post['username']; ?>
                            </h6>
                            <p class="text-white text-xs font-semibold opacity-70">
                                <?= Helpers::datePosted($post['created']) ?>
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-row items-center">
                        <button
                            onClick="handleOptions(<?= $post['id']; ?>)"
                        >
                            <img class="h-auto w-4" src="../assets/editing.png" alt="Edit">
                        </button>
                        <form
                            action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="POST"
                            class="flex items-center"
                        >
                            <input value="<?= $post['id']; ?>" type="hidden" name="deleteId">
                            <button
                                type="submit"
                                name="delete"
                                value="Delete"
                            >
                                <img class="h-auto w-4 mx-0.5 ml-1.5" src="../assets/delete.png" alt="Delete">
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-white text-normal text-sm">
                    <?= $post['content'] ?>
                </p>
                <div class="flex flex-row justify-between items-center mt-3">
                    <p class="text-white text-xs font-semibold">
                        0 votes
                    </p>
                    <p class="text-white text-xs font-semibold">
                        0 comments
                    </p>
                </div>

                <hr class="border-zinc-800 my-6" />

                <div>
                    <p class="text-white text-sm font-medium opacity-70 mb-4">
                        There are currently no comments on this post.
                    </p>
                </div>
            </div>
        </section>
    </div>

    <div class="w-4/12 border"></div>
</div>

<?php include('views/partials/footer.php'); ?>