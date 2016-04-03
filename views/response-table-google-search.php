<table class="pure-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>URL</th>
        </tr>
    </thead>
    <?php foreach($data as $item): ?>
    <tr>
        <td><strong><?php echo $item['title']; ?></strong></td>
        <td>
            <p><a href="<?php echo $item['url']; ?>" target="_blank">link</a></p>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
