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