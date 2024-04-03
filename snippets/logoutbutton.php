<?php if ($kirby->user()): ?>
    <a href="<?= url('steam-logout') ?>"><?= t('steamsso.logout.button') ?></a>
<?php endif ?>
