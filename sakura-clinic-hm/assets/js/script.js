"use strict";

/* ===============================================
# ドロワーメニュー
=============================================== */
document.addEventListener("DOMContentLoaded", () => {
  const hamburgerButton = document.querySelector(".js-hamburger");
  const drawer = document.querySelector(".drawer");
  const body = document.body;
  const breakpoint = 768;
  if (!drawer || !hamburgerButton) return;
  const DRAWER_TRANSITION_MS = 300;
  const toggleDrawer = (isOpen) => {
    if (isOpen) {
      drawer.classList.add("is-open");
      hamburgerButton.classList.add("is-open");
      body.classList.add("body-hidden");
      drawer.style.visibility = "hidden";
      drawer.style.height = "auto";
      const contentHeight = drawer.scrollHeight;
      const heightPx = Math.min(contentHeight, window.innerHeight);
      drawer.style.height = "";
      drawer.style.visibility = "";
      requestAnimationFrame(() => {
        drawer.style.setProperty("--drawer-height", `${heightPx}px`);
      });
    } else {
      drawer.style.setProperty("--drawer-height", "0");
      setTimeout(() => {
        drawer.classList.remove("is-open");
        hamburgerButton.classList.remove("is-open");
        body.classList.remove("body-hidden");
      }, DRAWER_TRANSITION_MS);
    }
  };
  hamburgerButton.addEventListener("click", () => {
    const isOpen = !drawer.classList.contains("is-open");
    toggleDrawer(isOpen);
  });
  drawer.querySelectorAll(".drawer__link").forEach((link) => {
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href");
      if (!href || href === "#") return;
      e.preventDefault();
      toggleDrawer(false);
      setTimeout(() => {
        window.location.href = href;
      }, DRAWER_TRANSITION_MS + 50);
    });
  });
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (window.innerWidth >= breakpoint) {
        toggleDrawer(false);
      }
    }, 100);
  });
});
/* ===============================================
# ヘッダーナビ：スクロールで該当セクションに current を付与
=============================================== */
document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".header__nav-link[href*='#']");
  if (!navLinks.length) return;
  const sections = [];
  navLinks.forEach((link) => {
    const href = link.getAttribute("href");
    const hash = href.split("#")[1];
    if (!hash) return;
    const section = document.getElementById(hash);
    const drawerLink = document.querySelector(`.drawer__link[href="${href}"]`);
    if (section) sections.push({ link, section, drawerLink });
  });
  if (!sections.length) return;
  
  // scroll-padding-top の値を取得（SP: 72px, PC: 95px）

  const getHeaderHeight = () => {
    const scrollPadding = getComputedStyle(document.documentElement).scrollPaddingTop;
    return parseInt(scrollPadding) || 72;
  };
  
  // 判定ライン：この高さがセクション内にあればそのセクションを current に（ヘッダー下から画面の15%）

  const getTriggerLine = () => {
    const h = getHeaderHeight();
    return h + (window.innerHeight - h) * 0.15;
  };
  let hasScrolled = false;
  let isNavigating = false;
  let scrollTicking = false;
  const setCurrent = (activePair) => {
    sections.forEach((s) => {
      s.link.classList.remove("current");
      if (s.drawerLink) s.drawerLink.classList.remove("current");
    });
    if (activePair) {
      activePair.link.classList.add("current");
      if (activePair.drawerLink) activePair.drawerLink.classList.add("current");
    }
  };
  const updateCurrentFromScroll = () => {
    if (isNavigating) return;
    const triggerLine = getTriggerLine();
    
    // 判定ラインが含まれるセクションを上から探す（最初にヒットした＝画面上で一番上）

    for (const pair of sections) {
      const rect = pair.section.getBoundingClientRect();
      if (rect.top <= triggerLine && rect.bottom >= triggerLine) {
        setCurrent(pair);
        return;
      }
    }
    setCurrent(null);
  };
  window.addEventListener(
    "scroll",
    () => {
      hasScrolled = true;
      if (!hasScrolled || isNavigating) return;
      if (!scrollTicking) {
        scrollTicking = true;
        requestAnimationFrame(() => {
          updateCurrentFromScroll();
          scrollTicking = false;
        });
      }
    },
    { passive: true }
  );
  
  // アンカーリンククリック（ヘッダー・ドロワー両方）

  const allNavLinks = document.querySelectorAll(".header__nav-link[href*='#'], .drawer__link[href*='#']");
  allNavLinks.forEach((clickedLink) => {
    clickedLink.addEventListener("click", () => {
      const href = clickedLink.getAttribute("href");
      const hash = href == null ? void 0 : href.split("#")[1];
      const targetSection = document.getElementById(hash);
      const pair = sections.find((s) => s.link.getAttribute("href") === href);
      if (targetSection && pair) {
        isNavigating = true;
        hasScrolled = true;
        setCurrent(pair);
        setTimeout(() => {
          isNavigating = false;
          updateCurrentFromScroll();
        }, 500);
      }
    });
  });
});
/* ===============================================
# トップへ移動
=============================================== */
let toTopButton = document.querySelector(".to-top");
window.addEventListener("scroll", function() {
  let scrollPosition = window.scrollY || document.documentElement.scrollTop;
  if (scrollPosition > 300) {
    toTopButton.classList.add("js-active");
  } else {
    toTopButton.classList.remove("js-active");
  }
});
toTopButton.addEventListener("click", function() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});
/* ===============================================
# スクロールアニメーション
=============================================== */
document.addEventListener("DOMContentLoaded", () => {
  const COMMON_TRIGGER_RATIO = 0.85;
  function observeElements(selector, activeClass = "is-active", options = {}, keepActive = false) {
    const elements = document.querySelectorAll(selector);
    if (!elements.length) return;
    const triggerPoint = window.innerHeight * COMMON_TRIGGER_RATIO;
    const observer = new IntersectionObserver(
      (entries, observer2) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add(activeClass);
            if (!keepActive) {
              observer2.unobserve(entry.target);
            }
          } else if (!keepActive) {
            entry.target.classList.remove(activeClass);
          }
        });
      },
      options
    );
    elements.forEach((el) => {
      const rect = el.getBoundingClientRect();
      if (rect.top < triggerPoint) {
        el.classList.add(activeClass);
      } else {
        observer.observe(el);
      }
    });
  }
  function getRootMargin(pcMargin, spMargin) {
    return window.matchMedia("(min-width: 768px)").matches ? pcMargin : spMargin;
  }
  observeElements(".js-fade-in", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-fade-up", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-scaleImg", "is-active", {
    rootMargin: getRootMargin("0px 0px -20% 0px", "0px 0px -5% 0px")
  });
  observeElements(".js-news-list", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-circle", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-section-heading", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-facility-item", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
});
/* ===============================================
# 文字を1文字ずつ <span> に分割
=============================================== */
function wrapTextInSpans(selector) {
  document.querySelectorAll(selector).forEach((element) => {
    const text = element.textContent;
    element.setAttribute("aria-label", text);
    element.setAttribute("role", "text");
    element.textContent = "";
    [...text].forEach((char, index) => {
      const span = document.createElement("span");
      span.textContent = char;
      span.style.setProperty("--index", index);
      span.setAttribute("aria-hidden", "true");
      element.appendChild(span);
    });
  });
}
wrapTextInSpans(".js-text-split");
