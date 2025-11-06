/**
 * Custom JavaScript for Dashboard - Dinassolution
 * Replaces Bootslander template functionality
 */

(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    if (!header.classList.contains('header-scrolled')) {
      offset -= 20
    }

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Desktop dropdown functionality
   */
  const initDropdowns = () => {
    const dropdowns = document.querySelectorAll('.navbar .dropdown');
    
    dropdowns.forEach(dropdown => {
      const dropdownLink = dropdown.querySelector('a');
      const dropdownMenu = dropdown.querySelector('ul');
      
      if (dropdownLink && dropdownMenu) {
        // Show dropdown on hover
        dropdown.addEventListener('mouseenter', function() {
          if (!select('#navbar').classList.contains('navbar-mobile')) {
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.visibility = 'visible';
            dropdownMenu.style.top = '100%';
          }
        });
        
        // Hide dropdown on mouse leave
        dropdown.addEventListener('mouseleave', function() {
          if (!select('#navbar').classList.contains('navbar-mobile')) {
            dropdownMenu.style.opacity = '0';
            dropdownMenu.style.visibility = 'hidden';
            dropdownMenu.style.top = 'calc(100% + 20px)';
          }
        });
      }
    });
  };

  window.addEventListener('load', initDropdowns);

  /**
   * Scroll with offset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with offset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  /**
   * Animation on scroll (AOS) initialization
   */
  window.addEventListener('load', () => {
    // Simple fade-in animation for elements with data-aos attribute
    const aosElements = document.querySelectorAll('[data-aos]');
    
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('aos-animate');
        }
      });
    }, observerOptions);

    aosElements.forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(30px)';
      el.style.transition = 'all 0.6s ease';
      observer.observe(el);
    });

    // Add animation class when visible
    const style = document.createElement('style');
    style.textContent = `
      .aos-animate {
        opacity: 1 !important;
        transform: translateY(0) !important;
      }
    `;
    document.head.appendChild(style);
  });

  /**
   * Pure Counter replacement - Number counting animation
   */
  const initPureCounter = () => {
    const counters = document.querySelectorAll('.purecounter');
    
    const animateCounter = (counter) => {
      const target = parseInt(counter.getAttribute('data-purecounter-end'));
      const duration = parseInt(counter.getAttribute('data-purecounter-duration')) * 1000;
      const start = parseInt(counter.getAttribute('data-purecounter-start')) || 0;
      const increment = (target - start) / (duration / 16); // 60fps
      
      let current = start;
      const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
          counter.textContent = target;
          clearInterval(timer);
        } else {
          counter.textContent = Math.floor(current);
        }
      }, 16);
    };

    const observerOptions = {
      threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
          entry.target.classList.add('counted');
          animateCounter(entry.target);
        }
      });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
  };

  window.addEventListener('load', initPureCounter);

  /**
   * Glightbox replacement - Simple lightbox functionality
   */
  const initLightbox = () => {
    const lightboxLinks = document.querySelectorAll('.glightbox');
    
    if (lightboxLinks.length === 0) return;

    const createLightbox = (src, type = 'image') => {
      const lightbox = document.createElement('div');
      lightbox.className = 'custom-lightbox';
      lightbox.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: pointer;
      `;

      if (type === 'image') {
        const img = document.createElement('img');
        img.src = src;
        img.style.cssText = 'max-width: 90%; max-height: 90%; border-radius: 10px;';
        lightbox.appendChild(img);
      }

      lightbox.addEventListener('click', () => {
        lightbox.remove();
      });

      document.body.appendChild(lightbox);
    };

    lightboxLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const href = link.getAttribute('href');
        createLightbox(href);
      });
    });
  };

  window.addEventListener('load', initLightbox);

  /**
   * Hero waves animation
   */
  const initHeroWaves = () => {
    const waves = document.querySelectorAll('.hero-waves use');
    waves.forEach((wave, index) => {
      wave.style.animation = `move-forever${index + 1} ${10 - index * 2}s linear infinite`;
      wave.style.animationDelay = '-2s';
    });
  };

  window.addEventListener('load', initHeroWaves);

  /**
   * Initialize Swiper for testimonials
   */
  const initTestimonialsSwiper = () => {
    if (typeof Swiper !== 'undefined') {
      const testimonialsSwiper = new Swiper('.testimonials-slider', {
        speed: 600,
        loop: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false
        },
        slidesPerView: 'auto',
        pagination: {
          el: '.swiper-pagination',
          type: 'bullets',
          clickable: true
        },
        breakpoints: {
          320: {
            slidesPerView: 1,
            spaceBetween: 20
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 30
          },
          1200: {
            slidesPerView: 3,
            spaceBetween: 40
          }
        }
      });
    }
  };

  // Initialize after DOM is loaded and Swiper is available
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTestimonialsSwiper);
  } else {
    initTestimonialsSwiper();
  }

  /**
   * FAQ Accordion functionality
   */
  const initFAQAccordion = () => {
    const faqItems = document.querySelectorAll('.faq-list a[data-bs-toggle="collapse"]');
    
    faqItems.forEach(item => {
      item.addEventListener('click', function(e) {
        e.preventDefault();
        const target = this.getAttribute('data-bs-target');
        const targetEl = document.querySelector(target);
        
        if (targetEl) {
          // Close other items
          document.querySelectorAll('.faq-list .collapse.show').forEach(openItem => {
            if (openItem !== targetEl) {
              openItem.classList.remove('show');
              openItem.previousElementSibling.classList.add('collapsed');
            }
          });
          
          // Toggle current item
          targetEl.classList.toggle('show');
          this.classList.toggle('collapsed');
        }
      });
    });
  };

  window.addEventListener('load', initFAQAccordion);

  /**
   * Form submission handler
   */
  const initFormHandlers = () => {
    const forms = document.querySelectorAll('.php-email-form');
    
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const loadingEl = this.querySelector('.loading');
        const errorEl = this.querySelector('.error-message');
        const sentEl = this.querySelector('.sent-message');
        
        // Show loading
        if (loadingEl) loadingEl.classList.add('d-block');
        if (errorEl) errorEl.classList.remove('d-block');
        if (sentEl) sentEl.classList.remove('d-block');
        
        // Submit form
        const formData = new FormData(this);
        const action = this.getAttribute('action');
        
        fetch(action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (loadingEl) loadingEl.classList.remove('d-block');
          if (sentEl) sentEl.classList.add('d-block');
          this.reset();
        })
        .catch(error => {
          if (loadingEl) loadingEl.classList.remove('d-block');
          if (errorEl) {
            errorEl.textContent = 'Error sending message. Please try again.';
            errorEl.classList.add('d-block');
          }
        });
      });
    });
  };

  window.addEventListener('load', initFormHandlers);

  /**
   * Smooth scroll for anchor links
   */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#' || href === '') return;
      
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const headerOffset = document.querySelector('#header')?.offsetHeight || 0;
        const elementPosition = target.offsetTop;
        const offsetPosition = elementPosition - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

})();

/**
 * Bootstrap-like Collapse functionality (if Bootstrap is not loaded)
 */
if (typeof bootstrap === 'undefined') {
  document.addEventListener('DOMContentLoaded', function() {
    const collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    collapseToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const target = this.getAttribute('data-bs-target');
        const targetEl = document.querySelector(target);
        
        if (targetEl) {
          if (targetEl.classList.contains('show')) {
            targetEl.classList.remove('show');
            targetEl.style.height = '0px';
            this.classList.add('collapsed');
          } else {
            targetEl.classList.add('show');
            targetEl.style.height = targetEl.scrollHeight + 'px';
            this.classList.remove('collapsed');
          }
        }
      });
    });
    
    // Add transition styles
    const style = document.createElement('style');
    style.textContent = `
      .collapse {
        height: 0;
        overflow: hidden;
        transition: height 0.35s ease;
      }
      .collapse.show {
        height: auto;
      }
    `;
    document.head.appendChild(style);
  });
}