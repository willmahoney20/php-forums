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
    let html = '<ul style="margin-left: ' + (embedded === 0 ? '0' : '36') + 'px">'

    console.log('hey', comments)

    comments.forEach((comment, index) => {
        let mb = index === comments.length - 1 ? ' mb-0 ' : ' mb-8 '
        let mt = index !== 0 ? ' mt-0 ' : ' mt-6 '
        let pp = comment.profile_picture ? comment.profile_picture : '../assets/propic.png' // this is the comment user's profile picture to render
        html += '<li class="relative w-full' + mb + mt + '">'
            if(comment.replies && comment.replies.length > 0){
                html += '<div class="border-l border-zinc-600 absolute top-10 left-4 z-0" style="height: calc(100% - 44px)"></div>'
            }
            html += '<div class="flex flex-row justify-between items-center mb-2">'
                html += '<div class="flex flex-row items-center">'
                    html += '<img class="h-8 w-8 rounded-2xl mr-1" src="' + pp + '" alt="Logo">'
                    html += '<div class="flex flex-col">'
                        html += '<h6 class="text-white text-xs font-bold mb-0">@' + comment.username + '</h6>'
                        html += '<p class="text-white text-xs font-semibold opacity-70">' + datePosted(comment.created) + '</p>'
                    html += '</div>'
                html += '</div>'

                html += '<div class="flex flex-row items-center">'
                    html += '<a href="/posts/edit/' + comment.id + '">'
                        html += '<button class="py-1 px-0.5">'
                            html += '<img class="h-auto w-4" src="../assets/editing.png" alt="Edit">'
                        html += '</button>'
                    html += '</a>'
                    html += '<form method="POST">'
                        html += '<input value="' + comment.id + '" type="hidden" name="deleteId">'
                        html += '<button type="submit" name="delete" value="Delete" class="py-1 px-0.5 ml-1">'
                            html += '<img class="h-auto w-4" src="../assets/delete.png" alt="Delete">'
                        html += '</button>'
                    html += '</form>'
                html += '</div>'
            html += '</div>'
            html += '<p class="text-white text-normal text-sm pl-9">' + comment.content + '</p>'
            if(comment.replies && comment.replies.length > 0){
                html += renderComments(comment.replies, embedded + 1)
            }
        html += '</li>'
    })

    html += '</ul>'

    return html
}
