<table class="pure-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Tweet</th>
        </tr>
    </thead>
    <?php foreach($data as $item): ?>
    <tr>
        <td><strong><?php echo $item['user']; ?></strong></td>
        <td><?php echo $item['text']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
