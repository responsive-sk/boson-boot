<?php
/**
 * Testimonials Section - developer testimonials
 */
?>

<section class="testimonials-section">
    <div class="container">
        <div class="testimonials-grid">
            <div class="testimonial-card" 
                 x-data="{ visible: false }"
                 x-intersect="visible = true"
                 :class="{ 'animate': visible }">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>Boson PHP has revolutionized how I think about desktop development. Being able to use my existing PHP skills to build native apps is incredible. The performance is outstanding and the development experience is smooth.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="/images/avatars/sarah.jpg" alt="Sarah Chen" loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>Sarah Chen</h4>
                        <p>Senior Full Stack Developer</p>
                        <div class="author-company">@TechCorp</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card"
                 x-data="{ visible: false }"
                 x-intersect="visible = true"
                 :class="{ 'animate': visible }">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>I was skeptical at first, but Boson PHP delivered on all its promises. Our desktop app is faster than our previous Electron version and uses significantly less memory. The migration was surprisingly smooth.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="/images/avatars/marcus.jpg" alt="Marcus Rodriguez" loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>Marcus Rodriguez</h4>
                        <p>Software Engineer</p>
                        <div class="author-company">@StartupXYZ</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card"
                 x-data="{ visible: false }"
                 x-intersect="visible = true"
                 :class="{ 'animate': visible }">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>The rich API ecosystem and native performance make Boson PHP perfect for our enterprise applications. Cross-platform deployment has never been this simple with PHP.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="/images/avatars/elena.jpg" alt="Elena Kowalski" loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>Elena Kowalski</h4>
                        <p>Tech Lead</p>
                        <div class="author-company">@Enterprise Solutions</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card"
                 x-data="{ visible: false }"
                 x-intersect="visible = true"
                 :class="{ 'animate': visible }">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>As a PHP developer for over 10 years, Boson opened up a whole new world for me. Building desktop apps with familiar tools and libraries is a game-changer. Highly recommended!</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="/images/avatars/david.jpg" alt="David Kim" loading="lazy">
                    </div>
                    <div class="author-info">
                        <h4>David Kim</h4>
                        <p>PHP Developer</p>
                        <div class="author-company">@Freelancer</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="community-stats">
            <div class="stat">
                <div class="stat-number">10,000+</div>
                <div class="stat-label">Developers</div>
            </div>
            <div class="stat">
                <div class="stat-number">500+</div>
                <div class="stat-label">Apps Built</div>
            </div>
            <div class="stat">
                <div class="stat-number">50+</div>
                <div class="stat-label">Countries</div>
            </div>
            <div class="stat">
                <div class="stat-number">99%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<style>
.testimonials-section {
    margin: 6rem 0;
    padding: 4rem 0;
    background: var(--color-bg-layer, #0f131c);
}

.testimonials-section .container {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
}

.testimonials-section .testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.testimonials-section .testimonial-card {
    background: var(--color-bg, #0d1119);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    padding: 2rem;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(20px);
}

.testimonials-section .testimonial-card.animate {
    opacity: 1;
    transform: translateY(0);
}

.testimonials-section .testimonial-card:hover {
    transform: translateY(-4px);
    border-color: var(--color-text-brand, #F93904);
}

.testimonials-section .testimonial-content {
    margin-bottom: 2rem;
    position: relative;
}

.testimonials-section .quote-icon {
    font-size: 4rem;
    color: var(--color-text-brand, #F93904);
    line-height: 1;
    position: absolute;
    top: -1rem;
    left: -0.5rem;
    opacity: 0.3;
}

.testimonials-section .testimonial-content p {
    margin: 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    line-height: 1.6;
    font-style: italic;
    position: relative;
    z-index: 1;
}

.testimonials-section .testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.testimonials-section .author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--color-bg-layer, #0f131c);
    display: flex;
    align-items: center;
    justify-content: center;
}

.testimonials-section .author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testimonials-section .author-info h4 {
    margin: 0 0 0.25rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-base, 1rem);
}

.testimonials-section .author-info p {
    margin: 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
}

.testimonials-section .author-company {
    color: var(--color-text-brand, #F93904);
    font-size: var(--font-size-small, 0.875rem);
    font-weight: 500;
}

.testimonials-section .community-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    text-align: center;
}

.testimonials-section .stat {
    padding: 1.5rem;
    background: var(--color-bg, #0d1119);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.testimonials-section .stat:hover {
    transform: translateY(-4px);
}

.testimonials-section .stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text-brand, #F93904);
    margin-bottom: 0.5rem;
    font-family: var(--font-title);
}

.testimonials-section .stat-label {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

/* Create placeholder avatars */
.testimonials-section .author-avatar:empty::before {
    content: attr(data-initials);
    color: var(--color-text-brand, #F93904);
    font-weight: 600;
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .testimonials-section .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .testimonials-section .community-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .testimonials-section .community-stats {
        grid-template-columns: 1fr;
    }
}
</style>
