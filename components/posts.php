<?php

    require_once 'db.php';    
    require_once 'helpers/datePosted.php';

    try {
        $stmt = $pdo->prepare("SELECT * FROM forum_posts");
        $stmt->execute();

        $result = $stmt->fetchAll();

        if(!$result){
            echo '<p style="color: white;">No posts found</p>';
        }
    } catch (PDOException $e) {
        echo '<p style="color: white;">Failed to fetch posts: ' . $e->getMessage() . '</p>';
    }

    $popup = "";
    function handleOptions($value){
        echo '<p style="color: white;">Chow: ' . $value . '</p>';
        global $popup;
        $popup = $value;
    }
    
?>

<section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
    <h2 class="text-white font-bold opacity-50 mb-2">EXPLORE</h2>
    <?php forEach($result as $key => $row){ ?>
        <div class="bg-black w-full rounded-lg p-4 <?php echo ($key === array_key_last($result)) ? 'mb-0' : 'mb-4'; ?>">
            <div class="flex flex-row justify-between items-center mb-2">
                <div class="flex flex-row items-center">
                    <img class="h-8 w-8 rounded-2xl mr-1" src="../assets/propic.png" alt="Logo">
                    <div class="flex flex-col">
                        <h6 class="text-white text-xs font-bold mb-0">@the_flash</h6>
                        <p class="text-white text-xs font-semibold opacity-70">
                            <?php echo datePosted($row['post_created']) ?>
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <button
                        class="py-1 px-0.5"
                        onClick="handleOptions(<?php echo $row['post_id']; ?>)"
                    >
                        <img class="h-auto w-4" src="../assets/dots.png" alt="Options">
                    </button>

                    <?php if($popup === $row['post_id']){ ?>
                        <span class="bg-zinc-900 absolute top-6 right-0 p-1 px-2 border border-white rounded shadow-md shadow-slate-600">
                            <button>
                                <p class="text-xs text-white font-medium p-1">
                                    Edit
                                </p>
                            </button>
                            <hr class="my-1" />
                            <button>
                                <p class="text-xs text-white font-medium p-1">
                                    Delete
                                </p>
                            </button>
                        </span>
                    <?php } ?>
                </div>
            </div>
            <p class="text-white text-normal text-sm">
                <?php echo $row['post_content'] ?>
            </p>
        </div>
    <?php } ?>
</section>