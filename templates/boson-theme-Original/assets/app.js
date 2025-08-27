import mermaid from 'mermaid/dist/mermaid.esm.mjs';

import './app.css'

import './components/sections/segment-section.js';
import './components/sections/call-to-action-section.js';
import './components/sections/hero-section.js';
import './components/sections/how-it-works-section.js';
import './components/sections/mobile-development-section.js';
import './components/sections/nativeness-section.js';
import './components/sections/right-choice-section.js';
import './components/sections/solves-section.js';
import './components/sections/testimonials-section.js';
import './components/sections/docs-toc.js';

import './components/ui/dropdown.js';
import './components/ui/breadcrumbs.js';
import './components/ui/mobile-header-menu.js';
import './components/ui/button.js';
import './components/ui/dots-container.js';
import './components/ui/footer.js';
import './components/ui/header.js';
import './components/ui/horizontal-accordion.js';
import './components/ui/slider.js';
import './components/ui/search-input.js';
import './components/ui/subtitle.js';
import './components/ui/page-title.js';
import './components/ui/logos/logo.js';

import './layout/landing.js';
import './layout/default.js';
import './layout/docs.js';
import './layout/blog.js';
import './layout/search.js';

document.addEventListener('DOMContentLoaded', function() {
    mermaid.init({
        theme: 'dark',
        themeVariables: {
            mainBkg: '#171c28',
            border1: '#FFFFFF0C',
            lineColor: '#9EAEF230',
            labelBackground: '#0d1119',
            edgeLabelBackground: '#0d1119',
        }

    }, document.querySelectorAll('[data-lang="mermaid"]'));
});
