<?php
/**
 * Test Page - For testing component hierarchy and theme separation
 */

$this->layout('app', [
    'title' => 'Dynamic Component Test Layer',
    'description' => 'Testing Svelte components dynamically'
]);
?>

<?php $this->start('content') ?>

<h1>Dynamic Component Test Layer</h1>
<p>Testing Svelte components dynamically with the app layout.</p>

<h2>Test Status</h2>
<p>This page uses the standard app layout and should work correctly.</p>

<?php $this->stop() ?>
