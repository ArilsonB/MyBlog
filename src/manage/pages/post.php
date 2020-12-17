<?php
    require_once(realpath('./libs/class/posts.class.php'));
    $uri = isset($_GET['posting']);
    if($uri){
        $post_title = $_POST['title'];
        $post_content = $_POST['content'];
        if($post_title || $post_content){
            Post::create($post_title,$post_content);
        }

    }

?>
<form class="inside" action="./post?posting" method="POST">
    <section class="container">
        <div class="title-content">
            <h1>Your Dashboard</h1>
            <button onclick="window.location = './post';">Save</button>
        </div>
        <input type="text" name="title" id="" placeholder="Your Article Title">
        <myb-editor>
            <myb-toolbar>
                
                <button data-action="Undo"><</button>
                <button data-action="Redo">></button>
                <button data-action="bold">B</button>
                <button data-action="italic">I</button>
                <button data-action="formatBlock" data-value="blockquote">Block</button>
                <button data-action=""></button>
                <button></button>
                <button></button>
            </myb-toolbar>
            <div class="myb-textarea">
                <myb-textarea></myb-textarea>
                <textarea name="content" style="display:none;"></textarea>
            </div>
            <myb-footer>
                <span>Characters: <span class="myb-characters"></span></span>
            </myb-footer>
        </myb-editor>
    </section>
    <aside class="right-bar">
        <div class="aside-content">
            Blablabla
        </div>
        <div class="aside-content">
            <?= print_r($_POST);?>
        </div>
        <div class="aside-content">
            <button type="submit">
                Enviar
            </button>
        </div>
    </aside>
</form>
<script src="./js/myb-editor.js"></script>
<!--<div class="post-page">
    <h1>Create Post</h1>
    <form class="post-content" method='POST' action='./post'>
        <div class="post-title">
            <input type="text" name="title" id="" placeholder="Titulo da Postagem">
            <small><strong>https://test.myblog.dot/2020/05/post-name.html</strong></small>
        </div>
        <div class="post-textarea">
            <button class="btn-bold">Bold</button>
            <myb-textarea>
                <iframe frameborder="0" id="myb-frame" class="myb-text" name="editor">
                </iframe>
                <textarea name="post_textarea" spellcheck="true" id="myb-textarea" class="myb-content" style="display:none;"></textarea>
            </myb-textarea>
        </div>
        <div class="post-button">
            <button type="submit">
                Criar Postagem
            </button>
        </div>
    </form>
</div>-->
<!--<script src="./emmet.min.js" type="text/javascript"></script>-->
<!--<script>
    var iframe = document.querySelector('#myb-frame');
    var content = document.createElement('body');
        content.contentEditable = true;
        content.spellcheck = true;
        content.lang = "pt-BR";
        content.id = "myb-textarea"
        content.innerHTML += "<p>Place</p>";
    let frameDoc = iframe.document;
    if (iframe.contentWindow)
        frameDoc = iframe.contentWindow.document;

    frameDoc.open('text/html', 'replace');
    frameDoc.appendChild(content)
    frameDoc.close();

    let frameContent = document.querySelector('#myb-frame').contentWindow.document;
    document.querySelector('.btn-bold').addEventListener('click', function(e) {
        e.preventDefault();
        frameContent.execCommand('bold', false, null);
    });


    const mybText = (e) => {
        e.preventDefault()
        let content = e.target.innerHTML;
        let textarea = document.querySelector('#myb-textarea');
        textarea.value = content;
    }
    frameContent.addEventListener('keyup',mybText);


    /* emmet.require('textarea').setup({
	    pretty_break: true, // enable formatted line breaks (when inserting 
			            // between opening and closing tag) 
	    use_tab: true       // expand abbreviations by Tab key
    });*/
</script>-->