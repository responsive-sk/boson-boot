import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class BosonBreadcrumbs extends LitElement {
    static styles = [sharedStyles, css`
        :host {
            display: block;
            min-height: 94px;
            line-height: 94px;
            border-bottom: solid 1px var(--color-border);
        }

        .breadcrumbs {
            margin: 0 auto;
            width: var(--width-content);
            max-width: var(--width-max);
            display: flex;
            justify-content: flex-start;
        }

        ::slotted(.breadcrumb-item) {
            display: flex;
            align-items: center;
        }

        ::slotted(.breadcrumb-item:not(:last-child))::after {
            content: '/';
            color: var(--color-border);
            padding: 0 1em;
        }

        @media (max-width: 700px) {
            :host {
                display: none;
            }
        }
    `];

    constructor() {
        super();
    }

    render() {
        return html`
            <nav class="breadcrumbs">
                <slot></slot>
            </nav>
        `;
    }
}

customElements.define('boson-breadcrumbs', BosonBreadcrumbs);
