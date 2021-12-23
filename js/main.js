'use strict';
const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

let menuBar = $("#menu__bar");
let menu = $('.menu')
let formProcesses = $$('.form__process')
let formTitle = $('.form__title')
let btnDel = $('#btn_del')
let menuRightItems = $$('.menu__right--item')
let notiBtn = $('.noti')

let formTitleContent = formTitle.innerText
menuRightItems.forEach((item) => {
    if(formTitleContent.includes(item.innerText)) {
        item.classList.add('active')
    }
})

menuBar.addEventListener("click", function() {
    menu.classList.toggle('menu--transform')
    formProcesses.forEach((item) => {
        item.classList.toggle('form-ttl')
    })
})

if(btnDel) {
    btnDel.addEventListener('click', function(e) {
        let isDel = confirm('Bạn muốn xóa truyện này?')
        if(!isDel) {
            e.preventDefault()
        }
    })
}

notiBtn.onclick = function() {
    this.classList.toggle('active')
    this.classList.toggle('muted')
}