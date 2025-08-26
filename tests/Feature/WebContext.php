<?php

declare(strict_types=1);

namespace Tests\Feature;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Boson\Shared\Infrastructure\Database;
use Exception;

use function count;

class WebContext extends MinkContext implements Context
{
    private Database $database;

    public function __construct()
    {
        $this->database = createTestDatabase();
    }

    /**
     * @BeforeScenario
     */
    public function setUp(): void
    {
        cleanTestDatabase($this->database);
        createTestUser($this->database);
    }

    /**
     * @Given I am on the homepage
     */
    public function iAmOnTheHomepage(): void
    {
        $this->visitPath('/');
    }

    /**
     * @Given I am on the blog page
     */
    public function iAmOnTheBlogPage(): void
    {
        $this->visitPath('/blog');
    }

    /**
     * @Given I am on the search page
     */
    public function iAmOnTheSearchPage(): void
    {
        $this->visitPath('/search');
    }

    /**
     * @Then I should see the main navigation
     */
    public function iShouldSeeTheMainNavigation(): void
    {
        $this->assertElementOnPage('nav');
        $this->assertElementContainsText('nav', 'Home');
        $this->assertElementContainsText('nav', 'Blog');
        $this->assertElementContainsText('nav', 'Docs');
    }

    /**
     * @Then I should see the hero section
     */
    public function iShouldSeeTheHeroSection(): void
    {
        $this->assertElementOnPage('.hero-section');
        $this->assertElementContainsText('.hero-section', 'Go Native. Stay PHP');
    }

    /**
     * @Then I should see the footer
     */
    public function iShouldSeeTheFooter(): void
    {
        $this->assertElementOnPage('footer');
    }

    /**
     * @Then the page should be responsive
     */
    public function thePageShouldBeResponsive(): void
    {
        // Check for responsive meta tag
        $this->assertElementOnPage('meta[name="viewport"]');

        // Check for responsive CSS classes
        $this->assertElementOnPage('.container');
    }

    /**
     * @Then the page should have proper SEO meta tags
     */
    public function thePageShouldHaveProperSeoMetaTags(): void
    {
        $this->assertElementOnPage('title');
        $this->assertElementOnPage('meta[name="description"]');
        $this->assertElementOnPage('meta[property="og:title"]');
        $this->assertElementOnPage('meta[property="og:description"]');
    }

    /**
     * @Then the page should load within :seconds seconds
     */
    public function thePageShouldLoadWithinSeconds(int $seconds): void
    {
        $startTime = microtime(true);
        $this->getSession()->reload();
        $endTime = microtime(true);

        $loadTime = $endTime - $startTime;

        if ($loadTime > $seconds) {
            throw new Exception("Page loaded in {$loadTime}s, expected under {$seconds}s");
        }
    }

    /**
     * @Then I should see security headers
     */
    public function iShouldSeeSecurityHeaders(): void
    {
        $headers = $this->getSession()->getResponseHeaders();

        $expectedHeaders = [
            'X-Content-Type-Options',
            'X-Frame-Options',
            'X-XSS-Protection',
            'Referrer-Policy',
        ];

        foreach ($expectedHeaders as $header) {
            if (!isset($headers[$header])) {
                throw new Exception("Missing security header: {$header}");
            }
        }
    }

    /**
     * @When I click on :linkText
     */
    public function iClickOn(string $linkText): void
    {
        $this->clickLink($linkText);
    }

    /**
     * @When I fill in :field with :value
     */
    public function iFillInWith(string $field, string $value): void
    {
        $this->fillField($field, $value);
    }

    /**
     * @When I press :button
     */
    public function iPress(string $button): void
    {
        $this->pressButton($button);
    }

    /**
     * @Then I should be on :path
     */
    public function iShouldBeOn(string $path): void
    {
        $this->assertPageAddress($path);
    }

    /**
     * @Then I should see :text
     */
    public function iShouldSee(string $text): void
    {
        $this->assertPageContainsText($text);
    }

    /**
     * @Then I should not see :text
     */
    public function iShouldNotSee(string $text): void
    {
        $this->assertPageNotContainsText($text);
    }

    /**
     * @Then I should see :count items
     */
    public function iShouldSeeItems(int $count): void
    {
        $elements = $this->getSession()->getPage()->findAll('css', '.item, .post, .result');

        if (count($elements) !== $count) {
            throw new Exception("Expected {$count} items, found " . count($elements));
        }
    }

    /**
     * @Then the response status code should be :code
     */
    public function theResponseStatusCodeShouldBe(int $code): void
    {
        $actualCode = $this->getSession()->getStatusCode();

        if ($actualCode !== $code) {
            throw new Exception("Expected status code {$code}, got {$actualCode}");
        }
    }
}
