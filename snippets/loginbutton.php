<?php if (!$kirby->user()): ?>
    <a class="steamsso-button" href="<?= url('steam-login') ?>"><?= t('steamsso.login.button') ?></a>
<?php endif ?>
