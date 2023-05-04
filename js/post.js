// jQuery(2006)jQuery(Version 3.6.1)[Source code] https://github.com/jquery
if (document.getElementById("all-post-grid")) {
    postGridSetHeight();
    window.addEventListener("resize", postGridSetHeight);    
}

function postGridSetHeight() {
    const posts = document.querySelectorAll(".post");
    let finalHeight = 0;
    if (window.innerWidth <= 600) {
        for (const post of posts) {
            finalHeight += post.offsetHeight;
        }
    } else {
        let oddHeight = 0, evenHeight = 0, itemCount = 1;
        for (const post of posts) {
            if (itemCount % 2 == 0) {
                evenHeight += post.offsetHeight;
            } else {
                oddHeight += post.offsetHeight;
            }
            itemCount++;
        }
        finalHeight = oddHeight > evenHeight ? oddHeight : evenHeight;
    }
    document.getElementById("all-post-grid").style.height = finalHeight + 500 + "px";
}

function loadPostDetail(post_id) {
    $.get(`./post-popup/${post_id}`, function (data) {
        $("#post-detail").html(data);
    }).then(
        $('#post-detail').fadeIn('fast').css('display', 'flex')
    );
    if ($('.post-detail-img > img').height() > $('.post-detail-img > img').width()) {
        $('.post-detail-img > img').css('height: 100%');
    } else {
        $('.post-detail-img > img').css('width: 100%');        
    }
}

$(document).ready(function () {
    $(document).on('click', '#closeBtn', ()=>{
        $('#post-detail').fadeOut('fast');
    });
    $(document).on('click', '#cancelPostBtn', ()=>{
        $('#newPost').fadeOut('fast');
    });
    $(document).on('click', '.post-view-comment', (e)=>{
        const post_id = $(e.target).data()['postid'];
        console.log(post_id);
        loadPostDetail(post_id);
    });
    $('#newPostBtn').click(()=>{
        $('#newPost').fadeIn('fast').css('display', 'flex');
    });
    $(document).on('click', '#replyBtn', (e) => {
        e.preventDefault();
        var theComment = {
            'isPost': 0,
            'words': $('#reply').val(),
            'post_id': $('#reply').data()['postid']
        };
        $.ajax({
            url: './views/post-comment.php',
            type: 'post',
            data: theComment,
            cache: false,
            async: false,
            success: function (html) { alert(html); loadPostDetail($('#reply').data()['postid']); }
        });
    });
    $('#sendBtn').click(()=>{
        let sender = $('#sender').val();
        if (sender.replaceAll(' ', '') == '') {
            sender = 'Anonymous';
        }
        var thePost = {
            'isPost': 1,
            'title': $('h2.post-title input').val(),
            'words': $('#new-post-text').val(),
            'sender': sender,
            'isActivity': $('#post-as-activity').prop('checked') ? 1 : 0
        };
        $.ajax({
            url: './views/post-comment.php',
            type: 'post',
            data: thePost,
            cache: false,
            async: false,
            success: function (html) { alert(html); location.reload();}
        });
    });
});