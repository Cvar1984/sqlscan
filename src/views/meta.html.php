<?php
if (is_array($meta_tags) && count($meta_tags)):
    echo '<h4>Meta Tags: ' . count($meta_tags) . '</h4>';
    ?>
    <table class="meta">
        <?php
        foreach ($meta_tags as $meta_tag):
            ?>
            <tr>
                <td><?= ucfirst($meta_tag[0]) ?></td>
                <td> : </td>
                <td><?= $meta_tag[1] ?></td>
            </tr>
        <?php
        endforeach;
        ?>
    </table>
<?php
endif;