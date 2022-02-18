import { timeout, AJAX } from '../../assets/js/helper';
import Validator from '../../assets/js/validator.js';

//// DOM elements
const table = document.querySelector('#table');
const spinner = document.querySelector('.load-spinner');
const btnShowMore = document.querySelector('.btn__show-more');
const firstRow = document.querySelector('#first-row');

const urlInsert = './process/process_insert.php';
const urlDelete = './process/process_delete.php';

////
let offset = 0;

const init = (() => {
  const getData = async function (offset) {
    try {
      this.toggleRenderSpinner();
      ////
      const data = await AJAX('./process/process_get_data.php', {
        offset,
      });

      if (data.length < 5) btnShowMore.remove();

      this.toggleRenderSpinner();
      //// Render Table
      this.renderTable(data);
    } catch (err) {
      this.toggleRenderSpinner();
      this.renderError(err.message);
      console.log(err);
    }
  };
  const mutateData = async function (
    data,
    url = './process/process_update.php'
  ) {
    try {
      const {
        info_title: title,
        info_message: message,
        info_type: type,
        id_delete: idDel,
        id_insert: idInsert,
        category_name,
      } = await AJAX(url, data);

      showToast({
        title,
        message,
        type,
      });
      if (idDel) document.querySelector(`#row-update-${idDel}`).remove();
      if (idInsert) {
        const html = render({ id: idInsert, category_name });
        firstRow.insertAdjacentHTML('afterend', html);
      }
    } catch (err) {
      this.renderError(err.message);
      console.log(err);
    }
  };

  //// Renders
  const render = data => `
    <tr class="row-update" id="row-update-${data.id}">
        <td>
            <input type="hidden" name="id" value="${data.id}"/>
            <div class="form-group">
                <input class = "category__name-input form-control" name="category_name" value="${data.category_name}"/>
                <span class="form-message"></span>
            </div>
        </td>

        <td>
            <button class="btn-update"><i class="fas fa-edit"></i></button>
        </td>

        <td>
            <button data-delete-id="${data.id}" class="btn-delete"><i class="fas fa-trash-alt"></i></button>
        </td>
    </tr>
  `;
  // Render Table
  const renderTable = function (data) {
    let html = '';
    html = data.map(render).join('');
    table.insertAdjacentHTML('beforeend', html);
  };

  const renderError = function (message) {
    const p = document.createElement('p');
    p.className = 'form__error--message';
    p.textContent = message;
    table.appendChild(p);
  };

  const toggleRenderSpinner = function () {
    spinner.classList.toggle('hidden');
  };

  return {
    timeout,
    getData,
    mutateData,
    renderTable,
    renderError,
    toggleRenderSpinner,
  };
})();

init.getData(0);

//// isValid variables for submit form update
let isValid = true;
//// Event handlers

btnShowMore.addEventListener('click', function () {
  offset += 5;
  init.getData(offset);
});

table.addEventListener('click', function (e) {
  const btnUpdate = e.target.closest('.btn-update');
  const btnDelete = e.target.closest('.btn-delete');

  if (btnUpdate) {
    const rowUpdate = btnUpdate.closest('.row-update');

    const id = rowUpdate.querySelector(`input[name="id"]`).value;
    const categoryName = rowUpdate.querySelector(
      `input[name="category_name"]`
    ).value;

    if (isValid) init.mutateData({ id, category_name: categoryName });
  }

  if (btnDelete) {
    const id = btnDelete.dataset.deleteId;
    init.mutateData({ id }, urlDelete, id);
  }
});

table.addEventListener('mouseover', function (e) {
  const updateInput = e.target.closest('.category__name-input');
  if (updateInput) {
    const formGroup = updateInput.closest('.form-group');
    const errorElement = formGroup.querySelector('.form-message');

    function showError() {
      errorElement.textContent = 'Vui lòng nhập trường này';
      formGroup.classList.add('invalid');
      showToast({
        title: 'Thiếu thông tin!',
        message: 'Tên thể loại không được để trống!',
        type: 'warning',
      });
      isValid = false;
    }
    function clearError() {
      errorElement.textContent = '';
      formGroup.classList.remove('invalid');
      isValid = true;
    }
    function handleValidate() {
      if (!updateInput.value.trim()) showError();
      else clearError();
    }

    updateInput.oninput = handleValidate;
    // updateInput.onblur = handleValidate;
  }
});

const formAddData = new Validator('#form-add');
formAddData.onSubmit = data => {
  init.mutateData(data, urlInsert);
  document.querySelector('#category_name').value = '';
};
