<?php
/**
 * Plugin Name: Custom Config
 * Plugin URI:  https://github.com/jamshidpour/wp-custom-config
 * Description: کانفیگ سفارشی و اختصاصی وب شیک برای وردپرس
 * Version:     1.0.0
 * Author:      وب شیک
 * Author URI:  https://webshik.com
 * Text Domain: custom-config
 * Domain Path: /languages
 * License:     GPL v2 or later
 */

if (!defined('ABSPATH')) exit;

add_action('wp_footer', 'custom_category_description_trimmer_script');

function custom_category_description_trimmer_script() {
    if (!is_product_category()) return;

    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const descWrapper = document.querySelector(".term-description");
        if (!descWrapper) return;

        const originalHTML = descWrapper.innerHTML;
        const text = descWrapper.innerText || descWrapper.textContent;
        const words = text.trim().split(/\s+/);

        const maxWords = 300;
        if (words.length <= maxWords) return;

        const trimmedText = words.slice(0, maxWords).join(" ") + " ...";

        // ساخت عناصر جدید
        const shortDiv = document.createElement("div");
        shortDiv.classList.add("short-description");
        shortDiv.innerHTML = `<p>${trimmedText}</p><button class="toggle-description-btn">ادامه توضیحات</button>`;

        const fullDiv = document.createElement("div");
        fullDiv.classList.add("full-description");
        fullDiv.innerHTML = originalHTML + `<button class="toggle-description-btn">بستن توضیحات</button>`;
        fullDiv.style.display = "none";

        // پاک‌کردن توضیح اصلی و افزودن دوتا div جدید
        descWrapper.innerHTML = '';
        descWrapper.appendChild(shortDiv);
        descWrapper.appendChild(fullDiv);

        // مدیریت کلیک دکمه‌ها
        descWrapper.querySelectorAll(".toggle-description-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                const isShortVisible = shortDiv.style.display !== "none";
                shortDiv.style.display = isShortVisible ? "none" : "block";
                fullDiv.style.display = isShortVisible ? "block" : "none";
            });
        });
    });
    </script>

    <style>
    .toggle-description-btn {
        margin-top: 10px;
		border: 1px solid #FF0000;
        color: #ff0000;
		background-color: transparent;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 35px;
        font-size: 14px;
    }

    .toggle-description-btn:hover {
		color: #fff;
        background-color: #ff0000;
    }

    .term-description {
        position: relative;
    }
    </style>
    <?php
}
