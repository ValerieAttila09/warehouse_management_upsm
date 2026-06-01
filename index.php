<!DOCTYPE html>
<html lang="en">
<?php include "./contents/header.php"; ?>
<body class="bg-slate-900 text-gray-100">

<!-- Navigation Bar -->
<nav class="fixed top-0 w-full bg-slate-900/95 backdrop-blur-md z-50 border-b border-slate-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <div class="flex items-center space-x-2">
        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg flex items-center justify-center font-bold text-slate-900">W</div>
        <span class="text-xl font-bold">Warehouse</span>
      </div>
      
      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-8">
        <a href="#features" class="hover:text-emerald-400 transition duration-300">Features</a>
        <a href="#services" class="hover:text-emerald-400 transition duration-300">Services</a>
        <a href="#pricing" class="hover:text-emerald-400 transition duration-300">Pricing</a>
        <a href="#faq" class="hover:text-emerald-400 transition duration-300">FAQ</a>
      </div>
      
      <!-- CTA Button -->
      <button class="hidden md:block px-6 py-2 bg-emerald-500 hover:bg-emerald-600 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
        Get Started
      </button>
      
      <!-- Mobile Menu Button -->
      <button id="mobileMenuBtn" class="md:hidden text-gray-300 hover:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </div>
</nav>

<!-- Mobile Menu -->
<div id="mobileMenu" class="hidden fixed top-16 left-0 right-0 bg-slate-800 md:hidden z-40 border-b border-slate-700">
  <div class="px-4 py-4 space-y-2">
    <a href="#features" class="block px-4 py-2 hover:bg-slate-700 rounded">Features</a>
    <a href="#services" class="block px-4 py-2 hover:bg-slate-700 rounded">Services</a>
    <a href="#pricing" class="block px-4 py-2 hover:bg-slate-700 rounded">Pricing</a>
    <a href="#faq" class="block px-4 py-2 hover:bg-slate-700 rounded">FAQ</a>
    <button class="w-full mt-4 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 rounded font-semibold">Get Started</button>
  </div>
</div>

<!-- Hero Section -->
<section class="pt-40 pb-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
  <!-- Background Elements -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="hero-grid"></div>
  </div>
  
  <div class="max-w-7xl mx-auto relative z-10">
    <div class="grid md:grid-cols-2 gap-12 items-center">
      <!-- Left Content -->
      <div class="hero-content">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
          Tailored Fulfillment for <span class="bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">E-Commerce Success</span>
        </h1>
        <p class="text-lg text-gray-400 mb-8">
          Streamline your logistics operations with our cutting-edge warehouse management solution. Complete satisfaction with tailored fulfillment.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <button class="cta-button px-8 py-3 bg-emerald-500 hover:bg-emerald-600 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
            Book a Meeting
          </button>
          <button class="px-8 py-3 border-2 border-emerald-500 text-emerald-400 hover:bg-emerald-500/10 rounded-lg font-semibold transition duration-300">
            Learn More
          </button>
        </div>
      </div>
      
      <!-- Right Hero Image -->
      <div class="hero-image hidden md:block">
        <div class="relative w-full h-96">
          <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-cyan-500/20 rounded-3xl blur-3xl"></div>
          <div class="relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 border border-slate-700 h-full flex items-center justify-center">
            <div class="text-center">
              <div class="text-6xl font-bold bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent mb-4">📦</div>
              <p class="text-gray-400">Smart Warehouse Solutions</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-slate-900 to-slate-800">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Our Platform?</h2>
      <p class="text-gray-400 max-w-2xl mx-auto">Experience the power of modern warehouse management with features designed for e-commerce excellence</p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Feature Card 1 -->
      <div class="feature-card group p-8 bg-slate-800/50 border border-slate-700 rounded-2xl hover:border-emerald-500/50 transition duration-300 cursor-pointer">
        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg mb-4 flex items-center justify-center text-xl">⚡</div>
        <h3 class="text-xl font-bold mb-3">Real-time Tracking</h3>
        <p class="text-gray-400">Monitor your inventory and orders in real-time with our advanced tracking system</p>
      </div>
      
      <!-- Feature Card 2 -->
      <div class="feature-card group p-8 bg-slate-800/50 border border-slate-700 rounded-2xl hover:border-emerald-500/50 transition duration-300 cursor-pointer">
        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg mb-4 flex items-center justify-center text-xl">🔄</div>
        <h3 class="text-xl font-bold mb-3">Seamless Integration</h3>
        <p class="text-gray-400">Connect with your existing systems effortlessly for a unified workflow</p>
      </div>
      
      <!-- Feature Card 3 -->
      <div class="feature-card group p-8 bg-slate-800/50 border border-slate-700 rounded-2xl hover:border-emerald-500/50 transition duration-300 cursor-pointer">
        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg mb-4 flex items-center justify-center text-xl">📊</div>
        <h3 class="text-xl font-bold mb-3">Advanced Analytics</h3>
        <p class="text-gray-400">Get insights into your operations with comprehensive analytics and reporting</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section 1 -->
<section class="py-20 px-4 sm:px-6 lg:px-8">
  <div class="max-w-6xl mx-auto">
    <div class="bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 rounded-3xl p-8 md:p-12 overflow-hidden relative">
      <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500 rounded-full blur-3xl"></div>
      </div>
      <div class="relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Effortlessly Simplify Your E-Commerce Fulfillment</h2>
        <p class="text-gray-400 text-lg mb-8 max-w-2xl">Reduce operational costs and improve customer satisfaction with our automated fulfillment solutions</p>
        <button class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
          Start Your Journey
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-800">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold mb-16 text-center">Our Services</h2>
    
    <!-- Service Items -->
    <div class="space-y-12">
      <!-- Service 1 -->
      <div class="service-item grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h3 class="text-2xl font-bold mb-4">Warehouse Technology Integration</h3>
          <p class="text-gray-400 mb-4">Leverage the latest warehouse management technology to streamline your operations with real-time visibility and control</p>
          <ul class="space-y-2 text-gray-400">
            <li>✓ Automated inventory tracking</li>
            <li>✓ Smart order routing</li>
            <li>✓ IoT sensor integration</li>
          </ul>
        </div>
        <div class="service-image bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl h-72 flex items-center justify-center border border-slate-600">
          <div class="text-5xl">🏭</div>
        </div>
      </div>
      
      <!-- Service 2 -->
      <div class="service-item grid md:grid-cols-2 gap-8 items-center md:grid-flow-dense">
        <div class="service-image bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl h-72 flex items-center justify-center border border-slate-600">
          <div class="text-5xl">🚚</div>
        </div>
        <div>
          <h3 class="text-2xl font-bold mb-4">Returns Handling</h3>
          <p class="text-gray-400 mb-4">Efficiently manage returns with our comprehensive return management system that improves customer satisfaction</p>
          <ul class="space-y-2 text-gray-400">
            <li>✓ Automated return processing</li>
            <li>✓ Quality inspections</li>
            <li>✓ Refund management</li>
          </ul>
        </div>
      </div>
      
      <!-- Service 3 -->
      <div class="service-item grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h3 class="text-2xl font-bold mb-4">Fast Order Processing</h3>
          <p class="text-gray-400 mb-4">Process orders at lightning speed with our optimized workflow system that ensures quick turnaround times</p>
          <ul class="space-y-2 text-gray-400">
            <li>✓ 24/7 order processing</li>
            <li>✓ Multi-channel support</li>
            <li>✓ Delivery commitment</li>
          </ul>
        </div>
        <div class="service-image bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl h-72 flex items-center justify-center border border-slate-600">
          <div class="text-5xl">⚡</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section 2 -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-900">
  <div class="max-w-6xl mx-auto">
    <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-3xl p-12 text-slate-900">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Experience Next-Level Fulfillment</h2>
          <p class="text-slate-800 mb-6">Transform your warehouse operations with our comprehensive solution</p>
          <button class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-emerald-400 rounded-lg font-semibold transition duration-300">
            Get Started Today
          </button>
        </div>
        <div class="flex items-center justify-center">
          <div class="text-7xl">📈</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-800">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">Flexible Plans for Every Stage of Growth</h2>
      <p class="text-gray-400">Choose the perfect plan that fits your business needs</p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Starter Plan -->
      <div class="pricing-card p-8 bg-slate-800 border border-slate-700 rounded-2xl hover:border-emerald-500/50 hover:shadow-2xl transition duration-300">
        <h3 class="text-xl font-bold mb-2">Starter Plan</h3>
        <div class="text-4xl font-bold mb-4">$99 <span class="text-lg text-gray-400">/month</span></div>
        <ul class="space-y-3 mb-8 text-gray-400">
          <li>✓ Upto 1000 SKUs</li>
          <li>✓ Basic Reporting</li>
          <li>✓ Email Support</li>
          <li>✗ Advanced Analytics</li>
        </ul>
        <button class="w-full py-2 border border-emerald-500 text-emerald-400 rounded-lg hover:bg-emerald-500/10 transition">Get Started</button>
      </div>
      
      <!-- Professional Plan -->
      <div class="pricing-card p-8 bg-gradient-to-br from-slate-700 to-slate-800 border-2 border-emerald-500/50 rounded-2xl shadow-xl">
        <div class="text-emerald-400 font-semibold mb-2">MOST POPULAR</div>
        <h3 class="text-xl font-bold mb-2">Professional Plan</h3>
        <div class="text-4xl font-bold mb-4">$199 <span class="text-lg text-gray-400">/month</span></div>
        <ul class="space-y-3 mb-8 text-gray-400">
          <li>✓ Upto 10,000 SKUs</li>
          <li>✓ Advanced Analytics</li>
          <li>✓ Priority Support</li>
          <li>✓ API Access</li>
        </ul>
        <button class="w-full py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition">Start Free Trial</button>
      </div>
      
      <!-- Enterprise Plan -->
      <div class="pricing-card p-8 bg-slate-800 border border-slate-700 rounded-2xl hover:border-emerald-500/50 hover:shadow-2xl transition duration-300">
        <h3 class="text-xl font-bold mb-2">Enterprise Plan</h3>
        <div class="text-4xl font-bold mb-4">$299 <span class="text-lg text-gray-400">/month</span></div>
        <ul class="space-y-3 mb-8 text-gray-400">
          <li>✓ Unlimited SKUs</li>
          <li>✓ Custom Integration</li>
          <li>✓ 24/7 Support</li>
          <li>✓ Dedicated Account Manager</li>
        </ul>
        <button class="w-full py-2 border border-emerald-500 text-emerald-400 rounded-lg hover:bg-emerald-500/10 transition">Contact Sales</button>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-900">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center">Frequently Asked Questions</h2>
    
    <div class="space-y-4">
      <!-- FAQ Item 1 -->
      <div class="faq-item bg-slate-800 border border-slate-700 rounded-lg overflow-hidden">
        <button class="faq-button w-full px-6 py-4 flex justify-between items-center hover:bg-slate-700/50 transition">
          <span class="text-lg font-semibold">Do you support multiple warehouses?</span>
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-content hidden px-6 pb-4 text-gray-400">
          Yes, our platform supports unlimited warehouses across different locations, enabling seamless multi-facility operations and inventory synchronization.
        </div>
      </div>
      
      <!-- FAQ Item 2 -->
      <div class="faq-item bg-slate-800 border border-slate-700 rounded-lg overflow-hidden">
        <button class="faq-button w-full px-6 py-4 flex justify-between items-center hover:bg-slate-700/50 transition">
          <span class="text-lg font-semibold">Can I track my orders in real-time?</span>
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-content hidden px-6 pb-4 text-gray-400">
          Absolutely! Get real-time tracking of all orders from warehouse to customer doorstep with detailed status updates and notifications.
        </div>
      </div>
      
      <!-- FAQ Item 3 -->
      <div class="faq-item bg-slate-800 border border-slate-700 rounded-lg overflow-hidden">
        <button class="faq-button w-full px-6 py-4 flex justify-between items-center hover:bg-slate-700/50 transition">
          <span class="text-lg font-semibold">How does the system handle returns?</span>
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-content hidden px-6 pb-4 text-gray-400">
          Our automated return management system processes returns efficiently with quality checks, inventory updates, and refund management all in one place.
        </div>
      </div>
      
      <!-- FAQ Item 4 -->
      <div class="faq-item bg-slate-800 border border-slate-700 rounded-lg overflow-hidden">
        <button class="faq-button w-full px-6 py-4 flex justify-between items-center hover:bg-slate-700/50 transition">
          <span class="text-lg font-semibold">What kind of support do you offer?</span>
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-content hidden px-6 pb-4 text-gray-400">
          We provide 24/7 customer support via email, chat, and phone. Enterprise customers get a dedicated account manager for personalized assistance.
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-slate-800 to-slate-900">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center">The Fully Built Client Experience</h2>
    
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Testimonial 1 -->
      <div class="testimonial bg-slate-800/50 border border-slate-700 rounded-2xl p-8 hover:border-emerald-500/30 transition">
        <div class="flex mb-4">
          ⭐⭐⭐⭐⭐
        </div>
        <p class="text-gray-400 mb-6">"Warehouse Solutions transformed our fulfillment process. We've seen a 40% improvement in order processing speed."</p>
        <div class="flex items-center">
          <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-full"></div>
          <div class="ml-3">
            <p class="font-semibold">Sarah Johnson</p>
            <p class="text-sm text-gray-500">CEO, E-Commerce Plus</p>
          </div>
        </div>
      </div>
      
      <!-- Testimonial 2 -->
      <div class="testimonial bg-slate-800/50 border border-slate-700 rounded-2xl p-8 hover:border-emerald-500/30 transition">
        <div class="flex mb-4">
          ⭐⭐⭐⭐⭐
        </div>
        <p class="text-gray-400 mb-6">"The integration was seamless, and the ROI was immediate. Highly recommend for any e-commerce business."</p>
        <div class="flex items-center">
          <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-full"></div>
          <div class="ml-3">
            <p class="font-semibold">Mike Chen</p>
            <p class="text-sm text-gray-500">Founder, Digital Retail Co</p>
          </div>
        </div>
      </div>
      
      <!-- Testimonial 3 -->
      <div class="testimonial bg-slate-800/50 border border-slate-700 rounded-2xl p-8 hover:border-emerald-500/30 transition">
        <div class="flex mb-4">
          ⭐⭐⭐⭐⭐
        </div>
        <p class="text-gray-400 mb-6">"Outstanding support team and powerful features. This is the platform we've been looking for."</p>
        <div class="flex items-center">
          <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-full"></div>
          <div class="ml-3">
            <p class="font-semibold">Emma Rodriguez</p>
            <p class="text-sm text-gray-500">Operations Manager, Global Shop</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-slate-950 border-t border-slate-800 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="grid md:grid-cols-4 gap-8 mb-8">
      <div>
        <div class="flex items-center space-x-2 mb-4">
          <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg"></div>
          <span class="font-bold">Warehouse</span>
        </div>
        <p class="text-gray-500 text-sm">Tailored fulfillment solutions for e-commerce success</p>
      </div>
      
      <div>
        <h4 class="font-semibold mb-4">Product</h4>
        <ul class="space-y-2 text-gray-500 text-sm">
          <li><a href="#" class="hover:text-emerald-400 transition">Features</a></li>
          <li><a href="#" class="hover:text-emerald-400 transition">Pricing</a></li>
          <li><a href="#" class="hover:text-emerald-400 transition">Security</a></li>
        </ul>
      </div>
      
      <div>
        <h4 class="font-semibold mb-4">Company</h4>
        <ul class="space-y-2 text-gray-500 text-sm">
          <li><a href="#" class="hover:text-emerald-400 transition">About</a></li>
          <li><a href="#" class="hover:text-emerald-400 transition">Blog</a></li>
          <li><a href="#" class="hover:text-emerald-400 transition">Careers</a></li>
        </ul>
      </div>
      
      <div>
        <h4 class="font-semibold mb-4">Contact</h4>
        <ul class="space-y-2 text-gray-500 text-sm">
          <li>Email: info@warehouse.com</li>
          <li>Phone: +1 (555) 123-4567</li>
          <li>Address: 123 Commerce St</li>
        </ul>
      </div>
    </div>
    
    <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm">
      <p>&copy; 2024 Warehouse Solutions. All rights reserved.</p>
      <div class="flex space-x-6 mt-4 md:mt-0">
        <a href="#" class="hover:text-emerald-400 transition">Privacy Policy</a>
        <a href="#" class="hover:text-emerald-400 transition">Terms of Service</a>
        <a href="#" class="hover:text-emerald-400 transition">Contact Us</a>
      </div>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="./js/landing-animations.js"></script>
</body>
</html>
