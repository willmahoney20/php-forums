<?php include('views/partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/left-sidebar.php'); ?>
    </div>

    <div class="w-7/12 px-8 flex flex-col justify-start items-center">
        <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
            <?php if(!$post){ ?>
                <div class="flex justify-center items-center p-4">
                    <p class="text-white text-sm font-medium opacity-70">
                        Sorry, this post doesn't exist.
                    </p>
                </div>
            <?php } else { ?>
                <div class="bg-black w-full rounded-lg p-4 mb-0">
                    <div class="flex flex-row justify-between items-center mb-3">
                        <a href="/users/<?= $post->username; ?>">
                            <div class="flex flex-row items-center">
                                <img class="h-8 w-8 rounded-2xl mr-1" src="<?= $post->profile_picture ? $post->profile_picture : '../assets/propic.png' ?>" alt="Logo">
                                <div class="flex flex-col">
                                    <h6 class="text-white text-xs font-bold mb-0">
                                        <?= $post->username; ?>
                                    </h6>
                                    <p class="text-white text-xs font-semibold opacity-70">
                                        <?= Helpers::datePosted($post->created) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="flex flex-row items-center">
                            <a href="<?= '/posts/edit/' . $post->id; ?>">
                                <button class="py-1 px-0.5">
                                    <img class="h-auto w-4" src="../assets/editing.png" alt="Edit">
                                </button>
                            </a>
                            <form method="POST">
                                <input value="<?= $post->id; ?>" type="hidden" name="deleteId">
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
                    <p class="text-white text-normal text-sm">
                        <?= $post->content ?>
                    </p>
                    <div class="flex flex-row justify-between items-center mt-3 mb-6">
                        <p class="text-white text-xs font-semibold">
                            0 votes
                        </p>
                        <p class="text-white text-xs font-semibold">
                            <?= $post->comments_count == 1 ? '1 comment' : $post->comments_count . ' comments' ?>
                        </p>
                    </div>
                    
                    <?php include('partials/post-form.php'); ?>

                    <div>
                        <?php if(!$comments || count($comments) < 1){ ?>
                            <p class="text-white text-sm font-medium opacity-70 mb-4">
                                There are currently no comments on this post.
                            </p>
                        <?php } else { ?>
                            <div id="comments-container" class="mt-4"></div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>

    <div class="w-3/12">
        <?php include('partials/right-sidebar.php'); ?>
    </div>
</div>

<?php include('views/partials/footer.php'); ?>

<script>
    const js_comments = <?= json_encode($comments); ?>

    if(js_comments.length > 0){
        const commentsHtml = renderComments(js_comments)

        document.getElementById('comments-container').innerHTML = commentsHtml
    }
</script>