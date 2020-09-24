<div class="cat-bar">
    <?php

    foreach ($subjects as $subject) {
        $color = rwmb_meta('_bongosbooks_subject_category_color', array('object_type' => 'term'), $subject->term_id);

        echo '<li style="background-color:' . $color . '"><a href="javascript:void(0)" 
            class="category-filter ' . $subject->slug . '" 
            data-category-link="' . get_term_link($subject->term_id) . '"
            data-category-id="' . $subject->term_id . '">'
            . $subject->name
            . '</a></li>';
    }

    ?>
</div>