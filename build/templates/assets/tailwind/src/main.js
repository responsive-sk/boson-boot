import './styles.css'
import Alpine from 'alpinejs'
import htmx from 'htmx.org'
import collapse from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'

// Alpine.js components
Alpine.data('header', () => ({
  mobileMenuOpen: false,
  searchOpen: false,
  
  toggleMobileMenu() {
    this.mobileMenuOpen = !this.mobileMenuOpen
  },
  
  toggleSearch() {
    this.searchOpen = !this.searchOpen
    if (this.searchOpen) {
      this.$nextTick(() => {
        this.$refs.searchInput?.focus()
      })
    }
  },
  
  closeSearch() {
    this.searchOpen = false
  }
}))

Alpine.data('articleCard', (article) => ({
  article,
  isHovered: false,
  
  get readingTime() {
    const wordsPerMinute = 200
    const words = this.article.content?.split(' ').length || 0
    return Math.ceil(words / wordsPerMinute)
  },
  
  formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  }
}))

Alpine.data('searchModal', () => ({
  open: false,
  query: '',
  results: [],
  loading: false,
  
  async search() {
    if (this.query.length < 2) {
      this.results = []
      return
    }
    
    this.loading = true
    
    try {
      const response = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`)
      const data = await response.json()
      this.results = data.results || []
    } catch (error) {
      console.error('Search error:', error)
      this.results = []
    } finally {
      this.loading = false
    }
  },
  
  openModal() {
    this.open = true
    this.$nextTick(() => {
      this.$refs.searchInput?.focus()
    })
  },
  
  closeModal() {
    this.open = false
    this.query = ''
    this.results = []
  }
}))

Alpine.data('toast', () => ({
  toasts: [],
  
  show(message, type = 'info', duration = 5000) {
    const id = Date.now()
    const toast = { id, message, type, visible: true }
    
    this.toasts.push(toast)
    
    setTimeout(() => {
      this.hide(id)
    }, duration)
  },
  
  hide(id) {
    const toast = this.toasts.find(t => t.id === id)
    if (toast) {
      toast.visible = false
      setTimeout(() => {
        this.toasts = this.toasts.filter(t => t.id !== id)
      }, 300)
    }
  }
}))

Alpine.data('dropdown', () => ({
  open: false,
  
  toggle() {
    this.open = !this.open
  },
  
  close() {
    this.open = false
  }
}))

Alpine.data('tabs', (defaultTab = 0) => ({
  activeTab: defaultTab,
  
  setActive(index) {
    this.activeTab = index
  },
  
  isActive(index) {
    return this.activeTab === index
  }
}))

Alpine.data('accordion', () => ({
  openItems: new Set(),
  
  toggle(index) {
    if (this.openItems.has(index)) {
      this.openItems.delete(index)
    } else {
      this.openItems.add(index)
    }
  },
  
  isOpen(index) {
    return this.openItems.has(index)
  }
}))

Alpine.data('modal', () => ({
  open: false,
  
  show() {
    this.open = true
    document.body.style.overflow = 'hidden'
  },
  
  hide() {
    this.open = false
    document.body.style.overflow = ''
  }
}))

// Global utilities
window.Alpine = Alpine
window.htmx = htmx
window.showToast = function(message, type = 'info') {
  Alpine.store('toast').show(message, type)
}

// Initialize Alpine plugins
Alpine.plugin(collapse)
Alpine.plugin(intersect)

// Initialize Alpine
Alpine.start()

console.log('🎨 Tailwind theme loaded with HTMX and Alpine.js')
