<boson-footer>
    <a class="social" href="https://github.com/boson-php/boson" target="_blank" slot="main-link">
        <img src="/images/icons/github.svg" alt="Visit Boson PHP on GitHub" loading="lazy"/>
    </a>

    <a class="social" href="https://discord.gg/vCg52Jdwvc" target="_blank" slot="main-link">
        <img src="/images/icons/discord.svg" alt="Join Boson PHP Discord community" loading="lazy"/>
    </a>

    <a class="social" href="https://t.me/boson_php" target="_blank" slot="main-link">
        <img src="/images/icons/telegram.svg" alt="Follow Boson PHP on Telegram" loading="lazy"/>
    </a>

    <!-- TODO: Implement documentation routes -->
    <!-- <?php if ($docsVersion ?? null): ?>
    <a href="<?= $this->url('doc.show', ['version' => $docsVersion->getName(), 'page' => 'introduction']) ?>" slot="aside-link">
        Get started
    </a>
    <?php endif; ?>

    <!-- TODO: Add documentation link when routes are implemented -->

    <?php if ($docsVersion ?? null): ?>
    <a href="<?= $this->url('doc.show', ['version' => $docsVersion->getName(), 'page' => 'contribution']) ?>" slot="secondary-link">
        Contribution Guide
    </a>

    <a href="<?= $this->url('doc.show', ['version' => $docsVersion->getName(), 'page' => 'license']) ?>" slot="secondary-link">
        License
    </a>

    <a href="<?= $this->url('doc.show', ['version' => $docsVersion->getName(), 'page' => 'release-notes']) ?>" slot="secondary-link">
        Release Notes
    </a>
    <?php endif; ?> -->

    <small slot="copyright">
        BOSON PHP © 2025. All Rights Reversed.
    </small>
</boson-footer>
