<script>
  // Footer component props (similar to Header)
  export let currentRoute = ''
  
  // Footer data
  const footerSections = [
    {
      title: 'References',
      links: [
        { text: 'Documentation', url: '/docs' },
        { text: 'API Reference', url: '/api' },
        { text: 'Examples', url: '/examples' }
      ]
    },
    {
      title: 'Articles',
      links: [
        { text: 'All Articles', url: '/articles' },
        { text: 'Tutorials', url: '/tutorials' },
        { text: 'News', url: '/news' }
      ]
    },
    {
      title: 'Community',
      links: [
        { text: 'Download', url: '/download' },
        { text: 'Community', url: '/community' },
        { text: 'Support', url: '/support' }
      ]
    }
  ]
  
  const legalLinks = [
    { text: 'Privacy Policy', url: '/privacy' },
    { text: 'Terms of Service', url: '/terms' },
    { text: 'Contact', url: '/contact' }
  ]
  
  // Get current year
  const currentYear = new Date().getFullYear()
</script>

<footer class="footer-container">
  <div class="footer-content">
    <!-- Top section with main links -->
    <div class="footer-top">
      <div class="holder"></div>

      <!-- Main link section -->
      <div class="main-link-section">
        <a href="/docs/latest/installation" class="footer-main-link">
          Try Boson for Free
        </a>
      </div>

      <!-- Decorative dots -->
      <div class="dots-main">
        <div class="dots-inner"></div>
      </div>

      <!-- Aside link section -->
      <div class="aside-link-section">
        <a href="/community" class="footer-aside-link">
          Join Community
        </a>
      </div>

      <div class="holder"></div>
    </div>

    <!-- Middle section with navigation links -->
    <div class="footer-middle">
      <div class="holder"></div>

      {#each footerSections as section}
        <div class="footer-section">
          <h3 class="footer-section-title">
            {section.title}
            <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M9 18l6-6-6-6"/>
            </svg>
          </h3>
          <ul class="footer-links">
            {#each section.links as link}
              <li>
                <a href={link.url} class="footer-link" class:active={currentRoute === link.url}>
                  {link.text}
                </a>
              </li>
            {/each}
          </ul>
        </div>
      {/each}

      <div class="holder"></div>
    </div>

    <!-- Bottom section with copyright and legal links -->
    <div class="footer-bottom">
      <div class="holder"></div>

      <div class="footer-copyright">
        <p>&copy; {currentYear} Boson PHP Team. All rights reserved.</p>
      </div>

      <div class="footer-legal">
        {#each legalLinks as link, index}
          <a href={link.url} class="footer-legal-link" class:active={currentRoute === link.url}>
            {link.text}
          </a>
          {#if index < legalLinks.length - 1}
            <span class="footer-separator">•</span>
          {/if}
        {/each}
      </div>

      <div class="footer-social">
        <!-- Social media icons can be added here -->
      </div>

      <div class="holder"></div>
    </div>

    <!-- Decorative dots at bottom -->
    <div class="dots-bottom">
      <div class="dots-inner"></div>
    </div>
  </div>
</footer>

<style>
  /* Footer styles - using same pattern as Header */
  .footer-container {
    background: var(--color-bg-layer, #0f131c);
    border-top: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    margin-top: 4rem;
    position: relative;
  }

  .footer-content {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
    padding: 3rem 0 2rem 0;
  }

  .footer-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
  }

  .holder {
    flex: 1;
  }

  .main-link-section,
  .aside-link-section {
    flex: 2;
    text-align: center;
  }

  .footer-main-link,
  .footer-aside-link {
    display: inline-block;
    padding: 1rem 2rem;
    background: #7a1a1a;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .footer-aside-link {
    background: transparent;
    border: 2px solid #7a1a1a;
    color: #ffffff;
  }

  .footer-main-link:hover,
  .footer-aside-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(122, 26, 26, 0.3);
  }

  .dots-main {
    flex: 1;
    display: flex;
    justify-content: center;
  }

  .dots-inner {
    width: 40px;
    height: 40px;
    background: radial-gradient(circle, #7a1a1a 2px, transparent 2px);
    background-size: 8px 8px;
    opacity: 0.3;
  }

  .footer-middle {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 3rem;
    gap: 2rem;
  }

  .footer-section {
    flex: 1;
    min-width: 200px;
  }

  .footer-section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 0 1rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-h5, 1.25rem);
    font-weight: 600;
  }

  .footer-icon {
    width: 16px;
    height: 16px;
    color: #7a1a1a;
  }

  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-links li {
    margin-bottom: 0.5rem;
  }

  .footer-link {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    text-decoration: none;
    font-size: var(--font-size-small, 0.875rem);
    transition: color 0.3s ease;
  }

  .footer-link:hover,
  .footer-link.active {
    color: #7a1a1a;
  }

  .footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 2rem;
    border-top: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
  }

  .footer-copyright p {
    margin: 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
  }

  .footer-legal {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .footer-legal-link {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    text-decoration: none;
    font-size: var(--font-size-small, 0.875rem);
    transition: color 0.3s ease;
  }

  .footer-legal-link:hover,
  .footer-legal-link.active {
    color: #7a1a1a;
  }

  .footer-separator {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.3));
  }

  .dots-bottom {
    position: absolute;
    bottom: 1rem;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0.2;
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .footer-top {
      flex-direction: column;
      gap: 2rem;
    }
    
    .footer-middle {
      flex-direction: column;
      gap: 2rem;
    }
    
    .footer-bottom {
      flex-direction: column;
      gap: 1rem;
      text-align: center;
    }
    
    .footer-legal {
      flex-wrap: wrap;
      justify-content: center;
    }
  }
</style>
