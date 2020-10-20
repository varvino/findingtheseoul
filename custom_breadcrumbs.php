<?php

function custom_breadcrumbs()
{

    // Settings
    $separator = '<svg class="separator__image" width="9" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M.023 15.273L7.29 8 .023.727.727.023 8.71 8 .727 15.977l-.704-.704z" fill="currentColor"/></svg>';
    $breadcrumbs_class = 'breadcrumbs';
    $home_title = 'Home';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy = 'product_cat';

    // Get the query & post information
    global $post, $wp_query;

    // Do not display on the homepage
    if (!is_front_page()) {

        // Build the breadcrumbs
        echo '<div class="' . $breadcrumbs_class . '">';
        echo '<div class="container">';

        // Home page
        echo '<div class="item--home"><a class="breadcrumb--home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></div>';
        echo '<div class="separator separator-home"> ' . $separator . ' </div>';

        if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

            echo '<div class="item--current item--archive">
        <div class="breadcrumb--current breadcrumb--archive">' . post_type_archive_title(null, false) . '</div>
    </div>';
        } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<div class="item--cat item--custom-post-type-' . $post_type . '"><a class="breadcrumb--cat breadcrumb--custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></div>';
                echo '<div class="separator"> ' . $separator . ' </div>';
            }

            $custom_tax_name = get_queried_object()->name;
            echo '<div class="item--current item--archive">
        <div class="breadcrumb--current breadcrumb--archive">' . $custom_tax_name . '</div>
    </div>';
        } else if (is_single()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<div class="item--cat item--custom-post-type-' . $post_type . '"><a class="breadcrumb--cat breadcrumb--custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></div>';
                echo '<div class="separator"> ' . $separator . ' </div>';
            }

            // Get post category info
            $category = get_the_category();

            if (!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    $cat_display .= '<div class="item--cat">' . $parents . '</div>';
                    $cat_display .= '<div class="separator"> ' . $separator . ' </div>';
                }
            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                $cat_id = $taxonomy_terms[0]->term_id;
                $cat_nicename = $taxonomy_terms[0]->slug;
                $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name = $taxonomy_terms[0]->name;
            }

            // Check if the post is in a category
            if (!empty($last_category)) {
                echo $cat_display;
                echo '<div class="item--current item--' . $post->ID . '">
        <div class="breadcrumb--current breadcrumb--' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</div>
    </div>';

                // Else if post is in a custom taxonomy
            } else if (!empty($cat_id)) {

                echo '<div class="item--cat item--cat-' . $cat_id . ' item--cat-' . $cat_nicename . '"><a class="breadcrumb--cat breadcrumb--cat-' . $cat_id . ' breadcrumb--cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></div>';
                echo '<div class="separator"> ' . $separator . ' </div>';
                echo '<div class="item--current item--' . $post->ID . '">
        <div class="breadcrumb--current breadcrumb--' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</div>
    </div>';
            } else {

                echo '<div class="item--current item--' . $post->ID . '">
        <div class="breadcrumb--current breadcrumb--' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</div>
    </div>';
            }
        } else if (is_category()) {

            // Category page
            echo '<div class="item--current item--cat">
        <div class="breadcrumb--current breadcrumb--cat">' . single_cat_title('', false) . '</div>
    </div>';
        } else if (is_page()) {

            // Standard page
            if ($post->post_parent) {

                // If child page, get parents
                $anc = get_post_ancestors($post->ID);

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if (!isset($parents)) $parents = null;
                foreach ($anc as $ancestor) {
                    $parents .= '<div class="item--parent item--parent-' . $ancestor . '"><a class="breadcrumb--parent breadcrumb--parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></div>';
                    $parents .= '<div class="separator separator-' . $ancestor . '"> ' . $separator . ' </div>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<div class="item--current item--' . $post->ID . '">
        <div title="' . get_the_title() . '"> ' . get_the_title() . '</div>
    </div>';
            } else {

                // Just display current page if not parents
                echo '<div class="item--current item--' . $post->ID . '">
        <div class="breadcrumb--current breadcrumb--' . $post->ID . '"> ' . get_the_title() . '</div>
    </div>';
            }
        } else if (is_tag()) {

            // Tag page

            // Get tag information
            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms($taxonomy, $args);
            $get_term_id = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;

            // Display the tag name
            echo '<div class="item--current item--tag-' . $get_term_id . ' item--tag-' . $get_term_slug . '">
        <div class="breadcrumb--current breadcrumb--tag-' . $get_term_id . ' breadcrumb--tag-' . $get_term_slug . '">' . $get_term_name . '</div>
    </div>';
        } elseif (is_day()) {

            // Day archive

            // Year link
            echo '<div class="item--year item--year-' . get_the_time('Y') . '"><a class="breadcrumb--year breadcrumb--year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></div>';
            echo '<div class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </div>';

            // Month link
            echo '<div class="item--month item--month-' . get_the_time('m') . '"><a class="breadcrumb--month breadcrumb--month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></div>';
            echo '<div class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </div>';

            // Day display
            echo '<div class="item--current item--' . get_the_time('j') . '">
        <div class="breadcrumb--current breadcrumb--' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</div>
    </div>';
        } else if (is_month()) {

            // Month Archive

            // Year link
            echo '<div class="item--year item--year-' . get_the_time('Y') . '"><a class="breadcrumb--year breadcrumb--year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></div>';
            echo '<div class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </div>';

            // Month display
            echo '<div class="item--month item--month-' . get_the_time('m') . '">
        <div class="breadcrumb--month breadcrumb--month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</div>
    </div>';
        } else if (is_year()) {

            // Display year archive
            echo '<div class="item--current item--current-' . get_the_time('Y') . '">
        <div class="breadcrumb--current breadcrumb--current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</div>
    </div>';
        } else if (is_author()) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata($author);

            // Display author name
            echo '<div class="item--current item--current-' . $userdata->user_nicename . '">
        <div class="breadcrumb--current breadcrumb--current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</div>
    </div>';
        } else if (get_query_var('paged')) {

            // Paginated archives
            echo '<div class="item--current item--current-' . get_query_var('paged') . '">
        <div class="breadcrumb--current breadcrumb--current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">' . __('Page') . ' ' . get_query_var('paged') . '</div>
    </div>';
        } else if (is_search()) {

            // Search results page
            echo '<div class="item--current item--current-' . get_search_query() . '">
        <div class="breadcrumb--current breadcrumb--current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</div>
    </div>';
        } elseif (is_404()) {

            // 404 page
            echo '<div>' . '404' . '</div>';
        }

            echo '</div>';
        echo '</div>';
    }
}
