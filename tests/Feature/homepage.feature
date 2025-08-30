Feature: Homepage
    As a visitor
    I want to view the homepage
    So that I can learn about Boson PHP

    Scenario: View homepage
        Given I am on the homepage
        Then I should see the main navigation
        And I should see the hero section
        And I should see "Go Native. Stay PHP"
        And I should see the footer
        And the page should be responsive
        And the page should have proper SEO meta tags

    Scenario: Homepage performance
        Given I am on the homepage
        Then the page should load within 2 seconds
        And I should see security headers

    Scenario: Navigation from homepage
        Given I am on the homepage
        When I click on "Blog"
        Then I should be on "/blog"
        And I should see "Blog"

    Scenario: Hero section call-to-action
        Given I am on the homepage
        When I click on "Try Boson For Free"
        Then I should be on "/docs/latest/installation"

    Scenario: Features section visibility
        Given I am on the homepage
        Then I should see "Native Performance"
        And I should see "Cross-Platform"
        And I should see "Rich API"
        And I should see "Easy Development"

    Scenario: Testimonials section
        Given I am on the homepage
        Then I should see "What developers say"
        And I should see testimonials with ratings

    Scenario: Call-to-action section
        Given I am on the homepage
        Then I should see "Get started right now"
        And I should see "Try Boson For Free"
        And I should see "Download Now"
