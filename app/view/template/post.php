<div id="cnt" class="pngf">

    <!-- Left Column -->
    <div id="lcnt">

        <!-- Post -->
        <div class="post">

            <!-- Post Date -->
            <dl class="date">
                <dt>
                    <span><?= $post['data'][2]; ?></span>
                </dt>
                <dd>
                    <span><?= $post['data'][1]; ?></span>
                </dd>
                <dd>
                    <span><?= $post['data'][0]; ?></span>
                </dd>
            </dl>

            <!-- Post Title - Permalink -->
            <h3 class="pngf post-name">
              <?=$post['name']; ?>

                <!-- Post Details -->
                <span class="pngf"><?=$post['author']; ?></span>
            </h3>

            <!-- Post Content -->
            <div style="float: none;width: 62px;height: 55px;"></div>

            <pre style="white-space: pre-line;">
              <p> <?=$post['description']; ?></p>
            </pre>

        </div>
            <?php if($post['leanch']){?>
        <div class="cmt_nu pngf"><?=$post['leanch']; ?></div>
        <?php }?>
        <div id="comments">
<?php $key = 1; foreach($comments as $val) {?>
            <div class="comment">

                <div class="cmmnt_hdr">

                    <p><?=$key.'. '.$val['from']; ?></p>
                    <span class="cmmnt_time"><?=$val['data']; ?></span>

                </div>

                <div class="cmmnt_txt">
                    <div class="hbar pngf"></div>
                    <?=$val['article']; ?>
                </div>

            </div>
<?php $key++; }?>


            <!-- Comment Form -->
            <form name="add_comment" action="#" method="post" id="cmntfrm">
                <input type="hidden" name="post" value="<?=$post['id']; ?>">
                <div id="cmntfs">

                    <div class="pyct pngf"></div>

                    <p><input type="text" name="author" size="22" tabindex="1" id="author" value="" required pattern="^[A-Za-zА-Яа-я0-9,\.\(\)\?\-\s]{2,100}$"><label>Author <span>(required)</span></label></p>
                    <p>
                        <textarea name="comment" cols="64" rows="10" tabindex="4" id="author"  required pattern="^[A-Za-zА-Яа-я0-9,\.\(\)\?\-\s]{2,}$">Comment</textarea>
                    </p>
                    <p>
                        <button type="button"  tabindex="5" id="submit">Post comment</button>
                    </p>
                </div>
            </form>

        </div>

    </div>


    <br style="clear:both;">

</div>
<script>
    document.getElementById('submit').onclick = function () {
        var formData = new FormData(document.forms.add_comment);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", '/save-comment', true);
        xhr.send(formData);
        xhr.onload = function () {
            if (parseInt(xhr.status) == 200) {
                if (/^[\],:{}\s]*$/.test(xhr.responseText.replace(/\\["\\\/bfnrtu]/g, '@').
                        replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
                        replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                    var data =  JSON.parse(xhr.responseText);
                    if (data.error_code == 0) {
                        window.location.href = data.data['url'];
                    } else {
                        console.log(data);
                    }
                } else {
                    return {error_code: 1, error_desc: 'not correct parse json', data: xhr.responseText};
                }

            }
        };
    }
</script>