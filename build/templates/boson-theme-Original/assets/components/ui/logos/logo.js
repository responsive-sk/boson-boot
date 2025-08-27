import {css, html, LitElement} from 'lit';
import {sharedStyles} from "../../../utils/sharedStyles.js";

export class BosonLogo extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo-text {
            font-size: clamp(24px, 8vw, 64px);
            font-weight: bold;
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease;
            cursor: pointer;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            white-space: nowrap;
        }

        .logo-text:hover {
            transform: scale(1.05);
        }

        .responsive {
            color: #F93904;
        }

        .sk {
            color: white;
        }

        .animated-dots {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-dot {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #F93904;
            border-radius: 50%;
            opacity: 0;
            animation: float 3s infinite ease-in-out;
        }

        .floating-dot:nth-child(2n) {
            background: rgba(255, 255, 255, 0.8);
            animation-delay: 0.5s;
        }

        .floating-dot:nth-child(3n) {
            animation-delay: 1s;
        }

        .floating-dot:nth-child(4n) {
            animation-delay: 1.5s;
        }

        .floating-dot:nth-child(5n) {
            animation-delay: 2s;
        }

        @keyframes float {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.5);
            }
            50% {
                opacity: 1;
                transform: translateY(-10px) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-40px) scale(0.5);
            }
        }

        @media (max-width: 768px) {
            .logo-text {
                font-size: clamp(18px, 6vw, 32px);
            }
        }




    `];

    constructor() {
        super();
        this.animationInterval = null;
    }

    firstUpdated() {
        this.startFloatingDots();
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this.animationInterval) {
            clearInterval(this.animationInterval);
        }
    }

    startFloatingDots() {
        const container = this.shadowRoot.querySelector('.animated-dots');
        if (!container) return;

        this.animationInterval = setInterval(() => {
            this.createFloatingDot(container);
        }, 800);
    }

    createFloatingDot(container) {
        const dot = document.createElement('div');
        dot.className = 'floating-dot';

        // Random position around the logo
        const x = Math.random() * 100;
        const y = Math.random() * 100;

        dot.style.left = `${x}%`;
        dot.style.top = `${y}%`;

        container.appendChild(dot);

        // Remove dot after animation
        setTimeout(() => {
            if (dot.parentNode) {
                dot.parentNode.removeChild(dot);
            }
        }, 3000);
    }




    render() {
        return html`
            <div class="container">
                <div class="logo-text">
                    <span class="responsive">responsive</span><span class="sk">.sk</span>
                </div>
                <div class="animated-dots"></div>
            </div>
        `;
    }
}

customElements.define('boson-logo', BosonLogo);
