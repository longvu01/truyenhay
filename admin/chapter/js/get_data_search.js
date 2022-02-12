'use strict';

//// DOM elements
const formSearch = document.querySelector('#form-search');
const inputSearch = document.querySelector('#input-search');
const pagination = document.querySelector('.pagination');
const row = document.querySelector('#row');

//// Init state
const state = {
  searchValue: window.location.search.slice(8),
  page: 1,
  nop: 5,
  window: 5,
  totalPage: 0,
};
state.distance = Math.floor(state.window / 2);

//// Ajax
const timeout = sec =>
  new Promise((_, reject) =>
    setTimeout(() => reject(new Error('Request took too long!')), sec * 1000)
  );

const ajaxSearch = async function (page, search = '') {
  try {
    // if (search.includes('%')) search = '';
    const url = './process/get_search_query.php';
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ page, search }),
    };
    //// Response
    const res = await Promise.race([fetch(url, options), timeout(5)]);

    if (!res.ok) throw new Error(`${res.statusText} (${res.status})`);

    //// Data
    const data = await res.json();

    // console.log(data);
    //// Assign state
    state.nop = data.nop;
    state.window = data.window;
    state.totalPage = data.total_page;

    //// Clear Table
    while (row.nextElementSibling) {
      row.nextElementSibling.remove();
    }

    //// Render Table
    renderTable(data, data.chap.length);

    //// Render pagination
    renderPagination(state.totalPage, state.nop);

    //// Change URL
    if (!data.search) {
      history.pushState(null, '', 'search.php');
    } else {
      const urlSearch = `?search=${data.search}`;
      history.pushState(null, '', urlSearch);
    }
  } catch (err) {
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
const renderTable = function (data, length) {
  let html = '';
  for (let i = 0; i < length; ++i) {
    html += `
      <tr>
        <td>${data.n_name[i]}</td>
        <td>${data.chap[i]}</td>
        <td><p>${data.chapter_content[i]}</p></td>
      `;
    if (data.role === 1) {
      html += `
        <td>${
          data.verify[i] === 0
            ? `<a class="verify" href="view.php?chap_id=${data.chap_id[i]}"><i class="fas fa-check-square"></i></a>`
            : 'Đã duyệt '
        }  
        </td>

        <td><a href="delete.php?chap_id=${
          data.chap_id[i]
        }"><i class="fas fa-trash-alt"></i></a>
        </td>
      `;
    } else {
      html += `
        <td>
          ${data.verify[i] === 0 ? 'Chưa duyệt ❌' : 'Đã duyệt ✅'}  
        </td>

        <td>
        <a href="update.php?chap_id=${
          data.chap_id[i]
        }"><i class="fas fa-edit"></i></a>
        </td>

        <td><a href="delete.php?chap_id=${
          data.chap_id[i]
        }"><i class="fas fa-trash-alt"></i></a>
        </td>
      </tr>
      `;
    }
  }
  row.insertAdjacentHTML('afterend', html);
};

//// Event handlers
// Pagination
pagination.addEventListener('click', function (e) {
  const btnPages = e.target.closest('.btn__page');

  if (!btnPages) return;

  state.page = +btnPages.dataset.page;

  ajaxSearch(state.page, state.searchValue);
});

// formSearch
formSearch.addEventListener('submit', function (e) {
  e.preventDefault();

  state.searchValue = inputSearch.value;

  ajaxSearch(state.page, inputSearch.value);
});

//// Start
ajaxSearch(1, state.searchValue);
