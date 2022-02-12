'use strict';

let menuBar = document.querySelector('#menu__bar');
let menu = document.querySelector('.menu');
let formProcesses = document.querySelectorAll('.form__process');
let formTitle = document.querySelector('.form__title');
let btnDel = document.querySelector('#btn_del');
let menuRightItems = document.querySelectorAll('.menu__right--item');
let notiBtn = document.querySelector('.noti');

let formTitleContent = formTitle?.innerText;
if (formTitleContent) {
  menuRightItems.forEach(item => {
    if (formTitleContent.includes(item.innerText)) {
      item.classList.add('active');
    }
  });
}

menuBar.addEventListener('click', function () {
  menu.classList.toggle('menu--transform');
  formProcesses.forEach(item => {
    item.classList.toggle('form-ttl');
  });
});

if (btnDel) {
  btnDel.addEventListener('click', function (e) {
    let isDel = confirm('Bạn muốn xóa truyện này?');
    if (!isDel) {
      e.preventDefault();
    }
  });
}

notiBtn.onclick = function () {
  this.classList.toggle('active');
  this.classList.toggle('muted');
};
