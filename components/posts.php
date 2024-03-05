<?php

    require_once 'db.php';    
    require_once 'helpers/datePosted.php';

    $editing = "";
    $edited_content = "";

    $editError = false;
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])){
        if(empty($_POST['editContent'])){
            $editError = true;
            $editing = $_POST['editId'];
        } elseif(strlen($_POST['editContent']) > 255){
            $editError = true;
            $edited_content = $_POST['editContent'];
            $editing = $_POST['editId'];
        } else {
            try {
                $new_content = htmlspecialchars($_POST['editContent']);
                $editError = false;
    
                $sql = "UPDATE forum_posts SET post_content = :content WHERE post_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':content', $new_content);
                $stmt->bindParam(':id', $_POST['editId']);
                $stmt->execute();

                header("Location: " . $_SERVER['PHP_SELF']);
            } catch (PDOException $e) {
                echo '<p style="color: white;">Edit Failed: ' . $e->getMessage() . '</p>';
            }
        }
    }

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

    function editPost(){
        echo '<p style="color: white;">Chow: ' . $_GET['editPost'] . '</p>';
        global $result;
        global $edited_content;
        global $editing;
        $editing = $_GET['editPost'];

        for($i = 0; $i < count($result); $i++){
            if($result[$i]['post_id'] == $_GET['editPost']){
                $edited_content = $result[$i]['post_content'];
            }
        };
    }

    if(isset($_GET['editPost'])) {
        editPost();
    }
    
?>

<section class="bg-zinc-900 w-full flex flex-col rounded-lg p-4 mb-6">
    <h2 class="text-white font-bold opacity-50 mb-2">EXPLORE</h2>
    <?php forEach($result as $key => $row){ ?>
        <div class="bg-black w-full rounded-lg p-4 <?php echo ($key === array_key_last($result)) ? 'mb-0' : 'mb-4'; ?>">
            <div class="flex flex-row justify-between items-center mb-3">
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
                        <img class="h-auto w-4" src="../assets/editing.png" alt="Options">
                    </button>
                </div>
            </div>
            
            <?php if($editing == $row['post_id']){ ?>
                <form
                    class="flex flex-col w-full"
                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                    method="POST"
                >
                    <div class="relative flex w-full">
                        <input value="<?php echo $row['post_id']; ?>" type="hidden" name="editId">
                        <input type="hidden" id="editInput" name="editContent">
                        <span
                            id="editContent"
                            name="editContent"
                            contenteditable
                            class="bg-transparent text-white text-normal text-sm z-20 w-full"
                            oninput="checkEditContent()"
                        >
                            <?php echo $edited_content; ?>
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
                                onClick="handleOptions(<?php echo $row['post_id']; ?>)"
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
                <p class="text-white text-normal text-sm">
                    <?php echo $row['post_content'] ?>
                </p>
            <?php } ?>
        </div>
    <?php } ?>
</section>

<script>
    function handleOptions(value) {
        var newUrl = window.location.pathname + "?editPost=" + encodeURIComponent(value);
        // Navigate to the new URL
        window.location.href = newUrl;
    }

    const checkEditContent = () => {        
        let textContent = document.getElementById("editContent").innerText.trim()

        // Calculate the percentage of characters used
        let perc = textContent.length > 255 ? 1 : (textContent.length / 255)

        // Set the stroke of the second circle based on the percentage
        let secondCircle = document.getElementById("edit_c2")
        secondCircle.style.stroke = textContent.length > 255 ? "red" : "#22c55e"
        secondCircle.style.strokeDashoffset = `calc(88 - (88 * ${perc}))`

        let progressBox = document.getElementById("edit_box")
        let progressNum = document.querySelector("#edit_num")
        let progressText = document.querySelector("#edit_num h4")

        progressBox.style.display = "flex"

        if(textContent.length >= 235){
            progressBox.style.transform = "scale(1)"

            if(textContent.length < 265){
                progressNum.style.display = "flex"
                progressText.innerText = 255 - textContent.length
            } else {
                progressNum.style.display = "none"
            }
        } else {
            progressBox.style.transform = "scale(0.8)"
            progressNum.style.display = "none"
            progressText.innerText = ''
        }
        
        document.getElementById("editInput").value = textContent
        
        let placeholderText = document.getElementById("editPlaceholder")

        // hide the placeholder text if the user has inputted text
        if(textContent === ""){
            placeholderText.style.display = "block"
        } else {
            placeholderText.style.display = "none"
        }
    }

    checkEditContent()
</script>