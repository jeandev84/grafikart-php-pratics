<?php
require '../bootstrap/app.php';

$connection      = \App\Database\Connection\ConnectionFactory::make();
$eventRepository = new \App\Repository\EventsRepository($connection);
$events          = new \App\Service\Calendar\Events($eventRepository);
$month           = new \App\Service\Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$weeks           = $month->getWeeks();

$start   = $month->getStart();
$end     = (clone $start)->modify('+'. (6 + 7 * ($weeks - 1)).' days');

$events  = $events->getEventsBetweenByDay($start, $end);

render('header');
?>

<div class="container">
    <div class="calendar">

        <?php if (isset($_GET['success'])): ?>
            <div class="container">
                <div class="alert alert-success">
                    L' evenement a bien ete enregistre
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
            <h1><?= $month->toString() ?></h1>
            <div>
                <a href="<?= $month->previousMonthLink() ?>" class="btn btn-primary">&lt;</a>
                <a href="<?= $month->nextMonthLink() ?>" class="btn btn-primary">&gt;</a>
            </div>
        </div>

        <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
            <?php for ($i = 0; $i < $weeks; $i++): ?>
                <tr>
                    <?php
                    foreach ($month->days as $k => $day):
                        $date = (clone $start)->modify("+" . ($k + $i * 7) . " days");
                        $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                        ?>
                        <td class="<?= $month->withInMonth($date) ? '' : 'calendar__othermonth'?>">
                            <?php if ($i === 0): ?>
                                <div class="calendar__weekday"><?= $day ?></div>
                            <?php endif; ?>
                            <div class="calendar__day"><?= $date->format('d'); ?></div>
                            <?php foreach ($eventsForDay as $event): ?>
                                <div class="calendar__event">
                                    <?= (new DateTime($event['start_at']))->format('H:i') ?> -
                                    <a href="edit.php?id=<?= $event['id'] ?>"><?= h($event['name']) ?></a>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </table>


        <a href="add.php" class="calendar__button">+</a>

    </div>
</div>

<?php render('footer'); ?>

