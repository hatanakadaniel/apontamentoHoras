<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Data</th>
            <?php for ($i=0; $i < $numMaxPointsMonth; $i++) : ?>
            <th>
                <?php if ($i%2 == 0) : ?>
                    Entrada
                <?php else : ?>
                    Saída
                <?php endif; ?>
            </th>
            <?php endfor; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        
        <?php foreach ($pointsMonthFormated as $pointDay) : ?>
        <tr>
            <td><?php echo $pointDay->dayOfMonth; ?></td>
            <?php for ($i=0; $i < $numMaxPointsMonth; $i++) : ?>
                <td><?php echo isset($pointDay->dayPoints)&&!empty($pointDay->dayPoints)&&key_exists($i, $pointDay->dayPoints)?$pointDay->dayPoints[$i]:'-' ?></td>
            <?php endfor; ?>
            <td><?php echo $pointDay->totalHour; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <?php for ($i=0; $i < $numMaxPointsMonth; $i++) : ?>
            <td></td>
            <?php endfor; ?>
            <td>Total</td>
            <td><?php echo $totalHoursMonth; ?></td>
        </tr>
    </tfoot>
</table>