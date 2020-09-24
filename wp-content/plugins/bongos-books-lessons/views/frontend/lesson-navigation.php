<div class="lesson-navigation">
    <?php if ($previous) : ?>
        <a href="<?= get_permalink($previous->ID) ?>" class="lesson-navigation-item previous">
            Previous: <span class="lesson-title"><?= $previous->post_title ?></span>
        </a>
    <?php endif; ?>

    <a href="<?= get_permalink($char_id[0]) ?>" class="lesson-navigation-item view-all">View All <?= get_the_title($char_id[0]) ?>'s Lessons</a>

    <?php if ($next) : ?>
        <a href="<?= get_permalink($next->ID) ?>" class="lesson-navigation-item next">
            Next: <span class="lesson-title"><?= $next->post_title ?></span>
        </a>
    <?php endif; ?>
</div>