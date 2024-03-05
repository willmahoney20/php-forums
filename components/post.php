<?php

    require_once 'db.php';

    $content = "";
    $error = false;
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
        if(empty($_POST['content'])){
            $error = true;
        } elseif(strlen($_POST['content']) > 255){
            $error = true;
            $content = $_POST['content'];
        } else {
            try {
                $content = htmlspecialchars($_POST['content']);
                $error = false;
    
                $sql = "INSERT INTO forum_posts (post_content) VALUES (:content)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':content', $content);
                $stmt->execute();

                header("Location: " . $_SERVER['PHP_SELF']);
            } catch (PDOException $e) {
                echo '<p style="color: white;">Post Failed: ' . $e->getMessage() . '</p>';
            }
        }
    };
    
?>

<section class="bg-zinc-900 w-full flex flex-col items-center rounded-lg p-4 mb-6">
    <div class="bg-black w-full rounded-lg p-4">
        <form
            class="flex flex-col w-full"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            method="POST"
        >
            <div class="flex flex-row w-full">
                <img class="h-8 w-8 rounded-2xl mr-2" src="../assets/propic.png" alt="Logo">
                <div class="relative flex w-full mt-1">
                    <input type="hidden" id="contentInput" name="content">
                    <span
                        id="content"
                        name="content"
                        contenteditable
                        class="bg-transparent text-white z-20"
                        style="width: calc(100%);"
                        oninput="checkTextContent()"
                    >
                        <?php echo $content; ?>
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
                <input type="submit" name="submit" value="Post" class="bg-green-500 font-medium text-white rounded-lg h-8 px-3 ml-2 z-20 cursor-pointer">
            </div>
        </form>
    </div>
</section>

<script>
    const checkTextContent = () => {
        let textContent = document.getElementById("content").innerText.trim()

        // Calculate the percentage of characters used
        let perc = textContent.length > 255 ? 1 : (textContent.length / 255)

        // Set the stroke of the second circle based on the percentage
        let secondCircle = document.querySelector(".pro_percent svg circle:nth-child(2)")
        secondCircle.style.stroke = textContent.length > 255 ? "red" : "#22c55e"
        secondCircle.style.strokeDashoffset = `calc(88 - (88 * ${perc}))`

        let progressBox = document.querySelector(".pro_box")
        let progressNum = document.querySelector(".pro_number")
        let progressText = document.querySelector(".pro_number h4")

        progressBox.style.display = "flex"

        if(textContent.length >= 235){
            progressBox.style.transform = "scale(1)"

            if(textContent.length < 265){
                progressNum.style.display = "flex"
                progressText.innerText = 255 - textContent.length
            } else {
                progressNum.style.display = "none"
            }
        } else if(textContent.length < 1){
            progressBox.style.display = "none"
        } else {
            progressBox.style.transform = "scale(0.8)"
            progressNum.style.display = "none"
            progressText.innerText = ''
        }
        
        document.getElementById("contentInput").value = textContent
        
        let placeholderText = document.getElementById("placeholder")

        // hide the placeholder text if the user has inputted text
        if(textContent === ""){
            placeholderText.style.display = "block"
        } else {
            placeholderText.style.display = "none"
        }
    }

    checkTextContent()
</script>