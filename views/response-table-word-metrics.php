<table class="pure-table">
    <thead>
        <tr>
            <th>Keyword</th>
            <th>CPC</th>
            <th>Competition</th>
            <th>Number of Results</th>
            <th>Search Volume</th>
        </tr>
    </thead>
    <?php foreach($data as $item): ?>
    <tr>
        <td><strong><?php echo $item['Keyword']; ?></strong></td>
        <td><?php echo $item['CPC']; ?></td>
        <td><?php echo $item['Competition']; ?></td>
        <td><?php echo $item['Number of Results']; ?></td>
        <td><?php echo $item['Search Volume']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
