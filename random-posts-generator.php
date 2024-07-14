<?php
/*
Plugin Name: Random Posts Generator
Description: Generates a specified number of posts with random titles and content when the plugin is activated.
Version: 1.1
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// User-defined variables
define('NUM_POSTS', 50); // Number of posts to create
define('POST_CONTENT_WORD_COUNT', 500); // Number of words in the post content
define('BATCH_SIZE', 100); // Number of posts to create per batch

function generate_random_posts($num_posts, $word_count) {
    $adjectives = array('Amazing', 'Incredible', 'Fantastic', 'Unbelievable', 'Remarkable', 'Astounding', 'Inspiring', 'Mysterious', 'Exciting', 'Extraordinary', 'Stunning', 'Dramatic', 'Phenomenal', 'Intriguing', 'Enchanting', 'Thrilling', 'Marvelous', 'Spectacular', 'Gripping', 'Mesmerizing', 'Breathtaking', 'Unique', 'Captivating', 'Electrifying', 'Spellbinding', 'Heartwarming', 'Unforgettable', 'Fascinating', 'Charming', 'Engaging', 'Remarkable', 'Powerful', 'Motivating', 'Surprising', 'Entertaining', 'Hilarious', 'Mind-blowing');
    $nouns = array('Post', 'Story', 'News', 'Update', 'Event', 'Insight', 'Revelation', 'Discovery', 'Fact', 'Tale', 'Occurrence', 'Turn', 'Adventure', 'Outcome', 'Visuals', 'Result', 'Twist', 'Achievement', 'Mystery', 'Story', 'Experience', 'Moment', 'Scene', 'Tale', 'Happenings', 'View', 'Performance', 'Experience', 'Journey', 'Show', 'Event', 'Story', 'Moment', 'Story', 'Anecdote', 'Article', 'Feat', 'Message', 'Story', 'Journey', 'Discovery', 'Fact', 'Insight', 'Story', 'Incident', 'Fact');
    $verbs = array('Amazing', 'Incredible', 'Breaking', 'Fantastic', 'Unbelievable', 'Latest', 'Shocking', 'Remarkable', 'Astounding', 'Inspiring', 'Mysterious', 'Surprising', 'Exciting', 'Wonderful', 'Extraordinary', 'Unpredictable', 'Stunning', 'Unexpected', 'Dramatic', 'Phenomenal', 'Intriguing', 'Enchanting', 'Thrilling', 'Jaw-dropping', 'Marvelous', 'Spectacular', 'Gripping', 'Unusual', 'Mesmerizing', 'Breathtaking', 'Unique', 'Captivating', 'Electrifying', 'Spellbinding', 'Heartwarming', 'Unforgettable', 'Fascinating', 'Charming', 'Engaging', 'Remarkable', 'Powerful', 'Motivating', 'Incredible', 'Amazing', 'Surprising', 'Interesting', 'Entertaining', 'Hilarious', 'Mind-blowing');

    $site_url = get_site_url();

    $read_more_block = '
<!-- wp:dmg/read-more {"postId":1,"postTitle":"Hello world!","postUrl":"' . $site_url . '/?p=1"} -->
<p class="wp-block-dmg-read-more dmg-read-more">Read More: <a href="' . $site_url . '/?p=1">Hello world!</a></p>
<!-- /wp:dmg/read-more -->';

    $content = 'This is a random post content. ' . implode(' ', array_fill(0, $word_count, 'word'));

    for ($i = 0; $i < $num_posts; $i++) {
        $random_title = $adjectives[array_rand($adjectives)] . ' ' . $verbs[array_rand($verbs)] . ' ' . $nouns[array_rand($nouns)] . ' ' . rand(1000, 9999);

        $post_data = array(
            'post_title'    => $random_title,
            'post_content'  => $content . $read_more_block,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array(1)
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            error_log('Post creation failed: ' . $post_id->get_error_message());
        } else {
            error_log('Post created successfully: ' . $post_id);
        }

        if (($i + 1) % BATCH_SIZE == 0) {
            sleep(1); // Pause for 1 second every BATCH_SIZE posts to avoid timeout
        }
    }
}

function random_posts_generator_activation() {
    generate_random_posts(NUM_POSTS, POST_CONTENT_WORD_COUNT);
}

// Hook into the activation action
register_activation_hook(__FILE__, 'random_posts_generator_activation');
?>
