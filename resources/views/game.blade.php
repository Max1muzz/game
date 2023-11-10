<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Game</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center body1">
        <div class="col-6">

            <?php if (isset($result)): ?>


            <div class="row justify-content-center align-items-end mt-5">
                <div class="col-12 text-center mt-5">
                    <h4><?= $result ?></h4>
                </div>
            </div>

            <?php elseif (isset($score) && isset($lives) && isset($high_score)): ?>

            <div class="row justify-content-center align-items-end mt-5">
                <div class="col-6 text-end mt-5">
                    <h4>Score = <?= $score ?></h4>
                </div>
                <div class="col-6 text-start">
                    <h4>Lives = <?= $lives ?></h4>
                </div>
            </div>

            <div class="row justify-content-center m-2">
                <div class="col-12">
                    <div class="text-center">High score = <?= $high_score ?></div>
                </div>
            </div>

            <?php endif; ?>

            <?php if (isset($card)): ?>

            <div class="row h-50 justify-content-center align-items-center">
                <div class="col-5 h-100">
                    <div class="row justify-content-center align-items-center h-100 border shadow">
                        <div class="col-8">
                            <h1 class="text-center">
                                <?php if ($card['value'] == 'king'): ?>
                                K
                                <?php elseif ($card['value'] == 'queen'): ?>
                                Q
                                <?php elseif ($card['value'] == 'jack'): ?>
                                J
                                <?php else: ?>
                                    <?= $card['value'] ?>
                                <?php endif; ?>
                                <?php if ($card['suit'] == 'spades'): ?>
                                ♣︎
                                <?php elseif ($card['suit'] == 'hearts'): ?>
                                ♡︎
                                <?php elseif ($card['suit'] == 'clubs'): ?>
                                ♠︎
                                <?php elseif ($card['suit'] == 'diamonds'): ?>
                                ◇︎
                                <?php endif; ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif; ?>

            <?php if (!isset($result)): ?>

            <div class="row justify-content-center m-2">
                <div class="col-12">
                    <div class="text-center">
                        Will the next card be higher or lower than the one above?
                    </div>
                </div>
            </div>

            <div class="row justify-content-center m-2">
                <div class="col-4 text-end">
                    <a href="/higher" class="btn btn-primary">
                        higher
                    </a>
                </div>
                <div class="col-4 text-start">
                    <a href="/lower" class="btn btn-success">
                        lower
                    </a>
                </div>
            </div>

            <?php endif; ?>

            <div class="row justify-content-center m-4">
                <div class="col-6 text-center">
                    <a href="/shuffle" class="btn btn-warning btn-sm">
                        shuffle
                    </a>
                </div>
            </div>


        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
