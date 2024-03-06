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