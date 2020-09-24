<?php
/**
 * Template Name: Character Page
 */

use TMProd\Base\Extras as Extras;
use TMProd\Base\Assets as Assets;

?>

<?php while (have_posts()) : the_post(); ?>
    <section class="internal-lesson-slider">
        <h2>Follow along with <?php echo Extras\get_page_title(); ?></h2>
        <div class="lesson-blocks">
            <div class="lesson" style="background-image: url('<?php echo Assets\asset_path('images/lessons/globe-monkeys.jpg'); ?>');">
                <h4>Lesson 1</h4>
            </div>
            <div class="lesson" style="background-image: url('<?php echo Assets\asset_path('images/lessons/fishing-monkeys.jpg'); ?>');">
                <h4>Lesson 2</h4>
            </div>
            <div class="lesson" style="background-image: url('<?php echo Assets\asset_path('images/lessons/bus-monkeys.jpg'); ?>');">
                <h4>Lesson 3</h4>
            </div>
        </div>
    </section>
<?php endwhile; ?>
