const ELEMENTOS = {
  tabelaVendas: document.getElementById("tabela-vendas"),
  totalDesconto: document.getElementById("total-desconto"),
  total: document.getElementById("total"),
  item: document.getElementById("item"),
  expositor: document.getElementById("expositor"),
  formaPagamento: document.getElementById("forma-pagamento"),
  valor: document.getElementById("valor"),
  formVendas: document.getElementById("form-vendas"),
};

function preencherCamposFormulario() {
  ELEMENTOS.item.value = "";
  ELEMENTOS.expositor.value = "";
  ELEMENTOS.formaPagamento.selectedIndex = 0;
  ELEMENTOS.valor.value = "";
}

function calcularDescontoPercentual(formaPagamento) {
  switch (formaPagamento) {
    case "Crédito parcelado":
      return 1.5;
    case "Débito":
      return 0.5;
    case "Crédito à vista":
      return 1;
    default:
      return 0;
  }
}

function calcularTotalExpositor(expositor) {
  let totalExpositor = 0;
  const linhas = ELEMENTOS.tabelaVendas.querySelectorAll("tr");
  for (let i = 1; i < linhas.length; i++) {
    const linha = linhas[i];
    const colunaExpositor = linha.children[2];
    const colunaValor = linha.children[6];
    if (colunaExpositor.textContent === expositor) {
      totalExpositor += parseFloat(colunaValor.textContent.replace(",", "."));
    }
  }
  return totalExpositor;
}

function adicionarVenda() {
  const item = ELEMENTOS.item.value;
  const expositor = ELEMENTOS.expositor.value;
  const formaPagamento = ELEMENTOS.formaPagamento.value;
  const valor = parseFloat(ELEMENTOS.valor.value.replace(",", "."));

  if (!item || !expositor || !formaPagamento || isNaN(valor)) {
    alert("Preencha todos os campos corretamente!");
    return;
  }

  const descontoPercentual = calcularDescontoPercentual(formaPagamento);
  const desconto = valor * (descontoPercentual / 100);
  const valorComDesconto = valor - desconto;

  const data = new Date().toLocaleDateString();
  const novaLinha = document.createElement("tr");
  novaLinha.innerHTML = `
    <td>${data}</td>
    <td>${item}</td>
    <td>${expositor}</td>
    <td>${formaPagamento}</td>
    <td>${valor.toFixed(2)}</td>
    <td>${desconto.toFixed(2)}</td>
    <td>${valorComDesconto.toFixed(2)}</td>
  `;
  ELEMENTOS.tabelaVendas.appendChild(novaLinha);

  const totalExpositor = calcularTotalExpositor(expositor);
  ELEMENTOS.totalDesconto.textContent = descontoPercentual.toFixed(2) + "%";
  ELEMENTOS.total.textContent = totalExpositor.toFixed(2);

  preencherCamposFormulario();
}

function handleSubmit(event) {
  event.preventDefault();
  adicionarVenda();
}

ELEMENTOS.formVendas.addEventListener("submit", handleSubmit);
