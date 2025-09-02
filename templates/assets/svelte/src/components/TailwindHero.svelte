<script>
  import { onMount } from 'svelte'

  // Hero component props (similar to Header and Footer pattern)
  export let title = 'Go Native. Stay PHP.'
  export let subtitle = 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.'
  export let primaryButton = { text: 'Try Boson For Free', url: '/docs/latest/installation' }
  export let secondaryButton = { text: 'Download Now', url: '/download' }

  // Animation state
  let mounted = false

  // Features data
  const features = [
    {
      icon: '⚡',
      text: 'Lightning Fast'
    },
    {
      icon: '🌍',
      text: 'Cross Platform'
    },
    {
      icon: '💝',
      text: 'Developer Friendly'
    }
  ]

  // Lifecycle
  onMount(() => {
    mounted = true
    console.log('TailwindHero mounted with props:', { title, subtitle, primaryButton, secondaryButton })
  })
</script>

<section class="hero-container">
  <!-- Background Pattern -->
  <div class="hero-background">
    <div class="gradient-overlay"></div>
    <div class="pattern-overlay"></div>
  </div>
  
  <!-- Animated Background Elements -->
  <div class="blob blob-1" class:animate={mounted}></div>
  <div class="blob blob-2" class:animate={mounted}></div>
  <div class="blob blob-3" class:animate={mounted}></div>
  
  <!-- Content -->
  <div class="hero-content">
    <div class="content-wrapper">
      <!-- Badge -->
      <div class="hero-badge" class:animate={mounted}>
        <span class="badge-dot"></span>
        New: Boson PHP v2.0 Available
      </div>
      
      <!-- Main Title -->
      <h1 class="hero-title" class:animate={mounted}>
        {title}
      </h1>
      
      <!-- Subtitle -->
      <p class="hero-subtitle" class:animate={mounted}>
        {subtitle}
      </p>
      
      <!-- Buttons -->
      <div class="hero-buttons" class:animate={mounted}>
        <a href={primaryButton.url} class="btn btn-primary">
          <span class="btn-text">{primaryButton.text}</span>
          <div class="btn-glow"></div>
        </a>
        
        <a href={secondaryButton.url} class="btn btn-secondary">
          <span class="btn-text">{secondaryButton.text}</span>
          <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/>
          </svg>
        </a>
      </div>
      
      <!-- Features -->
      <div class="hero-features" class:animate={mounted}>
        {#each features as feature, index}
          <div class="feature-item" style="animation-delay: {(index + 1) * 0.2}s">
            <span class="feature-icon">{feature.icon}</span>
            <span class="feature-text">{feature.text}</span>
          </div>
        {/each}
      </div>
    </div>
  </div>
  
  <!-- Bottom Wave -->
  <div class="hero-wave">
    <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="var(--color-bg, #0d1119)"/>
    </svg>
  </div>
</section>

<style>
  /* Hero container */
  .hero-container {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #3730a3 100%);
  }

  /* Background */
  .hero-background {
    position: absolute;
    inset: 0;
    z-index: 1;
  }

  .gradient-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
  }

  .pattern-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
  }

  /* Animated blobs */
  .blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.2;
    z-index: 2;
  }

  .blob-1 {
    width: 300px;
    height: 300px;
    background: #3b82f6;
    top: 10%;
    left: 10%;
    animation: blob-float 7s ease-in-out infinite;
  }

  .blob-2 {
    width: 300px;
    height: 300px;
    background: #8b5cf6;
    top: 10%;
    right: 10%;
    animation: blob-float 7s ease-in-out infinite 2s;
  }

  .blob-3 {
    width: 300px;
    height: 300px;
    background: #ec4899;
    bottom: -10%;
    left: 20%;
    animation: blob-float 7s ease-in-out infinite 4s;
  }

  .blob.animate {
    opacity: 0.2;
  }

  /* Content */
  .hero-content {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 1200px;
    padding: 2rem;
  }

  .content-wrapper {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
  }

  /* Badge */
  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    color: #ffffff;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 2rem;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
  }

  .hero-badge.animate {
    opacity: 1;
    transform: translateY(0);
  }

  .badge-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
  }

  /* Title */
  .hero-title {
    font-size: clamp(2.5rem, 8vw, 4.5rem);
    font-weight: 700;
    color: white;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    background: linear-gradient(135deg, #ffffff 0%, #e5e7eb 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease 0.2s;
  }

  .hero-title.animate {
    opacity: 1;
    transform: translateY(0);
  }

  /* Subtitle */
  .hero-subtitle {
    font-size: clamp(1.125rem, 3vw, 1.25rem);
    color: #ffffff;
    margin-bottom: 3rem;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease 0.4s;
  }

  .hero-subtitle.animate {
    opacity: 1;
    transform: translateY(0);
  }

  /* Buttons */
  .hero-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 3rem;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease 0.6s;
  }

  .hero-buttons.animate {
    opacity: 1;
    transform: translateY(0);
  }

  .btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.8);
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 1);
  }

  .btn-secondary {
    background: transparent;
    color: #ffffff;
    border: 2px solid rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
  }

  .btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: #ffffff;
    transform: translateY(-2px);
  }

  .btn-outline {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
  }

  .btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
  }

  .btn-text {
    position: relative;
    z-index: 2;
  }

  .btn-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 12px;
    filter: blur(20px);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .btn-primary:hover .btn-glow {
    opacity: 0.7;
  }

  .btn-icon {
    width: 20px;
    height: 20px;
  }

  /* Features */
  .hero-features {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease 0.8s;
  }

  .hero-features.animate {
    opacity: 1;
    transform: translateY(0);
  }

  .feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    color: #ffffff;
    font-size: 0.875rem;
    font-weight: 500;
    opacity: 0;
    transform: translateY(20px);
    animation: feature-fade-in 0.6s ease forwards;
  }

  .feature-icon {
    font-size: 1.25rem;
  }

  /* Wave */
  .hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 5;
  }

  .hero-wave svg {
    width: 100%;
    height: auto;
    display: block;
  }

  /* Animations */
  @keyframes blob-float {
    0%, 100% { 
      transform: translate(0px, 0px) scale(1); 
    }
    33% { 
      transform: translate(30px, -50px) scale(1.1); 
    }
    66% { 
      transform: translate(-20px, 20px) scale(0.9); 
    }
  }

  @keyframes pulse {
    0%, 100% { 
      opacity: 1; 
    }
    50% { 
      opacity: 0.5; 
    }
  }

  @keyframes feature-fade-in {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Responsive */
  @media (max-width: 768px) {
    .hero-content {
      padding: 1rem;
    }
    
    .hero-buttons {
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    
    .hero-features {
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    
    .blob {
      width: 200px;
      height: 200px;
    }
  }
</style>
