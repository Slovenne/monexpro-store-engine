# WooCommerce Custom AJAX Store Engine (MonexPro)

A high-performance, lightweight, and fully customized WooCommerce catalog plugin engineered in Core PHP and Vanilla JavaScript (ES6+). This engine completely decouples the store presentation layer from heavy page builders, achieving drastic speed optimizations and a fluid UI/UX.

## 🚀 Core Features & Architecture

* **Decoupled Asynchronous Requests:** Bypasses heavy jQuery dependencies by utilizing the modern Vanilla JavaScript `Fetch API` and `FormData` to handle catalog sorting and filtering natively via WordPress asynchronous hooks (`admin-ajax.php`).
* **Dynamic Template Injection:** Leverages deep WooCommerce internal layouts manipulation through `wc_get_template` overrides to dynamically inject custom optimized product cards with zero layout shifting.
* **Smart UI Hover Matrix:** Implements an ultra-lightweight client-side image gallery slider listening to mouse positions (`onmousemove`), swapping JSON image source arrays (`data-gallery`) in real-time with responsive positional active-state indicator dots.
* **Native Context-Aware Layouts:** Designed with dynamic direction handlers (`RTL/LTR`) injectively applied via tailored body classes, providing perfect, automated visual conversion between French and Arabic interfaces.
* **Full Form Security Integration:** Guarded natively via cryptographic token verification architectures (`wp_nonce_field` and `wp_verify_nonce`) preventing standard CSRF vulnerabilities.

## 🛠️ Tech Stack & Standards
* **Backend:** PHP Core (WordPress & WooCommerce Core Hook Engineering)
* **Frontend:** Vanilla JavaScript (ES6, Async/Await), Tailwind CSS, Lucide Icons Framework
* **Performance Focus:** Minimal DB Overhead, Zero Bulky Plugin Bloat, Highly Scalable Structural Execution
