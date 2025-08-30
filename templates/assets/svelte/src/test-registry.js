/**
 * Test Component Registry for Svelte Components
 * Manages registration and loading of Svelte components in test layer
 */

class SvelteComponentRegistry {
    constructor() {
        this.components = new Map();
        this.loadedComponents = new Map();
        this.testManager = null;
        this.init();
    }

    init() {
        // Wait for test manager to be available
        this.waitForTestManager();
    }

    waitForTestManager() {
        if (window.testManager) {
            this.testManager = window.testManager;
            this.registerAllComponents();
        } else {
            setTimeout(() => this.waitForTestManager(), 100);
        }
    }

    /**
     * Register a Svelte component for testing
     */
    registerSvelteComponent(name, componentClass, config = {}) {
        this.components.set(name, {
            name,
            componentClass,
            description: config.description || `Svelte component: ${name}`,
            props: config.props || {},
            enabled: config.enabled || false,
            target: config.target || null
        });

        console.log(`📝 Registered Svelte component: ${name}`);
        
        // If test manager is ready, register with it
        if (this.testManager) {
            this.registerWithTestManager(name);
        }
    }

    /**
     * Register component with the test manager
     */
    registerWithTestManager(name) {
        const component = this.components.get(name);
        if (!component || !this.testManager) return;

        this.testManager.registerComponent(name, {
            description: component.description,
            element: this.createComponentElement(name),
            data: component.props,
            enabled: component.enabled
        });
    }

    /**
     * Create DOM element for Svelte component
     */
    createComponentElement(name) {
        const component = this.components.get(name);
        if (!component) return null;

        const container = document.createElement('div');
        container.className = `svelte-component-container svelte-${name.toLowerCase()}`;
        container.id = `svelte-${name.toLowerCase()}-container`;

        // Add loading indicator
        container.innerHTML = `
            <div class="svelte-loading">
                <p>Loading ${name} component...</p>
            </div>
        `;

        // Load component when element is created
        this.loadComponent(name, container);

        return container;
    }

    /**
     * Load and mount Svelte component
     */
    async loadComponent(name, container) {
        const componentConfig = this.components.get(name);
        if (!componentConfig) return;

        try {
            // Clear loading indicator
            container.innerHTML = '';

            // Create Svelte component instance
            const instance = new componentConfig.componentClass({
                target: container,
                props: componentConfig.props
            });

            // Store instance for cleanup
            this.loadedComponents.set(name, instance);

            console.log(`✅ Loaded Svelte component: ${name}`);

        } catch (error) {
            console.error(`❌ Failed to load Svelte component ${name}:`, error);
            container.innerHTML = `
                <div class="svelte-error">
                    <p><strong>Error loading ${name}</strong></p>
                    <p>${error.message}</p>
                </div>
            `;
        }
    }

    /**
     * Unload component and cleanup
     */
    unloadComponent(name) {
        const instance = this.loadedComponents.get(name);
        if (instance && instance.$destroy) {
            instance.$destroy();
            this.loadedComponents.delete(name);
            console.log(`🗑️ Unloaded Svelte component: ${name}`);
        }
    }

    /**
     * Register all available components
     */
    registerAllComponents() {
        // This will be called when components are imported
        console.log('🎯 Svelte Component Registry ready for component registration');
    }

    /**
     * Get component info
     */
    getComponentInfo(name) {
        return this.components.get(name);
    }

    /**
     * List all registered components
     */
    listComponents() {
        return Array.from(this.components.keys());
    }
}

// Global registry instance
window.svelteRegistry = new SvelteComponentRegistry();

// Export for module usage
export default window.svelteRegistry;
