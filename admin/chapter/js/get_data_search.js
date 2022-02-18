'use strict';

//// DOM elements
const formSearch = document.querySelector('#form-search');
const inputSearch = document.querySelector('#input-search');
const pagination = document.querySelector('.pagination');
const row = document.querySelector('#row');
const spinner = document.querySelector('.load-spinner');

let currentPage = 1;

const init = (() => {
  //// Init state
  const state = {
    searchValue: '',
    page: 1,
    nop: 5,
    window: 5,
    totalPage: 0,
    role: 0,
  };
  state.distance = Math.floor(state.window / 2);

  //// Ajax
  const timeout = function (sec) {
    return new Promise((_, reject) =>
      setTimeout(() => reject(new Error('Request took too long!')), sec * 1000)
    );
  };
  //
  const ajaxSearch = async function (page, search = '') {
    try {
      this.toggleRenderSpinner();
      if (search.includes('%')) search = '';
      ////
      const url = './process/get_search_query.php';
      const options = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ page, search }),
      };
      //// Response
      const res = await Promise.race([fetch(url, options), this.timeout(5)]);

      if (!res.ok) throw new Error(`${res.statusText} (${res.status})`);

      //// Data
      const dataArray = await res.json();

      //// Clear Table
      while (row.nextElementSibling) {
        row.nextElementSibling.remove();
      }

      // console.log(dataArray);
      //// Assign state
      const info = dataArray[1];
      state.totalPage = info.total_page;
      if (currentPage > info.total_page) currentPage = info.total_page;
      state.page = currentPage;
      state.nop = info.nop;
      state.window = info.window;
      state.role = info.role;

      //// Data
      const data = dataArray[0];

      this.toggleRenderSpinner();

      //// Render pagination
      this.renderPagination(state.totalPage, state.nop);

      //// Render Table
      this.renderTable(data);

      //// Change URL
      if (!info.search) {
        history.pushState(null, '', 'search.php');
      } else {
        const urlSearch = `?search=${info.search}`;
        history.pushState(null, '', urlSearch);
      }
    } catch (err) {
      this.toggleRenderSpinner();
      this.renderError(err.message);
      console.log(err);
    }
  };

  //// Renders
  // Render Pagination
  const renderPagination = function () {
    let minLeft = state.page - state.distance;
    let maxRight = state.page + state.distance;

    if (minLeft < 1) {
      minLeft = 1;
      maxRight = state.window;
    }

    if (maxRight > state.totalPage) {
      maxRight = state.totalPage;

      minLeft = maxRight - (state.window - 1);
      if (minLeft < 1) {
        minLeft = 1;
      }
    }

    // Render
    let paginationHTML = '';
    for (let i = minLeft; i <= maxRight; ++i) {
      paginationHTML += `
        <button class="btn__page ${
          i === +state.page ? 'btn__page--active' : ''
        }" data-page="${i}">
        ${i}
        </button>
      `;
    }

    // First button
    if (state.page > 1 + state.distance) {
      paginationHTML =
        `<button class="btn__page btn__page--special" data-page="1">&#171; First</button>` +
        paginationHTML;
    }

    // Last button
    if (state.page < state.totalPage - state.distance) {
      paginationHTML += `<button class="btn__page btn__page--special" data-page="${state.totalPage}">Last &#187;</button>`;
    }

    pagination.innerHTML = paginationHTML;
  };
  // Render Table
  const renderTable = function (data) {
    let html = '';
    data.forEach(function (item) {
      html += `
        <tr>
          <td>${item.n_name}</td>
          <td>${item.a_name}</td>
          <td>${item.chap}</td>
          <td><p>${item.chapter_content}</p></td>
        `;
      if (state.role === 1) {
        html += `
          <td>${
            item.verify === 0
              ? `<a class="verify" href="view.php?chap_id=${item.chap_id}"><i class="fas fa-check-square"></i></a>`
              : 'Đã duyệt '
          }  
          </td>

          <td><a href="delete.php?chap_id=${
            item.chap_id
          }"><i class="fas fa-trash-alt"></i></a>
          </td>
        `;
      } else {
        html += `
            <td>
              ${item.verify === 0 ? 'Chưa duyệt ❌' : 'Đã duyệt ✅'}  
            </td>

            <td>
            <a href="update.php?chap_id=${
              item.chap_id
            }"><i class="fas fa-edit"></i></a>
            </td>

            <td><a href="delete.php?chap_id=${
              item.chap_id
            }"><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
        `;
      }
    });
    row.insertAdjacentHTML('afterend', html);
  };

  const renderError = function (message) {
    const p = document.createElement('p');
    p.className = 'form__error--message';
    p.textContent = message;
    formSearch.appendChild(p);
  };

  const toggleRenderSpinner = function () {
    spinner.classList.toggle('hidden');
  };

  //// Start
  const start = function () {
    state.searchValue = window.location.search.slice(8);
    this.ajaxSearch(1, state.searchValue);
  };

  return {
    timeout,
    ajaxSearch,
    renderPagination,
    renderTable,
    renderError,
    toggleRenderSpinner,
    start,
  };
})();

init.start();

//// Event handlers
// Pagination
pagination.addEventListener('click', function (e) {
  const btnPages = e.target.closest('.btn__page');
  if (!btnPages) return;

  let page = +btnPages.dataset.page;
  if (!isFinite(page)) page = Number.parseInt(page) || 1;
  currentPage = page;

  const searchValue = inputSearch.value;

  init.ajaxSearch(currentPage, searchValue);
});

// formSearch
formSearch.addEventListener('submit', function (e) {
  e.preventDefault();

  const searchValue = inputSearch.value;

  init.ajaxSearch(currentPage, searchValue);
});
