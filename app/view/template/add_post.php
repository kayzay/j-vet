<!-- Main Container -->
<div id="cnt" class="pngf">
    <div id="form_add">
        <div class="post">
            <h1>New post</h1>
            <form action="<?=$this->url[4]; ?>" method="post" id="cmntfrm">
                <div id="cmntfs">
                    <p><label>Post name <span>(required)</label></p>
                    <p><input type="text" name="post_name" size="22" tabindex="1" id="author" required pattern="^[A-Za-zА-Яа-я0-9,\.\(\)\?\-\s]{2,100}$"></p>
                    <p><label>Author <span>(required)</label></p>
                    <p><input type="text" name="author" size="22" tabindex="2" id="email" required pattern="^[A-Za-zА-Яа-я0-9,\.\(\)\?\-\s]{2,100}$"></p>
                    <p><label>Article <span>(required)</label></p>
                    <p>
                        <textarea name="article" cols="64" rows="10" tabindex="4" id="comment" required pattern="^[A-Za-zА-Яа-я0-9,\.\?\(\)\-\s]{2,}$"></textarea>
                    </p>
                    <p>
                        <input type="submit" value="Post comment" tabindex="5" id="submit">
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>