<table class="table">
    <thead>
        <tr>
            <th class="col-xs-3">Descrição</th>
            <th>Horário</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($points) && !empty($points)) : ?>
            <?php foreach ($points as $i => $point) : ?>
                <tr>
                    <td>
                        <?php if ($i%2 === 0) : ?>
                        Entrada
                        <?php else : ?>
                        Saída
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $point->hour; ?>
                    </td>
                    <?php if ($i%2 === 0 && isset($point->partial) && !empty($point->partial)) : ?>
                    <td rowspan="2">
                        Total: <?php echo $point->partial; ?>
                    </td>
                    <?php else : ?>
                        <?php if (($i%2 === 0) && !isset($point->partial)) : ?>
                            <td></td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right">Previsão de Saída (8H diárias)</td>
            <td class="text-primary"><?php echo $timeEstimate ?></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-right">Tempo Restante</td>
            <td class="text-primary"><?php echo $timeLeft ?></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-right">Tempo Total</td>
            <td class="text-primary"><?php echo $timeElapsed ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>