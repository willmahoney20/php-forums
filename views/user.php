<?php include('partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/left-sidebar.php'); ?>
    </div>

    <div class="w-6/12 px-8 flex flex-col justify-start items-center">

        <?php if($user){ ?>
            <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
                <div class="relative bg-black h-32 w-full rounded-lg p-4 mb-16">
                    <img style="bottom: -64px; border-radius: 50%;" class="absolute left-4 h-32 w-32 mr-2" src="<?= $user['profile_picture'] ? $user['profile_picture'] : '../assets/propic_256.png' ?>" alt="Logo">
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <h4 class="text-white text-2xl font-bold"><?= $user['name']; ?></h4>
                            <h6 class="text-white text-sm font-medium opacity-70">@<?= $user['username']; ?></h6>
                    </div>
                    <div class="mb-4">
                        <p class="text-white text-sm font-light opacity-70">This is the profile text of this user, I don't have anything specific to say about this user, but I needed to fill some space.</p>
                    </div>
                    <div class="flex flex-row items-center mb-4">
                        <p class="text-white text-sm font-bold">
                            12 <span class="font-medium opacity-70">Following</span>
                        </p>
                        <p class="text-white text-sm font-bold ml-4">
                            47 <span class="font-medium opacity-70">Followers</span>
                        </p>
                    </div>
                    <div class="flex flex-row items-center">
                        <img class="h-4 w-4" src="../assets/location.png" alt="Logo">
                        <p class="text-white text-sm font-light opacity-70 ml-1">Paris, France</p>
                        <img class="h-4 w-4 ml-4" src="../assets/calendar.png" alt="Logo">
                        <p class="text-white text-sm font-light opacity-70 ml-1">Joined <?= Helpers::dateMonthYear($user['created']); ?></p>
                    </div>
                </div>
            </section>

            <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
                <h2 class="text-white font-bold opacity-50 mb-2">POSTS</h2>
                <?php if(count($posts) < 1){ ?>
                    <div class="flex flex-col items-center justify-center py-8">
                        <h4 class="text-white text-xl text-center font-bold mb-2">No Posts Yet</h4>
                        <p class="text-white text-sm text-center font-light opacity-70">This user hasn't posted anything yet.</p>
                    </div>
                <?php } else { ?>
                    <?php forEach($posts as $index => $post){ ?>
                        <div class="bg-black w-full rounded-lg p-4 <?= ($index === array_key_last($posts)) ? 'mb-0' : 'mb-4'; ?>">
                            <div class="flex flex-row justify-between items-center mb-3">
                                <div class="flex flex-row items-center">
                                    <img class="h-8 w-8 rounded-2xl mr-1" src="<?= $post['profile_picture'] ? $post['profile_picture'] : '../assets/propic.png' ?>" alt="Logo">
                                    <div class="flex flex-col">
                                        <h6 class="text-white text-xs font-bold mb-0">
                                            <?= $post['username']; ?>
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
                <?php } ?>
            </section>
        <?php } else { ?>
            <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
                <div class="p-12">
                    <h4 class="text-white text-xl text-center font-bold mb-2">No User</h4>
                    <p class="text-white text-sm text-center font-light opacity-70">We couldn't find the user you're looking for.</p>
                </div>
            </secion>
        <?php } ?>
    </div>

    <div class="w-4/12 border"></div>
</div>

<?php include('views/partials/footer.php'); ?>