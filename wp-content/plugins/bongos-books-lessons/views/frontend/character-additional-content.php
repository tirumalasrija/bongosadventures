<div class="page-wrap additional-content">
    <div class="container">
        <div class="character-additional-content">
            <div class="character-additional-content-navigation">
                <ul>
                    <li style="background-color: <?= $color ?>; ">
                        <a href="javascript:void(0)" class="content-display-link" data-target="moreAbout">
                            More About <?= $post->post_title ?>
                        </a>
                    </li>
                    <li style="background-color: <?= $color ?>">
                        <a href="javascript:void(0)" class="content-display-link" data-target="loves">
                            Things <?= $post->post_title ?> Loves
                        </a>
                    </li>
                    <li style="background-color: <?= $color ?>">
                        <a href="javascript:void(0)" class="content-display-link" data-target="dislikes">
                            Things <?= $post->post_title ?> Dislikes
                        </a>
                    </li>

                </ul>
            </div>
            <div class="character-additional-content-display">
                <div class="content-item" id="moreAbout">
                    <?= wpautop($character_more) ?>
                </div>
                <div class="content-item" id="loves">
                    <?= wpautop($character_likes) ?>
                </div>
                <div class="content-item" id="dislikes">
                    <?= wpautop($character_dislikes) ?>
                </div>
            </div>
        </div>
    </div>
</div>