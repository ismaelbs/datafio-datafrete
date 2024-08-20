import "../css/app.scss";
import "bootstrap";
import DataTable from "datatables.net-dt";
import languagePTBR from "datatables.net-plugins/i18n/pt-BR.mjs";

document.addEventListener("DOMContentLoaded", () => {
  let table = initTable();

  setTimeout(() => {
    table.destroy();
    table = initTable();
  }, 1000 * 60);
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
          alert("Erro ao realizar operação. Tente novamente");
          return {};
        }
        return response.json();
      })
      .finally(() => {
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
      orderMulti: false,
      ordering: false,
      ajax: "/list",
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
      ],
    });
  }

  function reset() {
    table.destroy();
    table = initTable();
  }

  /**
   * @type {HTMLFormElement}
   */
  const importarCepsForm = document.forms["importar-cep"];
  importarCepsForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const formData = new FormData(importarCepsForm);
    fetch("/import", {
      method: "POST",
      body: formData,
      headers: {
        encType: "multipart/form-data",
      },
    })
      .then((response) => {
        if (!response.ok) {
          alert("Erro ao realizar operação. Tente novamente");
          return {};
        }
      })
      .then(() => {
        alert("Importado com sucesso!, Aguarde até todos os dados serem carregados");
        reset();
      });
  });
});
