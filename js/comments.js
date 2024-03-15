let periods = ["second", "minute", "hour", "day", "week", "month", "year"]
    lengths = [60, 60, 24, 7, 4.35, 12]

function datePosted(dateString){
    let timestamp = new Date(dateString).getTime()
        currentTimestamp = Date.now()
    
    let difference = (currentTimestamp - timestamp) / 1000
        
    let last_i = 0
    for(let i = 0; difference >= lengths[i] && i < lengths.length - 1; i++) {
        difference /= lengths[i]
        last_i = i + 1
    }
    
    difference = Math.round(difference);
    
    if(difference !== 1) periods[last_i] += "s"
    
    return difference + " " + periods[last_i] + " ago"
}

function renderComments(comments, embedded = 0) {
    let html = '<ul style="margin-left: ' + (embedded === 0 ? '0' : '36') + 'px" class="mt-4">'

    comments.forEach((comment, index) => {
        if(!comment.status && comment.replies < 1 && embedded < 1) return

        let mb = index === comments.length - 1 ? ' mb-0 ' : ' mb-6 '
        let pp = comment.profile_picture ? comment.profile_picture : '../assets/propic.png'
        let content = comment.status ? comment.content : '[DELETED]'
        
        html += '<li class="relative w-full' + mb + '">'
            if(comment.replies && comment.replies.length > 0){
                html += '<div class="border-l border-zinc-600 absolute top-10 left-4 z-0" style="height: calc(100% - 44px)"></div>'
            }
            html += '<div class="flex flex-row justify-between items-center mb-2">'
                html += '<div class="flex flex-row items-center">'
                    html += '<img class="h-8 w-8 rounded-2xl mr-1" src="' + pp + '" alt="Logo">'
                    html += '<div class="flex flex-col">'
                        html += '<h6 class="text-white text-xs font-bold mb-0">' + comment.username + '</h6>'
                        html += '<p class="text-white text-xs font-semibold opacity-70">' + datePosted(comment.created) + '</p>'
                    html += '</div>'
                html += '</div>'
            html += '</div>'
            html += '<p class="text-white text-normal text-sm pl-9">' + content + '</p>'
            html += '<div class="flex flex-row mt-2 pl-9">'
                html += '<button onClick="displayCommentInput(' + comment.id + ')" class="flex flex-row items-center">'
                    html += '<img style="height: 14px; width: 14px" src="../../assets/new.png" alt="Logo">'
                    html += '<p class="text-zinc-500 text-normal text-xs font-semibold ml-1">Reply</p>'
                html += '</button>'
                if(comment.status){
                    html += '<form method="POST" class="ml-4">'
                        html += '<input value="' + comment.id + '" type="hidden" name="deleteId">'
                        html += '<button type="submit" name="deleteComment" class="flex flex-row items-center">'
                            html += '<img style="height: 13px; width: 13px" src="../../assets/delete.png" alt="Logo">'
                            html += '<p class="text-zinc-500 text-normal text-xs font-semibold ml-1">Delete</p>'
                        html += '</button>'
                    html += '</form>'
                }
            html += '</div>'

            html += '<form id="commentForm' + comment.id + '" class="hidden flex-col w-full pl-9 mt-2" method="POST">'
                html += '<div class="flex flex-row w-full">'
                    html += '<div class="relative flex w-full mt-1">'
                        html += '<input type="hidden" name="parentId" value="' + comment.id + '">'
                        html += '<input type="hidden" id="comContentInput' + comment.id + '" name="content">'
                        html += '<span id="comContent' + comment.id + '" name="content" contenteditable class="bg-transparent text-white text-sm z-20" style="width: calc(100%);" oninput="checkCommentContent(' + comment.id + ')"></span>'
                        html += '<p id="placeholder' + comment.id + '" class="absolute top-0 text-white text-sm opacity-50 whitespace-nowrap z-10">Write Something...</p>'
                    html += '</div>'
                html += '</div>'
                html += '<div class="flex flex-row justify-end items-center w-full border-t border-zinc-800 mt-2 pt-2">'
                    html += '<div id="comProBox' + comment.id + '" class="hidden pro_box z-10">'
                        html += '<div class="pro_percent">'
                            html += '<svg class="max-w-8 max-h-8">'
                                html += '<circle id="c1' + comment.id + '" cx="14" cy="14" r="14"></circle>'
                                html += '<circle id="c2' + comment.id + '" cx="14" cy="14" r="14"></circle>'
                            html += '</svg>'
                            html += '<div id="comProNumber' + comment.id + '" class="pro_number">'
                                html += '<h4 id="comProh4' + comment.id + '"></h4>'
                            html += '</div>'
                        html += '</div>'
                    html += '</div>'
                    html += '<button type="button" onClick="removeCommentInput(' + comment.id + ')" style="background-color: grey;" class="font-medium text-white text-sm rounded-lg h-7 px-2 ml-2 z-20 cursor-pointer">Cancel</button>'
                    html += '<input id="comPostBtn' + comment.id + '" type="submit" name="submit" value="Post" style="background-color: grey;" class="font-medium text-white text-sm rounded-lg h-7 px-2 ml-2 z-20 cursor-pointer">'
                html += '</div>'
            html += '</form>'
            
            if(comment.replies && comment.replies.length > 0){ 
                html += renderComments(comment.replies, embedded + 1)
            }
        html += '</li>'
    })

    html += '</ul>'

    return html
}

function displayCommentInput(id) {
    document.getElementById('commentForm' + id).style.display = 'flex'
}

function removeCommentInput(id) {
    document.getElementById("comContent" + id).innerText = ""
    document.getElementById("comContentInput" + id).value = ""
    document.getElementById("placeholder" + id).style.display = "block"
    document.getElementById("comProBox" + id).style.display = "none"
    document.getElementById("comProNumber" + id).style.display = "none"
    document.getElementById("comProh4" + id).innerText = ''
    document.getElementById("comPostBtn" + id).disabled = true
    document.getElementById("comPostBtn" + id).style.backgroundColor = 'grey'
    document.getElementById('commentForm' + id).style.display = 'none'
}

function checkCommentContent(id) {
    let textContent = document.getElementById("comContent" + id).innerText.trim()

    // calculate the percentage of characters used
    let perc = textContent.length > 255 ? 1 : (textContent.length / 255)

    // get the "Post" button, and prevent form submission if necessary
    let submitBtn = document.getElementById("comPostBtn" + id)
    if(textContent.length > 255 || textContent.length < 1){
        submitBtn.style.backgroundColor = 'grey'
        submitBtn.disabled = true
    } else {
        submitBtn.style.backgroundColor = '#22C55E'
        submitBtn.disabled = false
    }

    // set the stroke of the second circle based on the percentage
    let secondCircle = document.getElementById("c2" + id)
    secondCircle.style.stroke = textContent.length > 255 ? "red" : "#22c55e"
    secondCircle.style.strokeDashoffset = `calc(88 - (88 * ${perc}))`

    let progressBox = document.getElementById("comProBox" + id)
    let progressNum = document.getElementById("comProNumber" + id)
    let progressText = document.getElementById("comProh4" + id)

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
    
    document.getElementById("comContentInput" + id).value = textContent
    
    let placeholderText = document.getElementById("placeholder" + id)

    // hide the placeholder text if the user has inputted text
    if(textContent === ""){
        placeholderText.style.display = "block"
    } else {
        placeholderText.style.display = "none"
    }
}
