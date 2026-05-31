// Landing Page GSAP Animations

// Register ScrollTrigger Plugin
gsap.registerPlugin(ScrollTrigger);

// ===== MOBILE MENU TOGGLE =====
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');

    // Animate menu appearance
    if (!mobileMenu.classList.contains('hidden')) {
      gsap.fromTo(mobileMenu,
        { opacity: 0, y: -10 },
        { opacity: 1, y: 0, duration: 0.3 }
      );
    }
  });
}

// Close mobile menu when clicking a link
document.querySelectorAll('#mobileMenu a').forEach(link => {
  link.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
  });
});

// ===== HERO SECTION ANIMATIONS =====
const heroTimeline = gsap.timeline({
  defaults: { duration: 0.8, ease: 'power3.out' }
});

heroTimeline
  .from('.hero-content h1', { opacity: 0, y: 30 }, 0)
  .from('.hero-content p', { opacity: 0, y: 30 }, 0.2)
  .from('.hero-content button', { opacity: 0, scale: 0.9 }, 0.4)
  .from('.hero-image', { opacity: 0, x: 50 }, 0.2);

// Animate hero image box
gsap.to('.hero-image', {
  y: -20,
  duration: 3,
  repeat: -1,
  yoyo: true,
  ease: 'sine.inOut'
});

// ===== FEATURE CARDS SCROLL ANIMATION =====
gsap.utils.toArray('.feature-card').forEach((card, index) => {
  gsap.from(card, {
    scrollTrigger: {
      trigger: card,
      start: 'top bottom-=100',
      toggleActions: 'play none none none'
    },
    opacity: 0,
    y: 50,
    duration: 0.6,
    delay: index * 0.1
  });
});

// Feature card hover effect with GSAP
document.querySelectorAll('.feature-card').forEach(card => {
  card.addEventListener('mouseenter', () => {
    gsap.to(card, {
      y: -15,
      boxShadow: '0 20px 40px rgba(16, 185, 129, 0.3)',
      duration: 0.3,
      overwrite: 'auto'
    });

    // Pulse the icon
    gsap.to(card.querySelector('.w-12'), {
      scale: 1.3,
      duration: 0.4,
      ease: 'back.out'
    });
  });

  card.addEventListener('mouseleave', () => {
    gsap.to(card, {
      y: 0,
      boxShadow: '0 0 0px rgba(16, 185, 129, 0)',
      duration: 0.3
    });

    gsap.to(card.querySelector('.w-12'), {
      scale: 1,
      duration: 0.3
    });
  });
});

// ===== SECTION REVEAL ANIMATIONS =====
gsap.utils.toArray('section').forEach((section, index) => {
  if (index > 0) {
    gsap.from(section, {
      scrollTrigger: {
        trigger: section,
        start: 'top bottom-=150',
        toggleActions: 'play none none none',
        markers: false
      },
      opacity: 0,
      y: 50,
      duration: 0.8
    });
  }
});

// ===== SERVICE ITEM ANIMATIONS =====
gsap.utils.toArray('.service-item').forEach((item, index) => {
  gsap.from(item, {
    scrollTrigger: {
      trigger: item,
      start: 'top bottom-=100',
      toggleActions: 'play none none none'
    },
    opacity: 0,
    x: index % 2 === 0 ? -50 : 50,
    duration: 0.8
  });
});

// ===== PRICING CARD ANIMATIONS =====
gsap.utils.toArray('.pricing-card').forEach((card, index) => {
  gsap.from(card, {
    scrollTrigger: {
      trigger: card,
      start: 'top bottom-=50',
      toggleActions: 'play none none none'
    },
    opacity: 0,
    y: 50,
    duration: 0.6,
    delay: index * 0.15
  });

  // Hover animation
  card.addEventListener('mouseenter', () => {
    gsap.to(card, {
      y: -15,
      duration: 0.3,
      overwrite: 'auto'
    });
  });

  card.addEventListener('mouseleave', () => {
    gsap.to(card, {
      y: 0,
      duration: 0.3
    });
  });
});

// ===== TESTIMONIAL ANIMATIONS =====
gsap.utils.toArray('.testimonial').forEach((testimonial, index) => {
  gsap.from(testimonial, {
    scrollTrigger: {
      trigger: testimonial,
      start: 'top bottom-=100',
      toggleActions: 'play none none none'
    },
    opacity: 0,
    scale: 0.8,
    duration: 0.6,
    delay: index * 0.1
  });

  // Hover effect
  testimonial.addEventListener('mouseenter', () => {
    gsap.to(testimonial, {
      y: -8,
      duration: 0.3,
      overwrite: 'auto'
    });
  });

  testimonial.addEventListener('mouseleave', () => {
    gsap.to(testimonial, {
      y: 0,
      duration: 0.3
    });
  });
});

// ===== FAQ ACCORDION ANIMATIONS =====
document.querySelectorAll('.faq-item').forEach(item => {
  const button = item.querySelector('.faq-button');
  const content = item.querySelector('.faq-content');
  const icon = item.querySelector('.faq-icon');

  button.addEventListener('click', () => {
    const isActive = item.classList.contains('active');

    // Close other open FAQs
    document.querySelectorAll('.faq-item.active').forEach(openItem => {
      if (openItem !== item) {
        openItem.classList.remove('active');
        gsap.to(openItem.querySelector('.faq-content'), {
          opacity: 0,
          height: 0,
          duration: 0.3,
          ease: 'power2.inOut',
          onComplete: () => {
            openItem.querySelector('.faq-content').classList.add('hidden');
          }
        });

        gsap.to(openItem.querySelector('.faq-icon'), {
          rotation: 0,
          duration: 0.3
        });
      }
    });

    // Toggle current item
    item.classList.toggle('active');

    if (!isActive) {
      content.classList.remove('hidden');
      gsap.fromTo(content,
        { opacity: 0, height: 0 },
        { opacity: 1, height: 'auto', duration: 0.3, ease: 'power2.inOut' }
      );

      gsap.to(icon, {
        rotation: 45,
        duration: 0.3
      });
    } else {
      gsap.to(content, {
        opacity: 0,
        height: 0,
        duration: 0.3,
        ease: 'power2.inOut',
        onComplete: () => {
          content.classList.add('hidden');
        }
      });

      gsap.to(icon, {
        rotation: 0,
        duration: 0.3
      });
    }
  });
});

// ===== CTA BUTTONS HOVER EFFECTS =====
document.querySelectorAll('button').forEach(button => {
  button.addEventListener('mouseenter', function () {
    gsap.to(this, {
      scale: 1.05,
      duration: 0.2,
      overwrite: 'auto'
    });
  });

  button.addEventListener('mouseleave', function () {
    gsap.to(this, {
      scale: 1,
      duration: 0.2
    });
  });
});

// ===== SCROLL-TO-SECTION =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));

    if (target) {
      gsap.to(window, {
        scrollTo: {
          y: target,
          autoKill: false
        },
        duration: 1,
        ease: 'power3.inOut'
      });
    }
  });
});

// ===== NUMBER COUNTER ANIMATION =====
const animateCounter = (element, target, duration = 2) => {
  let count = 0;
  const increment = target / (duration * 60);

  const timer = setInterval(() => {
    count += increment;
    if (count >= target) {
      element.textContent = Math.round(target);
      clearInterval(timer);
    } else {
      element.textContent = Math.round(count);
    }
  }, 1000 / 60);
};

// ===== PARALLAX SCROLL EFFECT =====
document.addEventListener('scroll', () => {
  const scrolled = window.pageYOffset;
  const parallaxElements = document.querySelectorAll('[data-parallax]');

  parallaxElements.forEach(element => {
    const speed = element.getAttribute('data-parallax');
    element.style.transform = `translateY(${scrolled * speed}px)`;
  });
});

// ===== STAGGER ANIMATION ON PAGE LOAD =====
gsap.utils.toArray('h2').forEach((heading, index) => {
  gsap.from(heading, {
    scrollTrigger: {
      trigger: heading,
      start: 'top bottom-=100',
      toggleActions: 'play none none none'
    },
    opacity: 0,
    y: 20,
    duration: 0.6,
    ease: 'power2.out'
  });
});

// ===== GRADIENT ANIMATION =====
const animateGradient = () => {
  const gradientElements = document.querySelectorAll('.bg-gradient-to-r');

  gradientElements.forEach(element => {
    gsap.to(element, {
      backgroundPosition: '200% center',
      duration: 8,
      repeat: -1,
      yoyo: true
    });
  });
};

// Call on load
window.addEventListener('load', () => {
  animateGradient();

  // Refresh ScrollTrigger after images load
  ScrollTrigger.refresh();
});

// ===== PERFORMANCE OPTIMIZATION: Debounce ScrollTrigger =====
window.addEventListener('resize', () => {
  ScrollTrigger.refresh();
});

// ===== INITIAL ANIMATIONS ON LOAD =====
window.addEventListener('load', () => {
  // Fade in body
  gsap.to('body', {
    opacity: 1,
    duration: 0.5
  });

  // Refresh all scroll triggers
  ScrollTrigger.refresh();
});

// Log animations loaded (for debugging)
console.log('✨ Landing page animations loaded successfully!');
