import './styles/main.css'
import Header from './components/Header.svelte'
import SearchModal from './components/SearchModal.svelte'
import ArticleCard from './components/ArticleCard.svelte'
import ArticleDetail from './components/ArticleDetail.svelte'
import Footer from './components/Footer.svelte'
import TailwindHero from './components/TailwindHero.svelte'

// Import test registry for component testing
import './test-registry.js'

// Import HTMX and Alpine.js
import htmx from 'htmx.org'
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'

// Initialize Svelte components
const components = new Map()

// Wait for DOM to be ready
function initializeComponents() {
  console.log('DOM ready, initializing Svelte components...')

  // Add loading class to prevent FOUC
  document.body.classList.add('svelte-loading')

  // Header component
  const headerElement = document.querySelector('#svelte-header')
  console.log('Header element found:', headerElement)

  if (headerElement) {
    console.log('Header dataset:', headerElement.dataset)
    console.log('Initializing Svelte Header component')

    try {
      components.set('header', new Header({
        target: headerElement,
        props: {
          currentRoute: headerElement.dataset.currentRoute || '',
          searchQuery: headerElement.dataset.searchQuery || ''
        }
      }))
      console.log('Svelte Header initialized successfully')
    } catch (error) {
      console.error('Header initialization error:', error)
    }
  } else {
    console.log('Header element not found')
  }

  // Search modal
  const searchModalElement = document.querySelector('#svelte-search-modal')
  console.log('SearchModal element found:', searchModalElement)

  if (searchModalElement) {
    console.log('Initializing Svelte SearchModal component')

    try {
      components.set('searchModal', new SearchModal({
        target: searchModalElement
      }))
      console.log('Svelte SearchModal initialized successfully')
    } catch (error) {
      console.error('SearchModal initialization error:', error)
    }
  } else {
    console.log('SearchModal element not found')
  }

  // Article cards
  const articleElements = document.querySelectorAll('.svelte-article-card')
  console.log(`Found ${articleElements.length} Svelte article cards`)

  articleElements.forEach((element, index) => {
    try {
      const articleData = JSON.parse(element.dataset.article || '{}')
      console.log(`Initializing ArticleCard ${index}:`, articleData.title)

      const component = new ArticleCard({
        target: element,
        props: {
          article: articleData
        }
      })

      components.set(`articleCard-${index}`, component)
      console.log(`ArticleCard ${index} initialized successfully`)
    } catch (error) {
      console.error('Failed to parse article data:', error, element.dataset.article)
    }
  })

  // Article detail component
  const articleDetailElement = document.getElementById('svelte-article-detail')
  console.log('ArticleDetail element found:', articleDetailElement)

  if (articleDetailElement) {
    try {
      const articleData = JSON.parse(articleDetailElement.dataset.article || '{}')
      console.log('Initializing Svelte ArticleDetail component:', articleData.title)

      const articleDetailComponent = new ArticleDetail({
        target: articleDetailElement,
        props: {
          article: articleData
        }
      })

      components.set('articleDetail', articleDetailComponent)
      console.log('Svelte ArticleDetail initialized successfully')
    } catch (error) {
      console.error('Failed to initialize ArticleDetail component:', error)
      console.error('Error details:', error.message, error.stack)
    }
  } else {
    console.log('ArticleDetail element not found')
  }

  // Footer component
  const footerElement = document.getElementById('svelte-footer')
  console.log('Footer element found:', footerElement)

  if (footerElement) {
    try {
      const currentRoute = footerElement.dataset.currentRoute || ''
      console.log('Footer dataset:', footerElement.dataset)

      console.log('Initializing Svelte Footer component')
      const footerComponent = new Footer({
        target: footerElement,
        props: {
          currentRoute
        }
      })

      components.set('footer', footerComponent)
      console.log('Svelte Footer initialized successfully')
    } catch (error) {
      console.error('Failed to initialize Footer component:', error)

      // Show fallback footer if Svelte component fails
      const fallbackFooter = document.querySelector('.fallback-footer')
      if (fallbackFooter) {
        fallbackFooter.style.display = 'block'
        console.log('Showing fallback footer due to Svelte Footer error')
      }
    }
  } else {
    console.log('Footer element not found')
    // Show fallback footer if no Svelte footer element found
    const fallbackFooter = document.querySelector('.fallback-footer')
    if (fallbackFooter) {
      fallbackFooter.style.display = 'block'
      console.log('Showing fallback footer - no Svelte footer element found')
    }
  }

  // TailwindHero component
  const tailwindHeroElement = document.getElementById('svelte-tailwind-hero')
  console.log('TailwindHero element found:', tailwindHeroElement)

  if (tailwindHeroElement) {
    try {
      console.log('Found TailwindHero element, parsing data attributes...')

      // Parse data attributes
      const title = tailwindHeroElement.dataset.title || 'Go Native. Stay PHP.'
      const subtitle = tailwindHeroElement.dataset.subtitle || 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.'

      console.log('Raw button data:', {
        primary: tailwindHeroElement.dataset.primaryButton,
        secondary: tailwindHeroElement.dataset.secondaryButton
      })

      const primaryButton = tailwindHeroElement.dataset.primaryButton ? JSON.parse(tailwindHeroElement.dataset.primaryButton) : { text: 'Try Boson For Free', url: '/docs/latest/installation' }
      const secondaryButton = tailwindHeroElement.dataset.secondaryButton ? JSON.parse(tailwindHeroElement.dataset.secondaryButton) : { text: 'Download Now', url: '/download' }

      console.log('Parsed props:', { title, subtitle, primaryButton, secondaryButton })

      console.log('Initializing Svelte TailwindHero component')
      const tailwindHeroComponent = new TailwindHero({
        target: tailwindHeroElement,
        props: {
          title,
          subtitle,
          primaryButton,
          secondaryButton
        }
      })

      components.set('tailwindHero', tailwindHeroComponent)
      console.log('Svelte TailwindHero initialized successfully')
    } catch (error) {
      console.error('Failed to initialize TailwindHero component:', error)
      console.error('Error details:', error.message, error.stack)
    }
  } else {
    console.log('TailwindHero element not found')
  }

  console.log('All Svelte components initialized')

  // Remove loading class and add loaded class
  document.body.classList.remove('svelte-loading')
  document.body.classList.add('svelte-loaded')
}

// Call initialization when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeComponents)
} else {
  // DOM is already ready
  initializeComponents()
}

// Export for global access
window.SvelteComponents = components

// Initialize HTMX
window.htmx = htmx

// Initialize Alpine.js plugins
Alpine.plugin(collapse)
Alpine.plugin(intersect)

// Initialize Alpine.js
window.Alpine = Alpine
Alpine.start()

// Hot module replacement
if (import.meta.hot) {
  import.meta.hot.accept()
}

console.log('Svelte theme loaded with HTMX and Alpine.js')

// Register components for testing (only if test registry is available)
if (window.svelteRegistry) {
  // Register Header component
  window.svelteRegistry.registerSvelteComponent('Header', Header, {
    description: 'Main navigation header with search functionality',
    props: {
      currentRoute: 'test',
      searchQuery: ''
    }
  })

  // Register SearchModal component
  window.svelteRegistry.registerSvelteComponent('SearchModal', SearchModal, {
    description: 'Modal dialog for search functionality'
  })

  // Register ArticleCard component
  window.svelteRegistry.registerSvelteComponent('ArticleCard', ArticleCard, {
    description: 'Card component for displaying article information',
    props: {
      article: {
        id: 1,
        title: 'Test Article',
        excerpt: 'This is a test article for component testing.',
        published_at: '2025-01-01',
        slug: 'test-article'
      }
    }
  })

  // Register Footer component
  window.svelteRegistry.registerSvelteComponent('Footer', Footer, {
    description: 'Main footer with navigation and links'
  })

  // Register TailwindHero component
  window.svelteRegistry.registerSvelteComponent('TailwindHero', TailwindHero, {
    description: 'Modern hero section with Tailwind-inspired design',
    props: {
      title: 'Go Native. Stay PHP.',
      subtitle: 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.',
      primaryButton: { text: 'Try Boson For Free', url: '/docs/latest/installation' },
      secondaryButton: { text: 'Download Now', url: '/download' }
    }
  })

  console.log('✅ Svelte components registered for testing')
}
