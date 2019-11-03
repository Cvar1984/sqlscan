<?php
$count = count($images);

if ($count) {

    echo '<h4>Images: ' . $count . '</h4>';

    echo '<div class="row images">';

    foreach($images as $image) {
        echo '<img src="' . $image . '" />';
    }

    echo '</div>';
}