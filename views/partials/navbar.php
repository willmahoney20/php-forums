<!DOCTYPE html>
<html lang="en">
    <script src="https://cdn.tailwindcss.com"></script>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico">
        <link href="../../index.css" rel="stylesheet">
        <title>PHP Forums</title>
    </head>
    <body class="relative bg-black">
        <div class="min-h-screen flex flex-col justify-between">        
            <div class="container mx-auto flex flex-row justify-between items-center p-4">
                <a href="/posts">
                    <div class="flex flex-row">
                        <img class="h-8 w-8" src="../../assets/logo.png" alt="Logo">
                        <div class="flex flex-col ml-2">
                            <h3 class="text-white text-sm font-bold mb-0">FORUX</h3>
                            <h5 class="text-white text-xs font-semibold opacity-70">PHP FORUMS</h5>
                        </div>
                    </div>
                </a>
                <?php if(Helpers::isLoggedIn()){ ?>
                    <div class="flex flex-row">
                        <form method='GET' action='/posts'>
                            <div class="relative flex items-center border border-gray-500 rounded-lg h-8 w-60 pl-2">
                                <button type="submit" class="mr-1 h-5 w-5">
                                    <img class="h-5 w-5" src="../../assets/search.png" alt="Logo">
                                </button>
                                <input name="search" class="w-full bg-transparent text-sm font-normal text-gray-400 pr-2" placeholder="Search..." autocomplete="off">
                            </div>
                        </form>
                        <a href="/users/will" class="flex flex-row">
                            <img class="h-8 w-8 rounded-2xl ml-3" src="<?= $_SESSION['auth']->user->profile_picture ? $_SESSION['auth']->user->profile_picture : "../../assets/propic.png" ?>" alt="Logo">
                            <div class="flex flex-col ml-1">
                                <h3 class="text-white text-xs font-bold mb-0"><?= $_SESSION['auth']->user->name; ?></h3>
                                <h5 class="text-white text-xs font-semibold opacity-70">@<?= $_SESSION['auth']->user->username; ?></h5>
                            </div>
                        </a>
                        <a href="/logout">
                            <button class="bg-transparent font-medium text-sm text-white border-2 border-white rounded-lg h-8 px-3 ml-3">
                                Logout
                            </button>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="flex flex-row">
                        <a href="/login">
                            <button class="bg-transparent font-medium text-sm text-white border-2 border-white rounded-lg h-8 px-3 ml-3">
                                Login
                            </button>
                        </a>
                    </div>
                <?php } ?>
            </div>