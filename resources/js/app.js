import "../css/app.scss";
import "bootstrap";
import DataTable from "datatables.net-dt";
import languagePTBR from "datatables.net-plugins/i18n/pt-BR.mjs";

document.addEventListener('DOMContentLoaded', () => {
  let table = initTable();
  /**
   * @type {HTMLFormElement} form
   */
  const formCalculate = document.forms["form-calculate"];
  formCalculate.addEventListener("submit", (event) => {
    event.preventDefault();
    const calculate = document.getElementById("btn-calculate");
    calculate.disabled = true;
    let beforeSendText = calculate.innerHTML;
    calculate.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Aguarde...`;
    const formData = new FormData(formCalculate);
    fetch(formCalculate.action, {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          return response.json();
        } else {
          alert("Erro ao realizar operação. Tente novamente");
          return {};
        }
      })
      .then((result) => {
        formCalculate.reset();
        reset();
        calculate.disabled = false;
        calculate.innerHTML = beforeSendText;
      });
  });

  function initTable() {
    return new DataTable("#calculate-table", {
      language: languagePTBR,
      serverSide: true,
      searching: false,
      ajax: '/list',
      columns: [
        {
          data: "origin",
          searchable: false,
          orderable: false,
        },
        {
          data: "destination",
          searchable: false,
          orderable: false,
        },
        {
          data: "distance",
          searchable: false,
          orderable: false,
        },
      ]
    });
  }

  function reset() {
    table.destroy();
    table = initTable();
  }

});
