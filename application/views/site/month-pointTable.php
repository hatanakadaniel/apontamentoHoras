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
            <th></th>
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
            <td>
                <span class="<?php echo isset($pointDay->timeBalance)&&!empty($pointDay->timeBalance)&&$pointDay->timeBalance['inverted']?'bg-danger':(isset($pointDay->timeBalance)&&!empty($pointDay->timeBalance)&&!$pointDay->timeBalance['inverted']?'bg-sucess':'') ?>">
                    <?php echo isset($pointDay->timeBalance)&&!empty($pointDay->timeBalance)&&$pointDay->timeBalance['inverted']?'-':(isset($pointDay->timeBalance)&&!empty($pointDay->timeBalance)&&!$pointDay->timeBalance['inverted']?'+':'');?>
                    <?php echo isset($pointDay->timeBalance)&&!empty($pointDay->timeBalance)?$pointDay->timeBalance['interval']:'-'; ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <?php for ($i=0; $i < $numMaxPointsMonth; $i++) : ?>
            <td></td>
            <?php endfor; ?>
            <td>Total</td>
            <td><?php echo isset($totalHoursMonth)?$totalHoursMonth:'-'; ?></td>
            <td>
                <span class="<?php echo isset($timeBalance)&&!empty($timeBalance)&&$timeBalance['inverted']?'bg-danger':(isset($timeBalance)&&!empty($timeBalance)&&!$timeBalance['inverted']?'bg-sucess':'') ?>">
                    <?php echo isset($timeBalance)&&!empty($timeBalance)&&$timeBalance['inverted']?'-':(isset($timeBalance)&&!empty($timeBalance)&&!$timeBalance['inverted']?'+':'');?>
                    <?php echo isset($timeBalance)&&!empty($timeBalance)?$timeBalance['interval']:'-'; ?>
                </span>
            </td>
        </tr>
    </tfoot>
</table>