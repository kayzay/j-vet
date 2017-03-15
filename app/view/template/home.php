<!-- Main Container -->
<div id="cnt" class="pngf">
    <!-- Left Column -->
    <div id="lcnt">
        <div class="post">

            <h1>Populars</h1>  <hr/>
            <div id="demo4" class="scroll-text">
                <ul>
                    <?php foreach ($popular as $post){ $post['data'] = explode('-', $post['data']); ?>
                    <li>
                        <div class="post">
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
                            <h3 class="pngf">
                                <a href="<?=$this->url[5] .'/'. $post['id']; ?>"><?=$post['name']; ?></a><br />
                                <span class="pngf"><?=$post['author']; ?></span>
                            </h3>
                            <div class="bl"><?=$post['leanch']; ?></div>
                            <p>
                                <?=substr($post['description'], 0, 100); ?>
                            </p>
                            <a class="more-link pngf" href="<?=$this->url[5] .'/'. $post['id']; ?>"></a>
                            <hr />
                        </div>
                    </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
        <h2>Post</h2>
        <hr/>
    <?php foreach ($all_post as $post){ $post['data'] = explode('-', $post['data']); ?>
      <div class="post">
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
        <h3 class="pngf">
            <a href="<?=$this->url[5] .'/'. $post['id']; ?>"><?=$post['name']; ?></a><br />
            <span class="pngf"><?=$post['author']; ?></span>
        </h3>
        <div class="bl"><?=$post['leanch']; ?></div>
        <p>
            <?=substr($post['description'], 0, 100); ?>
        </p>
        <a class="more-link pngf" href="<?=$this->url[5] .'/'. $post['id']; ?>"></a>
        <hr />
      </div>
     <?php } ?>
    </div>
 <br style="clear:both;"/>

</div>
<script>$(function () {
        $('#demo4').scrollbox();
    });
</script></script>