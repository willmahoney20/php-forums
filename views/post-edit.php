<?php include('partials/navbar.php'); ?>

<div class="container mx-auto flex flex-row justify-between items-start p-4" style="min-height: calc(100vh - 104px);">
    <div class="w-2/12">
        <?php include('partials/left-sidebar.php'); ?>
    </div>

    <div class="w-6/12 px-8 flex flex-col justify-start items-center">
        <section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
            <div class="bg-black w-full rounded-lg p-4">
                <form class="flex flex-col w-full" method="POST">
                    <div class="flex flex-row w-full">
                        <img class="h-8 w-8 rounded-2xl mr-2" src="../../assets/propic.png" alt="Logo">
                        <div class="relative flex w-full mt-1">
                            <input value="<?= $post['id']; ?>" type="hidden" name="id">
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
                            >Update Your Post...</p>
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
    </div>

    <div class="w-4/12 border"></div>
</div>

<?php include('partials/footer.php'); ?>