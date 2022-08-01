'use strict';
const TabDivEl = document.querySelectorAll('.tab_div');

const tabClFunction = function (data, active) {
  data.classList[active]('active_tab_div');
  const child = [...data.children];
  child[0].classList[active]('active_tab');
};

const removeActiveEl = function () {
  TabDivEl.forEach((el) => {
    tabClFunction(el, 'remove');
  });
};

TabDivEl.forEach((el) => {
  el.addEventListener('click', function () {
    removeActiveEl();
    tabClFunction(el, 'add');
  });
});
