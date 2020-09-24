function filterLessons() {
    var category = jQuery('.category-filter.active');
    var selectedCat = category.attr('data-category-id');
    var selectedCatLink = category.attr('data-category-link');
    var selectedCatName = category.text();
    var categoryLink = jQuery('.current-category-link');

    if(selectedCat.length === 0) {
        return;
    }

    categoryLink.find('span').html(selectedCatName);
    categoryLink.attr('href', selectedCatLink);

    jQuery('.category-lesson-blocks .lesson').each(function() {
        var categories = jQuery(this).attr('data-categories').split(",");

        if(selectedCat !== '' && categories.indexOf(selectedCat) === -1) {
            jQuery(this).hide();
        } else {
            jQuery(this).show();
        }
    });
}

jQuery(function() {
    jQuery('.category-filter').on('click', function() {
        jQuery('.category-filter').removeClass('active');
        jQuery(this).addClass('active');

        filterLessons();
    });

    filterLessons();
});