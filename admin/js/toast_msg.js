'use strict';

const toastContainer = document.querySelector('#toast');

function showToast(options) {
  if (toastContainer) {
    // Icon
    const icons = {
      success: '✔',
      info: '❕',
      warning: '⚠',
      error: '❗',
    };
    const icon = icons[options.type];

    // Time delay animation
    const duration = options.duration ?? 5000;
    const delay = duration / 1000;

    // Create new toast element
    const toast = document.createElement('div');

    // Add class + animation
    toast.classList.add('toast', `toast--${options.type}`);
    toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

    toast.innerHTML = `
      <div class="toast__icon">
        ${icon}
      </div>
      <div class="toast__body">
        <h3 class="toast__title">${options.title}</h3>
        <p class="toast__msg">${options.message}</p>
      </div>
      <div class="toast__close">
        ✖
      </div> 
    `;

    // appendChild for toastContainer
    toastContainer.appendChild(toast);

    // Auto remove toast
    const autoRemove = setTimeout(
      () => toastContainer.removeChild(toast),
      duration + 1000
    );

    // Remove toast when click
    toast.addEventListener('click', e => {
      if (e.target.closest('.toast__close')) {
        toastContainer.removeChild(toast);
        clearTimeout(autoRemove);
      }
    });
  }
}
