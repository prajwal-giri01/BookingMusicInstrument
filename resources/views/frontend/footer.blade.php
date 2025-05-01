<!-- Footer -->
<footer class="site-footer">
    <!-- Main Footer Content -->
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <i class="bi bi-music-note-beamed"></i>
                            <span>Sound System</span>
                        </div>
                        <p class="footer-about">Experience premium musical instrument rentals with flexible plans, doorstep delivery, and exceptional service. Find your perfect sound with just a few clicks.</p>
                    </div>

                    <!-- Social Media -->
                    <div class="footer-social">
                        <h6 class="footer-heading">Follow Us</h6>
                        <div class="social-icons">
                            <a href="#" class="social-icon" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-icon" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-icon" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-heading">Contact Us</h6>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <div>
                                <span>123 Music Street</span>
                                <span>Kathmandu, 44600, Nepal</span>
                            </div>
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <div>
                                <span>+977 234 567 88</span>
                                <span>Mon-Fri, 9:00 AM - 6:00 PM</span>
                            </div>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <div>
                                <span>info@musicrental.com</span>
                                <span>Support 24/7</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">© 2024 MusicRental. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Custom Footer Styles -->
<style>
    /* Footer Styles */
    .site-footer {
        background-color: #1A1A2E;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Newsletter Section */
    .newsletter-section {
        background-color: #16162A;
        padding: 1rem 0;
    }

    .newsletter-container {
        background: linear-gradient(135deg, rgba(199, 178, 153, 0.1) 0%, rgba(199, 178, 153, 0.2) 100%);
        border-radius: 16px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .newsletter-container::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(199, 178, 153, 0.2) 0%, rgba(199, 178, 153, 0) 70%);
    }

    .newsletter-container::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(199, 178, 153, 0.2) 0%, rgba(199, 178, 153, 0) 70%);
    }

    .newsletter-title {
        color: #fff;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .newsletter-text {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
    }

    .newsletter-form .form-control {
        height: 50px;
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 50px 0 0 50px;
        padding: 0 1.5rem;
    }

    .newsletter-form .form-control:focus {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: #C7B299;
        box-shadow: none;
    }

    .newsletter-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .btn-subscribe {
        background-color: #C7B299;
        color: #1A1A2E;
        font-weight: 600;
        border-radius: 0 50px 50px 0;
        padding: 0 1.5rem;
        height: 50px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-subscribe:hover {
        background-color: #E6CCB2;
    }

    .btn-subscribe i {
        margin-left: 0.5rem;
        transition: transform 0.3s ease;
    }

    .btn-subscribe:hover i {
        transform: translateX(4px);
    }

    /* Main Footer Content */
    .footer-content {
        padding: 5rem 0 3rem;
        position: relative;
    }

    .footer-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right,
        rgba(199, 178, 153, 0) 0%,
        rgba(199, 178, 153, 0.5) 50%,
        rgba(199, 178, 153, 0) 100%);
    }

    /* Footer Brand */
    .footer-brand {
        margin-bottom: 2rem;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .footer-logo i {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #C7B299;
        color: #1A1A2E;
        border-radius: 50%;
        font-size: 1.25rem;
        margin-right: 0.75rem;
    }

    .footer-logo span {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(90deg, #C7B299, #E6CCB2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .footer-about {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 2rem;
        max-width: 350px;
    }

    /* Footer Headings */
    .footer-heading {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }

    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background-color: #C7B299;
    }

    /* Social Icons */
    .social-icons {
        display: flex;
        gap: 1rem;
    }

    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-radius: 50%;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background-color: #C7B299;
        color: #1A1A2E;
        transform: translateY(-3px);
    }

    /* Footer Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 1.25rem;
        display: inline-block;
    }

    .footer-links a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #C7B299;
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #C7B299;
        transform: translateX(5px);
    }

    .footer-links a:hover::before {
        opacity: 1;
        width: 8px;
        height: 8px;
    }

    /* Contact Info */
    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-contact li {
        display: flex;
        margin-bottom: 1.25rem;
    }

    .footer-contact i {
        color: #C7B299;
        font-size: 1.25rem;
        margin-right: 1rem;
        margin-top: 0.25rem;
    }

    .footer-contact div {
        display: flex;
        flex-direction: column;
    }

    .footer-contact div span:first-child {
        color: #fff;
        margin-bottom: 0.25rem;
    }

    .footer-contact div span:last-child {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
    }

    /* Footer Bottom */
    .footer-bottom {
        background-color: #16162A;
        padding: 1.5rem 0;
        position: relative;
    }

    .footer-bottom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right,
        rgba(199, 178, 153, 0) 0%,
        rgba(199, 178, 153, 0.3) 50%,
        rgba(199, 178, 153, 0) 100%);
    }

    .copyright {
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 0;
    }

    .payment-methods {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .payment-methods span {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .newsletter-container {
            padding: 2rem;
        }

        .newsletter-title {
            font-size: 1.5rem;
        }

        .footer-content {
            padding: 3rem 0 2rem;
        }
    }

    @media (max-width: 767.98px) {
        .newsletter-section {
            padding: 0;
        }

        .newsletter-container {
            border-radius: 0;
            padding: 2rem 1rem;
        }

        .newsletter-form {
            margin-top: 1.5rem;
        }

        .payment-methods {
            justify-content: center;
            margin-top: 1rem;
        }

        .copyright {
            text-align: center;
        }
    }
    /* Flex enhancements for footer columns */
    .footer-content .row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem; /* add spacing between columns */
    }

    .footer-content .col-lg-4,
    .footer-content .col-md-6 {
        flex: 1 1 300px; /* flexible basis for columns */
        min-width: 250px;
    }

    /* Ensure full width on mobile */
    @media (max-width: 767.98px) {
        .footer-content .row {
            flex-direction: column;
            align-items: stretch;
        }
    }

    /* Animation for footer elements */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .footer-content .row > div {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .footer-content .row > div:nth-child(1) {
        animation-delay: 0.1s;
    }

    .footer-content .row > div:nth-child(2) {
        animation-delay: 0.2s;
    }

    .footer-content .row > div:nth-child(3) {
        animation-delay: 0.3s;
    }

    .footer-content .row > div:nth-child(4) {
        animation-delay: 0.4s;
    }
</style>
