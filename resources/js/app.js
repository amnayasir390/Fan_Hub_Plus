import './bootstrap';

/* Replace legacy emoji labels with the site's Font Awesome icon language. */
const emojiIcons = new Map([
  ['😀', 'fa-face-smile'], ['👋', 'fa-hand'], ['🌙', 'fa-moon'], ['☀️', 'fa-sun'], ['☀', 'fa-sun'],
  ['⚡', 'fa-bolt'], ['📊', 'fa-chart-line'], ['📄', 'fa-file-lines'], ['📝', 'fa-pen-to-square'],
  ['✍️', 'fa-pen-to-square'], ['✍', 'fa-pen-to-square'], ['👥', 'fa-users'], ['👤', 'fa-user'],
  ['🎬', 'fa-film'], ['🛍️', 'fa-bag-shopping'], ['🛍', 'fa-bag-shopping'], ['📅', 'fa-calendar-days'],
  ['🗓️', 'fa-calendar-days'], ['🗓', 'fa-calendar-days'], ['📨', 'fa-envelope'], ['💬', 'fa-comments'],
  ['🤖', 'fa-robot'], ['🌐', 'fa-globe'], ['🚪', 'fa-right-from-bracket'], ['🔖', 'fa-bookmark'],
  ['🔍', 'fa-magnifying-glass'], ['👁', 'fa-eye'], ['✅', 'fa-circle-check'], ['❌', 'fa-circle-xmark'],
  ['✗', 'fa-xmark'], ['✓', 'fa-check'], ['🗑', 'fa-trash'], ['🆕', 'fa-sparkles'], ['⏳', 'fa-hourglass-half'],
  ['📌', 'fa-thumbtack'], ['💾', 'fa-floppy-disk'], ['🔑', 'fa-key'], ['🔒', 'fa-lock'], ['📧', 'fa-envelope'],
  ['📋', 'fa-clipboard'], ['🎯', 'fa-bullseye'], ['❤️', 'fa-heart'], ['❤', 'fa-heart'], ['🔥', 'fa-fire'],
  ['⭐', 'fa-star'], ['★', 'fa-star'], ['☆', 'fa-star'], ['📍', 'fa-location-dot'], ['🗺️', 'fa-map'],
  ['🗺', 'fa-map'], ['🏛️', 'fa-building-columns'], ['🏛', 'fa-building-columns'], ['🎟️', 'fa-ticket'],
  ['🎟', 'fa-ticket'], ['🎭', 'fa-masks-theater'], ['🛒', 'fa-cart-shopping'], ['▶️', 'fa-play'],
  ['▶', 'fa-play'], ['🎵', 'fa-music'], ['🖼️', 'fa-image'], ['🖼', 'fa-image'], ['👍', 'fa-thumbs-up'],
  ['👎', 'fa-thumbs-down'], ['💡', 'fa-lightbulb'], ['❓', 'fa-circle-question'], ['🐛', 'fa-bug'],
  ['🌅', 'fa-sun'], ['🚀', 'fa-rocket'], ['←', 'fa-arrow-left'], ['→', 'fa-arrow-right'], ['✕', 'fa-xmark'],
]);

const emojiPattern = new RegExp(
  [...emojiIcons.keys()].sort((a, b) => b.length - a.length).map(emoji => emoji.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')).join('|'),
  'gu'
);

function replaceEmojiText(root = document.body) {
  const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
  const textNodes = [];
  while (walker.nextNode()) textNodes.push(walker.currentNode);

  textNodes.forEach(node => {
    if (!emojiPattern.test(node.nodeValue)) {
      emojiPattern.lastIndex = 0;
      return;
    }
    emojiPattern.lastIndex = 0;
    const fragment = document.createDocumentFragment();
    let lastIndex = 0;
    node.nodeValue.replace(emojiPattern, (emoji, offset) => {
      fragment.append(node.nodeValue.slice(lastIndex, offset));
      const icon = document.createElement('i');
      icon.className = `fa-solid ${emojiIcons.get(emoji)}`;
      icon.setAttribute('aria-hidden', 'true');
      icon.style.marginInlineEnd = '0.25em';
      fragment.append(icon);
      lastIndex = offset + emoji.length;
      return emoji;
    });
    fragment.append(node.nodeValue.slice(lastIndex));
    node.replaceWith(fragment);
  });
}

function initEmojiIcons() {
  replaceEmojiText();
  const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => mutation.addedNodes.forEach(node => {
      if (node.nodeType === Node.TEXT_NODE) replaceEmojiText(node.parentElement);
      else if (node.nodeType === Node.ELEMENT_NODE) replaceEmojiText(node);
    }));
  });
  observer.observe(document.body, { childList: true, subtree: true });
}

/* ── Page Loader ─────────────────────────────────────────────────────── */
window.addEventListener('load', () => {
  const loader = document.getElementById('page-loader');
  if (loader) {
    loader.classList.add('hidden');
    setTimeout(() => loader.remove(), 500);
  }
});

/* ── Dark / Light Mode Toggle ────────────────────────────────────────── */
function applyTheme(dark) {
  document.body.classList.toggle('light-mode', !dark);
  const icon = document.getElementById('theme-icon');
  if (icon) icon.innerHTML = `<i class="fa-solid ${dark ? 'fa-moon' : 'fa-sun'}" aria-hidden="true"></i>`;
}

function initTheme() {
  const saved = localStorage.getItem('fhp_dark_mode');
  const dark  = saved === null ? true : saved === 'true';
  applyTheme(dark);
}

window.toggleTheme = function () {
  const isDark = !document.body.classList.contains('light-mode');
  const newDark = !isDark;
  localStorage.setItem('fhp_dark_mode', newDark);
  applyTheme(newDark);
};

/* ── Font Size ───────────────────────────────────────────────────────── */
function applyFontSize(size) {
  document.body.classList.remove('font-small', 'font-medium', 'font-large');
  document.body.classList.add('font-' + size);
}

function initFontSize() {
  const saved = localStorage.getItem('fhp_font_size') || 'medium';
  applyFontSize(saved);
  const sel = document.getElementById('font-size-select');
  if (sel) sel.value = saved;
}

window.setFontSize = function (size) {
  localStorage.setItem('fhp_font_size', size);
  applyFontSize(size);
};

/* ── Mobile Nav ──────────────────────────────────────────────────────── */
window.toggleMobileNav = function () {
  const nav = document.getElementById('mobile-nav');
  if (nav) nav.classList.toggle('open');
  document.body.classList.toggle('overflow-hidden');
};

/* ── Flash Message Auto-dismiss ──────────────────────────────────────── */
function initFlashMessages() {
  document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
    const delay = parseInt(el.dataset.autoDismiss) || 4000;
    setTimeout(() => {
      el.style.opacity = '0';
      el.style.transition = 'opacity 0.5s';
      setTimeout(() => el.remove(), 500);
    }, delay);
  });
}

/* ── Chatbot ─────────────────────────────────────────────────────────── */
function initChatbot() {
  const toggle  = document.getElementById('chatbot-toggle');
  const window_ = document.getElementById('chatbot-window');
  const form    = document.getElementById('chatbot-form');
  const input   = document.getElementById('chatbot-input');
  const msgs    = document.getElementById('chatbot-messages');

  if (!toggle || !window_) return;

  toggle.addEventListener('click', () => {
    window_.classList.toggle('open');
    if (window_.classList.contains('open') && msgs && msgs.children.length === 0) {
      appendMessage('bot', '👋 Hey there! I\'m your Fan Hub Plus guide. Ask me about categories, bookmarks, events, merchandise, or anything about the platform!');
    }
  });

  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msg = input.value.trim();
      if (!msg) return;
      appendMessage('user', msg);
      input.value = '';

      // Typing indicator
      const typing = appendMessage('bot', '…', true);

      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const res = await fetch('/chatbot/message', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
          },
          body: JSON.stringify({ message: msg }),
        });
        const data = await res.json();
        typing.remove();
        appendMessage('bot', data.response || 'Sorry, I couldn\'t process that.');
      } catch {
        typing.remove();
        appendMessage('bot', 'Connection error. Please try again.');
      }
    });
  }

  function appendMessage(role, text, isTyping = false) {
    if (!msgs) return null;
    const div = document.createElement('div');
    div.className = `chat-msg ${role}`;
    div.innerHTML = `<div class="chat-bubble">${text}</div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    return div;
  }
}

/* ── Bookmark Toggle (AJAX) ──────────────────────────────────────────── */
function initBookmarkButtons() {
  document.querySelectorAll('[data-bookmark-btn]').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const type = btn.dataset.type;
      const id   = btn.dataset.id;
      const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

      try {
        const res = await fetch('/bookmarks/toggle', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
          },
          body: JSON.stringify({ type, id }),
        });
        const data = await res.json();
        btn.classList.toggle('active', data.bookmarked);
        btn.title = data.bookmarked ? 'Remove bookmark' : 'Add bookmark';
      } catch {
        console.error('Bookmark error');
      }
    });
  });
}

/* ── Star Rating ─────────────────────────────────────────────────────── */
function initStarRating() {
  document.querySelectorAll('.star-rating-interactive').forEach(container => {
    const stars = container.querySelectorAll('.star');
    const input = container.querySelector('input[name="score"]');
    stars.forEach((star, i) => {
      star.addEventListener('mouseenter', () => {
        stars.forEach((s, j) => s.classList.toggle('filled', j <= i));
      });
      star.addEventListener('mouseleave', () => {
        const val = parseInt(input?.value || 0);
        stars.forEach((s, j) => s.classList.toggle('filled', j < val));
      });
      star.addEventListener('click', () => {
        if (input) input.value = i + 1;
        stars.forEach((s, j) => s.classList.toggle('filled', j <= i));
      });
    });
  });
}

/* ── Smooth transitions on nav ───────────────────────────────────────── */
function initPageTransitions() {
  document.querySelectorAll('a[href]').forEach(a => {
    const href = a.getAttribute('href');
    if (href && !href.startsWith('#') && !href.startsWith('http') && !href.startsWith('mailto') && !a.hasAttribute('data-no-transition')) {
      a.addEventListener('click', (e) => {
        // Let browser handle normally but add body class for fade
        document.body.style.opacity = '0.8';
        document.body.style.transition = 'opacity 0.15s';
      });
    }
  });
}

/* ── Init ────────────────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  initEmojiIcons();
  initTheme();
  initFontSize();
  initFlashMessages();
  initChatbot();
  initBookmarkButtons();
  initStarRating();
  initPageTransitions();
  document.body.style.opacity = '1';
  document.body.style.transition = 'opacity 0.2s';
});
