<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>

<div id="app" class="demo">
    <button-counter></button-counter>
    <button-counter></button-counter>
    <button-counter></button-counter>


    <blog-post @enlarge-text="postFontSize += 0.1"></blog-post>

    <section class="o1">
        <h2>с увеличением</h2>
        <div :style="{ fontSize: postFontSize + 'em' }">
            <blog-post
                v-for="post in posts"
                :key="post.id"
                :title="post.title"
            ></blog-post>
        </div>
    </section>


    <section class="o2">
        <h2>без увеличения</h2>
        <blog-post
            v-for="post in posts"
            :key="post.id"
            :title="post.title"
        ></blog-post>
    </section>

</div>