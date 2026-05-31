# 🏭 Warehouse Management - Landing Page

## ✨ Fitur Lengkap

Ini adalah **landing page responsif dan interaktif** yang dibangun dengan:

- **Tailwind CSS** - Styling modern dan responsif
- **GSAP (GreenSock Animation Platform)** - Animasi smooth dan profesional
- **ScrollTrigger** - Animasi saat scroll
- **Fully Responsive** - Sempurna di semua ukuran device
- **Dark Theme** - Design modern dengan tema gelap
- **Interactive Elements** - Hover effects, accordion, dan animasi smooth

## 📁 Struktur File

```
warehouse_management.worktrees/
├── index.php                      # Redirect ke landing page
├── landing_page.php              # Main landing page
├── contents/
│   └── header.php                # Header dengan CDN links
├── style/
│   ├── global.css                # Global styles (existing)
│   └── landing.css               # Landing page custom styles
└── js/
    └── landing-animations.js     # GSAP animations
```

## 🚀 Cara Menggunakan

### 1. Akses Landing Page

```
http://localhost/warehouse_management.worktrees/
```

Atau langsung:

```
http://localhost/warehouse_management.worktrees/landing_page.php
```

### 2. Fitur Utama

#### 🎯 Navigation Bar

- Fixed navigation dengan logo
- Menu responsive untuk mobile
- Tombol CTA yang interaktif

#### 🏠 Hero Section

- Headline yang eye-catching dengan gradient
- Animasi fade-in pada load
- Call-to-action buttons
- Floating animation pada hero image

#### ✨ Features Section

- 3 feature cards dengan hover effects
- Animasi scroll reveal
- Icon dengan bounce animation
- Responsive grid

#### 📦 Services Section

- 3 service items dengan staggered animation
- Alternating layout untuk desktop
- Service images dengan float effect
- Fully responsive

#### 💰 Pricing Section

- 3 pricing plans
- Hover effects dan scale animation
- Responsive design untuk mobile
- CTA buttons untuk setiap plan

#### 📋 FAQ Section

- Interactive accordion
- Smooth expand/collapse dengan GSAP
- Icon rotation animation
- Only one FAQ open at a time

#### 💬 Testimonials Section

- 3 customer testimonials
- Rating display
- Hover animation
- Profile pictures dengan gradient

#### 📞 Footer

- Complete footer dengan links
- Responsive grid layout
- Social media ready
- Contact information

## 🎨 Warna & Design System

```
Primary Colors:
- Emerald: #10b981 (Main CTA, accents)
- Cyan: #06b6d4 (Secondary accents)
- Dark BG: #0f172a (Slate-900)
- Card BG: #1e293b (Slate-800)
```

## ⚙️ Animasi GSAP

### Tipe-Tipe Animasi:

1. **Hero Animations**
   - Fade-in dari kiri dan kanan
   - Floating effect pada hero image

2. **Scroll Animations**
   - Fade-in + translate saat scroll ke view
   - Staggered delays untuk multiple elements

3. **Hover Effects**
   - Scale dan translate on hover
   - Shadow dan border color changes
   - Icon animations

4. **Accordion**
   - Smooth expand/collapse
   - Icon rotation
   - Height animation

5. **Button Effects**
   - Scale on hover
   - Smooth transitions

## 📱 Responsive Breakpoints

- **Mobile**: < 768px (md breakpoint)
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

### Mobile Optimizations:

- Hamburger menu
- Stacked grid layouts
- Adjusted font sizes
- Touch-friendly buttons
- Full-width sections

## 🔧 Customization

### Mengubah Warna

Edit di `style/landing.css`:

```css
:root {
  --primary-color: #10b981;
  --secondary-color: #06b6d4;
}
```

### Mengubah Timing Animasi

Edit di `js/landing-animations.js`:

```javascript
gsap.to(element, {
  duration: 0.8, // Change this
  ease: "power3.out",
});
```

### Menambah Konten

Edit `landing_page.php` dan wrap dengan class yang sesuai:

- `feature-card` untuk features
- `service-item` untuk services
- `pricing-card` untuk pricing
- `testimonial` untuk testimonials
- `faq-item` untuk FAQ

## 🎯 SEO Optimization

- Meta tags yang lengkap
- Semantic HTML structure
- Fast loading dengan CDN
- Mobile-friendly design

## 🌐 Dependencies

### CDN Links (included in header.php):

```html
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- GSAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>
```

### Local Resources:

```html
<!-- Custom CSS -->
<link rel="stylesheet" href="./style/landing.css" />

<!-- GSAP Animations -->
<script src="./js/landing-animations.js"></script>
```

## ✅ Browser Support

- Chrome (Latest)
- Firefox (Latest)
- Safari (Latest)
- Edge (Latest)
- Mobile browsers

## 🚀 Performance Tips

1. **Lazy Loading**: Gunakan native lazy loading untuk images
2. **Code Splitting**: Pisahkan JS untuk critical path
3. **CDN**: Semua assets sudah dari CDN
4. **Minification**: Tailwind CSS sudah minified via CDN

## 📸 Sections Overview

### Hero Section

- Bold headline dengan gradient
- Supporting text
- Dual CTA buttons
- Hero image with floating animation

### Features

- 3 key features
- Icons dengan animations
- Hover effects

### Services

- Detailed service descriptions
- Alternating layout
- Service icons

### CTA Section 1

- Attention-grabbing gradient background
- Single CTA
- Icon element

### Pricing

- 3 pricing tiers
- Feature lists
- Different CTA per tier

### FAQ

- 4 common questions
- Expanding answers
- Icon rotation

### Testimonials

- 3 customer reviews
- Star ratings
- Profile info

### Footer

- Company info
- Navigation links
- Social media (ready)
- Contact info

## 🎓 Learning Resources

- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [GSAP Docs](https://greensock.com/gsap/)
- [ScrollTrigger](https://greensock.com/scrolltrigger/)

## 📝 Notes

- Semua animasi menggunakan GSAP untuk performa optimal
- Responsive design menggunakan Tailwind CSS
- No additional dependencies diperlukan
- Pure vanilla JavaScript (no frameworks)

## 🤝 Support

Jika ada pertanyaan atau ingin menambah fitur:

1. Edit `landing_page.php` untuk HTML
2. Edit `style/landing.css` untuk styling
3. Edit `js/landing-animations.js` untuk animasi

---

**Created with ❤️ using Tailwind CSS & GSAP**
