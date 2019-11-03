<?php
if (count($links)) {
    $count = count($links);

    echo '<h4>Links: ' . $count . '</h4>';
    echo '<div class="row">';

    echo '<div class="span4">';
    echo "<ul>";

    $d = $count / 3;
    for ($i = 0; $i < $d; $i++) {
        echo '<li><a href="' . $links[$i][0] . '">' . $parser->truncateText($links[$i][1]) . '</a></li>';
    }
    echo '</div>';

    echo '<div class="span4">';
    echo "<ul>";
    for ($i = $d; $i < $d * 2; $i++) {
        echo '<li><a href="' . $links[$i][0] . '">' . $parser->truncateText($links[$i][1]) . '</a></li>';
    }
    echo '</div>';

    echo '<div class="span4">';
    echo "<ul>";
    for ($k = $i; $k < $count; $k++) {
        echo '<li><a href="' . $links[$k][0] . '">' . $parser->truncateText($links[$k][1]) . '</a></li>';
    }
    echo "</ul>";
    echo '</div>';
    echo '</div>';
}