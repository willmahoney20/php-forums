<form class="flex flex-col w-full" method="POST">
    <div class="flex flex-row w-full">
        <img class="h-8 w-8 rounded-2xl mr-2" src="../../assets/propic.png" alt="Logo">
        <div class="relative flex w-full mt-1">
            <input type="hidden" id="contentInput" name="content">
            <span
                id="content"
                name="content"
                contenteditable
                class="bg-transparent text-white <?= $_SERVER['REQUEST_URI'] === '/posts' ? '' : 'text-sm' ?> z-20"
                style="width: calc(100%);"
                oninput="checkTextContent()"
            >
                <?= $content; ?>
            </span>
            <p id="placeholder" class="absolute top-0 text-white <?= $_SERVER['REQUEST_URI'] === '/posts' ? '' : 'text-sm' ?> opacity-50 whitespace-nowrap z-10">Write Something...</p>
        </div>
    </div>
    <div class="flex flex-row justify-end items-center w-full border-t border-zinc-800 mt-4 pt-4">
        <div class="pro_box z-10">
            <div class="pro_percent">
                <svg class="max-w-8 max-h-8">
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