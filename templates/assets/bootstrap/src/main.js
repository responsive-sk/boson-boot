import './styles.scss'
import 'bootstrap'
import { Tooltip, Popover, Toast, Modal, Dropdown, Collapse, Carousel } from 'bootstrap'
import htmx from 'htmx.org'
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'

// Initialize Bootstrap components
document.addEventListener('DOMContentLoaded', function() {
  // Initialize tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl)
  })

  // Initialize popovers
  const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new Popover(popoverTriggerEl)
  })

  // Initialize toasts
  const toastElList = [].slice.call(document.querySelectorAll('.toast'))
  toastElList.map(function (toastEl) {
    return new Toast(toastEl)
  })

  // Initialize modals
  const modalElList = [].slice.call(document.querySelectorAll('.modal'))
  modalElList.map(function (modalEl) {
    return new Modal(modalEl)
  })

  // Initialize dropdowns
  const dropdownElList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
  dropdownElList.map(function (dropdownToggleEl) {
    return new Dropdown(dropdownToggleEl)
  })

  // Initialize collapses
  const collapseElList = [].slice.call(document.querySelectorAll('.collapse'))
  collapseElList.map(function (collapseEl) {
    return new Collapse(collapseEl, { toggle: false })
  })

  // Initialize carousels
  const carouselElList = [].slice.call(document.querySelectorAll('.carousel'))
  carouselElList.map(function (carouselEl) {
    return new Carousel(carouselEl)
  })
})

// Custom JavaScript utilities
class BosonBootstrap {
  constructor() {
    this.init()
  }

  init() {
    this.setupSearch()
    this.setupArticleCards()
    this.setupSmoothScrolling()
    this.setupFormValidation()
    this.setupLoadingStates()
  }

  setupSearch() {
    const searchForm = document.querySelector('#search-form')
    const searchInput = document.querySelector('#search-input')
    const searchResults = document.querySelector('#search-results')

    if (searchForm && searchInput) {
      let searchTimeout

      searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout)
        const query = e.target.value.trim()

        if (query.length < 2) {
          if (searchResults) searchResults.innerHTML = ''
          return
        }

        searchTimeout = setTimeout(() => {
          this.performSearch(query)
        }, 300)
      })
    }
  }

  async performSearch(query) {
    const searchResults = document.querySelector('#search-results')
    if (!searchResults) return

    try {
      searchResults.innerHTML = '<div class="text-center p-3"><div class="spinner-border spinner-boson" role="status"></div></div>'

      const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`)
      const data = await response.json()

      if (data.results && data.results.length > 0) {
        searchResults.innerHTML = data.results.map(result => `
          <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h6 class="mb-1">${result.title}</h6>
              <small class="text-muted">${result.category}</small>
            </div>
            <p class="mb-1">${result.excerpt}</p>
            <small class="text-muted">${result.published_at}</small>
          </div>
        `).join('')
      } else {
        searchResults.innerHTML = '<div class="text-center p-3 text-muted">No results found</div>'
      }
    } catch (error) {
      console.error('Search error:', error)
      searchResults.innerHTML = '<div class="text-center p-3 text-danger">Search failed</div>'
    }
  }

  setupArticleCards() {
    const articleCards = document.querySelectorAll('.card-article')
    
    articleCards.forEach(card => {
      card.addEventListener('mouseenter', () => {
        card.classList.add('shadow-lg')
      })
      
      card.addEventListener('mouseleave', () => {
        card.classList.remove('shadow-lg')
      })
    })
  }

  setupSmoothScrolling() {
    const scrollLinks = document.querySelectorAll('a[href^="#"]')
    
    scrollLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        const href = link.getAttribute('href')
        if (href === '#') return
        
        const target = document.querySelector(href)
        if (target) {
          e.preventDefault()
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          })
        }
      })
    })
  }

  setupFormValidation() {
    const forms = document.querySelectorAll('.needs-validation')
    
    forms.forEach(form => {
      form.addEventListener('submit', (e) => {
        if (!form.checkValidity()) {
          e.preventDefault()
          e.stopPropagation()
        }
        form.classList.add('was-validated')
      })
    })
  }

  setupLoadingStates() {
    const buttons = document.querySelectorAll('[data-loading-text]')
    
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const loadingText = button.getAttribute('data-loading-text')
        const originalText = button.innerHTML
        
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span>${loadingText}`
        button.disabled = true
        
        // Reset after 3 seconds (adjust as needed)
        setTimeout(() => {
          button.innerHTML = originalText
          button.disabled = false
        }, 3000)
      })
    })
  }

  showToast(message, type = 'info') {
    const toastContainer = document.querySelector('#toast-container') || this.createToastContainer()
    
    const toastId = 'toast-' + Date.now()
    const toastHtml = `
      <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert">
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    `
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml)
    
    const toastElement = document.getElementById(toastId)
    const toast = new Toast(toastElement)
    toast.show()
    
    toastElement.addEventListener('hidden.bs.toast', () => {
      toastElement.remove()
    })
  }

  createToastContainer() {
    const container = document.createElement('div')
    container.id = 'toast-container'
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3'
    document.body.appendChild(container)
    return container
  }

  showModal(title, content, options = {}) {
    const modalId = 'modal-' + Date.now()
    const modalHtml = `
      <div class="modal fade modal-boson" id="${modalId}" tabindex="-1">
        <div class="modal-dialog ${options.size || ''}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">${title}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">${content}</div>
            ${options.footer ? `<div class="modal-footer">${options.footer}</div>` : ''}
          </div>
        </div>
      </div>
    `
    
    document.body.insertAdjacentHTML('beforeend', modalHtml)
    
    const modalElement = document.getElementById(modalId)
    const modal = new Modal(modalElement)
    modal.show()
    
    modalElement.addEventListener('hidden.bs.modal', () => {
      modalElement.remove()
    })
    
    return modal
  }
}

// Initialize Boson Bootstrap utilities
const bosonBootstrap = new BosonBootstrap()

// Global utilities
window.BosonBootstrap = bosonBootstrap
window.htmx = htmx
window.Alpine = Alpine
window.showToast = (message, type) => bosonBootstrap.showToast(message, type)
window.showModal = (title, content, options) => bosonBootstrap.showModal(title, content, options)

// Initialize Alpine.js plugins
Alpine.plugin(collapse)
Alpine.plugin(intersect)

// Initialize Alpine.js
Alpine.start()

console.log('🅱️ Bootstrap theme loaded with HTMX and Alpine.js')
