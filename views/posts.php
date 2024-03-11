<?php include('views/partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/leftSidebar.php'); ?>
    </div>

    <div class="w-6/12 px-8 flex flex-col justify-start items-center">
        <section class="bg-zinc-900 w-full flex flex-col items-center rounded-lg p-4 mb-6">
            <div class="bg-black w-full rounded-lg p-4">
                <form class="flex flex-col w-full" method="POST">
                    <div class="flex flex-row w-full">
                        <img class="h-8 w-8 rounded-2xl mr-2" src="../assets/propic.png" alt="Logo">
                        <div class="relative flex w-full mt-1">
                            <input type="hidden" id="contentInput" name="content">
                            <span
                                id="content"
                                name="content"
                                contenteditable
                                class="bg-transparent text-white z-20"
                                style="width: calc(100% - 40px);"
                                oninput="checkTextContent()"
                            >
                                <?= $content; ?>
                            </span>
                            <p
                                id="placeholder"
                                class="absolute top-0 text-white opacity-50 whitespace-nowrap z-10"
                                style="<?php if($error){echo "color: red";} ?>;"
                            >Write Something...</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-row justify-end items-center w-full border-t border-zinc-800 mt-4 pt-4"
                        style="<?php if($error){echo "border-color: red";} ?>;"
                    >
                        <div class="pro_box z-10">
                            <div class="pro_percent">
                                <svg>
                                    <circle cx="14" cy="14" r="14"></circle>
                                    <circle cx="14" cy="14" r="14"></circle>
                                </svg>
                                <div class="pro_number">
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <input id="postBtn" type="submit" name="submit" value="Post" class="bg-green-500 font-medium text-white rounded-lg h-8 px-3 ml-2 z-20 cursor-pointer">
                    </div>
                </form>
            </div>
        </section>

        <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
            <h2 class="text-white font-bold opacity-50 mb-2">EXPLORE</h2>
            <?php forEach($posts as $index => $post){ ?>
                <div class="bg-black w-full rounded-lg p-4 <?= ($index === array_key_last($posts)) ? 'mb-0' : 'mb-4'; ?>">
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
                        <div class="flex flex-row">
                            <button
                                class="py-1 px-0.5"
                                onClick="handleOptions(<?= $post['id']; ?>)"
                            >
                                <img class="h-auto w-4" src="../assets/editing.png" alt="Edit">
                            </button>
                            <form
                                action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="POST"
                            >
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
                    
                    <?php if($editing == $post['id']){ ?>
                        <form
                            class="flex flex-col w-full"
                            action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="POST"
                        >
                            <div class="relative flex w-full">
                                <input value="<?= $post['id']; ?>" type="hidden" name="editId">
                                <input type="hidden" id="editInput" name="editContent">
                                <span
                                    id="editContent"
                                    name="editContent"
                                    contenteditable
                                    class="bg-transparent text-white text-normal text-sm z-20 w-full"
                                    oninput="checkEditContent()"
                                >
                                    <?= $edited_content; ?>
                                </span>
                                <p
                                    id="editPlaceholder"
                                    class="absolute top-0 text-white text-normal text-sm opacity-50 whitespace-nowrap z-10"
                                    style="<?php if($editError){echo "color: red";} ?>;"
                                >Write Something...</p>
                            </div>
                            <div
                                class="flex flex-row justify-between items-center w-full border-t border-zinc-800 mt-4 pt-4"
                                style="<?php if($editError){echo "border-color: red";} ?>;"
                            >
                                <div>
                                    <button
                                        class="bg-transparent font-medium text-white border-2 border-white rounded-lg h-8 px-3 z-20"
                                        onClick="handleOptions(<?= $post['id']; ?>)"
                                    >
                                        Cancel
                                    </button>
                                </div>
                                <div class="flex flex-row items-center">
                                    <div id="edit_box" class="pro_box z-10">
                                        <div class="pro_percent">
                                            <svg>
                                                <circle cx="14" cy="14" r="14"></circle>
                                                <circle id="edit_c2" cx="14" cy="14" r="14"></circle>
                                            </svg>
                                            <div id="edit_num" class="pro_number">
                                                <h4></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" name="edit" value="Edit" class="bg-green-500 font-medium text-white rounded-lg h-8 px-3 ml-2 z-20 cursor-pointer">
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                        <a href="/posts/<?= $post['id'] ?>">
                            <p class="text-white text-normal text-sm">
                                <?= $post['content'] ?>
                            </p>
                        </a>
                    <?php } ?>
                    <div class="flex flex-row justify-between items-center mt-3">
                        <p class="text-white text-xs font-semibold">
                            0 votes
                        </p>
                        <a href="/posts/<?= $post['id'] ?>">
                            <p class="text-white text-xs font-semibold">
                                0 comments
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