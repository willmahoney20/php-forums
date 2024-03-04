<?php

    include('db.php');

    echo '<p style="color: white;">Second Echo</p>';

    $content = "";
    $error = false;
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
        echo '<pre style="color: white;">';
        print_r($_POST);
        echo '</pre>';

        if(empty($_POST['content'])){
            $error = true;
        } else {
            $content = htmlspecialchars($_POST['content']);
            $error = false;
            echo '<p style="color: white;">' . htmlspecialchars($_POST['content']) . '</p>';
        }
    };

?>

<div class="container mx-auto flex justify-center items-start p-4" style="min-height: calc(100vh - 104px);">
    <section class="bg-zinc-900 max-w-96 w-full flex flex-col items-center rounded-lg p-4">
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
                        style="width: 312px;"
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
                class="flex flex-row justify-end w-full border-t border-zinc-800 mt-4 pt-4"
                style="<?php if($error){echo "border-color: red";} ?>;"
            >
                <input type="submit" name="submit" value="Post" class="bg-green-500 font-medium text-white rounded-lg h-8 px-3 ml-3">
            </div>
        </form>
    </section>
</div>

<script>
    const checkTextContent = () => {
        console.log('here')
        // Get the value of the editable text element
        let textContent = document.getElementById("content").innerText.trim()

        // Update the value of the hidden input field
        document.getElementById("contentInput").value = textContent

        // Get the placeholder text element
        let placeholderText = document.getElementById("placeholder")

        // Check if the text content is empty
        if(textContent === ""){
            // If empty, show the placeholder text
            placeholderText.style.display = "block"
        } else {
            // If not empty, hide the placeholder text
            placeholderText.style.display = "none"
        }
    }

    checkTextContent()
</script>