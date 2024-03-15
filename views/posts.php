<?php include('partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/left-sidebar.php'); ?>
    </div>

    <div class="w-6/12 px-8 flex flex-col justify-start items-center">
        <?php if(!$searchQuery){ ?>
            <section class="bg-zinc-900 w-full flex flex-col items-center rounded-lg p-4 mb-6">
                <div class="bg-black w-full rounded-lg p-4">
                    <?php include('partials/post-form.php'); ?>
                </div>
            </section>
        <?php } ?>

        <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
            <?php if($searchQuery){ ?>
                <h2 class="text-white font-bold opacity-50 mb-1">SEARCH</h2>
                <h4 class="text-white font-medium text-sm opacity-50 mb-2">
                    <?= count($posts) ?> result<?= count($posts) === 1 ? '' : 's' ?> found for "<?= $searchQuery ?>"
                </h4>
            <?php } else { ?>
                <h2 class="text-white font-bold opacity-50 mb-2">EXPLORE</h2>
            <?php } ?>
            <?php forEach($posts as $index => $post){ ?>
                <div class="bg-black w-full rounded-lg p-4 <?= ($index === array_key_last($posts)) ? 'mb-0' : 'mb-4'; ?>">
                    <div class="flex flex-row justify-between items-center mb-3">
                        <div class="flex flex-row items-center">
                            <img class="h-8 w-8 rounded-2xl mr-1" src="<?= $post['profile_picture'] ? $post['profile_picture'] : '../assets/propic.png' ?>" alt="Logo">
                            <div class="flex flex-col">
                                <h6 class="text-white text-xs font-bold mb-0">
                                    @<?= $post['username']; ?>
                                </h6>
                                <p class="text-white text-xs font-semibold opacity-70">
                                    <?= Helpers::datePosted($post['created']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <a href="<?= '/posts/edit/' . $post['id']; ?>">
                                <button class="py-1 px-0.5">
                                    <img class="h-auto w-4" src="../assets/editing.png" alt="Edit">
                                </button>
                            </a>
                            <form method="POST">
                                <input value="<?= $post['id']; ?>" type="hidden" name="deleteId">
                                <button
                                    type="submit"
                                    name="delete"
                                    value="Delete"
                                    class="py-1 px-0.5 ml-1"
                                >
                                    <img class="h-auto w-4" src="../assets/delete.png" alt="Delete">
                                </button>
                            </form>
                        </div>
                    </div>
                    <a href="/posts/<?= $post['id'] ?>">
                        <p class="text-white text-normal text-sm">
                            <?= $post['content'] ?>
                        </p>
                    </a>
                    <div class="flex flex-row justify-between items-center mt-3">
                        <p class="text-white text-xs font-semibold">
                            0 votes
                        </p>
                        <a href="/posts/<?= $post['id'] ?>">
                            <p class="text-white text-xs font-semibold">
                                <?= $post['comments_count'] == 1 ? '1 comment' : $post['comments_count'] . ' comments' ?>
                            </p>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>

    <div class="w-4/12 border"></div>
</div>

<?php include('views/partials/footer.php'); ?>