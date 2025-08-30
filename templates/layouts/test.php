<?php
/**
 * Test Layout - Simple layout for testing component hierarchy
 * No complex JS dependencies, minimal CSS, clean structure
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'Test Layout') ?></title>
    
    <!-- Minimal CSS for testing -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .test-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .test-header {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .test-nav {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .test-nav a {
            color: #0066cc;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        
        .test-nav a:hover {
            background: #f0f0f0;
        }
        
        .test-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .test-footer {
            background: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }
        
        .component-test {
            border: 2px dashed #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        .component-test h3 {
            color: #666;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
        }
        
        .theme-info {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .component-controls {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .component-toggle {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .component-toggle:hover {
            background: #f0f0f0;
        }

        .component-toggle.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .component-instance {
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 15px;
            border-radius: 4px;
            background: #fafafa;
        }

        .component-instance h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
            font-weight: bold;
        }
    </style>

    <script>
        // Test Layer Component Manager
        class TestComponentManager {
            constructor() {
                this.components = new Map();
                this.activeComponents = new Set();
                this.init();
            }

            init() {
                // Initialize when DOM is ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', () => this.setupUI());
                } else {
                    this.setupUI();
                }
            }

            registerComponent(name, config) {
                this.components.set(name, {
                    name,
                    description: config.description || '',
                    element: config.element || null,
                    data: config.data || {},
                    enabled: config.enabled || false
                });
                this.updateUI();
            }

            toggleComponent(name) {
                if (this.activeComponents.has(name)) {
                    this.deactivateComponent(name);
                } else {
                    this.activateComponent(name);
                }
            }

            activateComponent(name) {
                const component = this.components.get(name);
                if (!component) return;

                this.activeComponents.add(name);
                this.renderComponent(name, component);
                this.updateToggleButton(name, true);
                console.log(`✅ Activated component: ${name}`);
            }

            deactivateComponent(name) {
                this.activeComponents.delete(name);
                this.removeComponent(name);
                this.updateToggleButton(name, false);
                console.log(`❌ Deactivated component: ${name}`);
            }

            renderComponent(name, component) {
                const container = document.getElementById('component-instances');
                if (!container) return;

                const instanceDiv = document.createElement('div');
                instanceDiv.className = 'component-instance';
                instanceDiv.id = `component-${name}`;
                instanceDiv.innerHTML = `
                    <h4>${component.name}</h4>
                    <p>${component.description}</p>
                    <div id="component-content-${name}">Loading...</div>
                `;

                container.appendChild(instanceDiv);

                // If component has element, render it
                if (component.element) {
                    const contentDiv = document.getElementById(`component-content-${name}`);
                    contentDiv.innerHTML = '';
                    contentDiv.appendChild(component.element);
                }
            }

            removeComponent(name) {
                const element = document.getElementById(`component-${name}`);
                if (element) {
                    element.remove();
                }
            }

            updateToggleButton(name, active) {
                const button = document.querySelector(`[data-component="${name}"]`);
                if (button) {
                    button.classList.toggle('active', active);
                }
            }

            setupUI() {
                this.updateUI();

                // Add event listeners for toggle buttons
                document.addEventListener('click', (e) => {
                    if (e.target.classList.contains('component-toggle')) {
                        const componentName = e.target.dataset.component;
                        this.toggleComponent(componentName);
                    }
                });
            }

            updateUI() {
                const controlsContainer = document.getElementById('component-controls');
                if (!controlsContainer) return;

                controlsContainer.innerHTML = '<h3>Component Controls</h3>';

                this.components.forEach((component, name) => {
                    const button = document.createElement('button');
                    button.className = 'component-toggle';
                    button.dataset.component = name;
                    button.textContent = name;
                    button.title = component.description;

                    if (this.activeComponents.has(name)) {
                        button.classList.add('active');
                    }

                    controlsContainer.appendChild(button);
                });
            }
        }

        // Global instance
        window.testManager = new TestComponentManager();
    </script>
</head>
<body>
    <div class="test-container">
        <!-- Theme Information -->
        <div class="theme-info">
            <strong>Current Theme:</strong> <?= $currentTheme ?? 'Unknown' ?><br>
            <strong>Layout:</strong> Test Layout (No JS Dependencies)
        </div>
        
        <!-- Test Header -->
        <header class="test-header">
            <h1>Test Layout - Component Hierarchy Testing</h1>
            <nav class="test-nav">
                <a href="/">Home</a>
                <a href="/articles">Articles</a>
                <a href="/docs">Docs</a>
                <a href="/test">Test</a>
            </nav>
        </header>
        
        <!-- Main Content -->
        <main class="test-content">
            <?= $this->section('content') ?>
        </main>
        
        <!-- Component Controls -->
        <div class="component-controls" id="component-controls">
            <h3>Component Controls</h3>
            <p>No components registered yet. Components will appear here when registered.</p>
        </div>

        <!-- Component Instances -->
        <div class="test-content">
            <h2>Active Components</h2>
            <div id="component-instances">
                <p>No active components. Use the controls above to activate components.</p>
            </div>
        </div>

        <!-- Component Testing Area -->
        <div class="test-content">
            <h2>Component Information</h2>

            <div class="component-test">
                <h3>How to Use</h3>
                <p>1. Components are registered dynamically via JavaScript</p>
                <p>2. Use the controls above to activate/deactivate components</p>
                <p>3. Active components will appear in the "Active Components" section</p>
                <p>4. Check browser console for component loading messages</p>
            </div>

            <div class="component-test">
                <h3>Supported Component Types</h3>
                <p><strong>Svelte Components:</strong> Reactive components with state management</p>
                <p><strong>PHP Components:</strong> Server-side rendered components (always available)</p>
                <p><strong>Mixed Components:</strong> PHP structure with Svelte interactivity</p>
            </div>
        </div>
        
        <!-- Test Footer -->
        <footer class="test-footer">
            <p>Test Layout - No JavaScript Dependencies</p>
        </footer>
    </div>
</body>
</html>
