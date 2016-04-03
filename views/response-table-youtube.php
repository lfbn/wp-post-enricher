<table class="pure-table">
    <thead>
        <tr>
            <th>Thumbnail</th>
            <th>Title</th>
            <th>Options</th>
        </tr>
    </thead>
    <?php foreach($data as $item): ?>
    <?php
        $embedCode = '<iframe width="426" height="240" src="https://www.youtube.com/embed/'.$item['id'].'" frameborder="0" allowfullscreen></iframe>';
    ?>
    <tr>
        <td><?php echo $embedCode; ?></td>
        <td><strong><?php echo $item['title']; ?></strong></td>
        <td>
            <p>
                <textarea title="Youtube video embed code" class="wppe-youtube-embedcode" rows="3" cols="40" readonly>
                    <?php echo $embedCode; ?>
                </textarea>
                <br />
                <small>copy & paste embed code</small>
            </p>
            <p>
                <a href="https://www.youtube.com/watch?v=<?php echo $item['id']; ?>" target="_blank">
                    watch on Youtube
                </a>
            </p>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<script type="application/javascript">
    jQuery("textarea.wppe-youtube-embedcode").on("click", function () {
        jQuery(this).select();
    });
</script>