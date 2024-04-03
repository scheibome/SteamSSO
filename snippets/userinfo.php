<?php if ($kirby->user()): ?>
<div class="steamsso-userinfo">
    <?php if ($kirby->user()->content()->avatar()): ?>
        <div class="steamsso-userinfo__avatar">
            <img src="<?= $kirby->user()->content()->avatar() ?>" alt="Avatar von <?= $kirby->user()->name() ?>" height="184" width="184">
        </div>
    <?php endif ?>
    <div class="steamsso-userinfo__name"><?= $kirby->user()->name() ?></div>
    <!-- SteamiD: <?= $kirby->user()->content()->steamid() ?> -->
    <!-- SteamProfilUrl: <?= $kirby->user()->content()->profileUrl() ?> -->
</div>
<?php endif ?>
