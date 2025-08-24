<boson-header>
    <boson-button class="logo" type="ghost" slot="logo" href="<?= $this->url('home') ?>">
        <img class="logo" src="/images/logo.svg" alt="logo" width="255" height="100" />
    </boson-button>

    <boson-dropdown>
        <boson-button type="ghost" slot="summary"
            href="/docs">
            References
        </boson-button>

        <boson-button type="ghost" href="/docs/latest/introduction">
            <img src="/images/icons/book.svg" width="16" height="16" alt="" aria-hidden="true" />
            Introduction
        </boson-button>

        <boson-button type="ghost" href="/docs/latest/installation">
            <img src="/images/icons/download.svg" width="16" height="16" alt="" aria-hidden="true" />
            Installation
        </boson-button>

        <boson-button type="ghost" href="/docs/latest/getting-started">
            <img src="/images/icons/play.svg" width="16" height="16" alt="" aria-hidden="true" />
            Getting Started
        </boson-button>
    </boson-dropdown>

    <boson-dropdown>
        <boson-button type="ghost" slot="summary"
            href="/blog">
            Blog
        </boson-button>

        <?php foreach ($blogCategories as $category): ?>
            <boson-button type="ghost" href="/blog/category/<?= $this->escapeHtml($category) ?>">
                <?= $this->escapeHtml(ucfirst($category)) ?>
            </boson-button>
        <?php endforeach; ?>
    </boson-dropdown>

    <!-- Search input -->
    <boson-search-input
        action="/search"
        query="<?= $this->escapeHtml($_GET['q'] ?? '') ?>">
    </boson-search-input>

    <boson-button type="ghost" slot="aside" external href="https://github.com/boson-php/boson" pc="true">
        <img src="/images/icons/github.svg" alt="github"/>
        GitHub
    </boson-button>

    <boson-button type="ghost" slot="aside" external href="https://github.com/boson-php/boson" mobile="true">
        <img src="/images/icons/github.svg" alt="github"/>
    </boson-button>

    <boson-button type="ghost" slot="aside" href="/docs/latest/installation">
        Get Started
        <img src="/images/icons/arrow_up_right.svg" alt="arrow_up_right" />
    </boson-button>

    <mobile-header-menu slot="mobile-menu">
        <div slot="references">
            <boson-button type="ghost" inheader="true" slot="references" href="/docs/latest/introduction">
                <img src="/images/icons/book.svg" width="16" height="16" alt="" aria-hidden="true" />
                Introduction
            </boson-button>

            <boson-button type="ghost" inheader="true" slot="references" href="/docs/latest/installation">
                <img src="/images/icons/download.svg" width="16" height="16" alt="" aria-hidden="true" />
                Installation
            </boson-button>

            <boson-button type="ghost" inheader="true" slot="references" href="/docs/latest/getting-started">
                <img src="/images/icons/play.svg" width="16" height="16" alt="" aria-hidden="true" />
                Getting Started
            </boson-button>
        </div>

        <div slot="blog">
            <?php foreach ($blogCategories as $category): ?>
                <boson-button type="ghost" inheader="true" slot="blog" href="/blog/category/<?= $this->escapeHtml($category) ?>">
                    <?= $this->escapeHtml(ucfirst($category)) ?>
                </boson-button>
            <?php endforeach; ?>
        </div>

        <div slot="actions" class="menu-section">
            <boson-button type="ghost" external href="https://github.com/boson-php/boson">
                <img src="/images/icons/github.svg" alt="github"/>
                GitHub
            </boson-button>

            <?php if ($docsVersion): ?>
            <boson-button type="ghost" href="<?= $this->url('doc.show', [
                'version' => $docsVersion->getName(),
                'page' => 'introduction'
            ]) ?>">
                Get Started
                <img src="/images/icons/arrow_up_right.svg" alt="arrow_up_right" />
            </boson-button>
            <?php endif; ?>
        </div>

        <div slot="search" class="menu-section">
            <boson-search-input
                action="/search"
                query="<?= $this->escapeHtml($_GET['q'] ?? '') ?>">
            </boson-search-input>
        </div>
    </mobile-header-menu>
</boson-header>
